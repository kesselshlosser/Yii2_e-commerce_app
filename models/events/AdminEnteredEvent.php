<?php

namespace app\models\events;

use Yii;
use yii\base\Event;
use app\components\UserNotificationInterface;

/**
 * Class AdminEnteredEvent
 *
 * @package app\models\events
 */
class AdminEnteredEvent extends Event implements UserNotificationInterface
{
    /**
     * @var null User $user
     */
    public $user = null;

    /**
     * @var string $subject Mail subject
     */
    public $subject = null;

    /**
     * @return string Email subject
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string Admin email
     */
    public function getEmail(): string
    {
        return Yii::$app->params['adminEmail'];
    }
}
