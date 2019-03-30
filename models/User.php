<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @package app\models
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const USER_ENTERED = 'A user has entered to the system';

    public function init()
    {
        // Регистрируем событие.
        $this->on(self::USER_ENTERED, [Yii::$app->emailService, 'notifyUser']);
        parent::init();
    }


    /**
     * Sets a table name
     *
     * @return string
     */
    public static function tableName(): string
    {
        return 'user';
    }

    /**
     * Finds an identity by the given ID
     *
     * @param int $id The ID to be looked for
     * @return User
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token The token to be looked for
     * @param null $type The type of the token
     * @return void|IdentityInterface The identity object that matches the given token
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }

    /**
     * Looks for user by their name
     *
     * @param string $username
     * @return User User info
     */
    public static function findByUsername(string $username): self
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @return int An ID that uniquely identifies a user identity
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string A key that is used to check the validity of a given identity ID.
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key
     *
     * @param string $authKey The given auth key
     * @return bool Whether the given auth key is valid
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Checks whether passwords are valid
     *
     * @param string $password User password
     * @return bool Whether password is valid
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates auth key
     *
     * @throws \yii\base\Exception
     * @return void
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     *
     * @return string user email
     */
    public function getEmail(): string
    {
        return 'johndoe@example.com';
    }
}
