<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\AuthDateProviderInterface;
use app\models\events\AdminEnteredEvent;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model implements AuthDateProviderInterface
{
    /**
     * @var string $username Username field
     */
    public $username;
    /**
     * @var string $password Password field
     */
    public $password;
    /**
     * @var string $verifyCode Code verification field filed
     */
    public $verifyCode;
    /**
     * @var bool $rememberMe Username field
     */
    public $rememberMe = true;
    /**
     * @var bool $_user Users access status
     */
    private $_user = false;

    /**
     * Validation rules
     *
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * Sets fields names
     *
     * @return array customized attribute labels
     */
    public function attributeLabels(): array
    {
        return [
          'username'   => 'Login',
          'password'   => 'Password',
          'verifyCode' => 'Verification Code',
          'rememberMe' => 'Remember Me'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, ?array $params): void
    {
        // Checking, whether password successfully validated
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            // If password validation is failed
            if (!$user || !$user->validatePassword($this->password)) {

                // Adding an error
                $this->addError($attribute, self::AUTH_ERROR_MESSAGE);
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        // Checking, whether user marked "Remember me" flag
        if($this->rememberMe) {
            $auth = $this->getUser();
            $auth->generateAuthKey();
            $auth->save();
        }

        // Checking, whether user data validation is successful
        if ($this->validate()) {

            // Creating
            $event = new AdminEnteredEvent();

            // Filling the user field by username
            $event->user = $this->username;

            // Filling the subject by a custom message about user system entrance
            $event->subject = "User {$event->user} has just entered to the system";

            $user = new User();

            // Обрабатывем событие USER_ENTERED и передаем объект класса AdminEnteredEvent, который должен наследовать yii\base\Event
            $user->trigger($user::USER_ENTERED, $event);

            // Logging a user
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? self::REMEMBER_USER_TIME : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser(): User
    {
        // Checking, whether user is logged
        if ($this->_user === false) {

            // Looking for a user by username
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
