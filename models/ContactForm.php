<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\MailerInterface;


/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model implements MailerInterface
{
    /**
     * @var string $name Name filed
     */
    public $name;
    /**
     * @var string $email Email filed
     */
    public $email;
    /**
     * @var string $subject Subject filed
     */
    public $subject;
    /**
     * @var string $body Body filed
     */
    public $body;
    /**
     * @var string $verifyCode Code verification field filed
     */
    public $verifyCode;

    /**
     * Validation rules
     *
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
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
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * {@inheritdoc}
     */
    public function contact(string $email): bool
    {
        // Checking, whether completed validation
        if ($this->validate()) {
            // Yii2 mailing component
            Yii::$app->mailer->compose()
                             ->setTo($email)
                             ->setFrom([$this->email => $this->name])
                             ->setSubject($this->subject)
                             ->setTextBody($this->body)
                             ->send();
            return true;
        }

        return false;
    }
}
