<?php

namespace app\components;

use Yii;
use yii\base\Component;

/**
 * Class EmailService
 *
 * @package app\components
 */
class EmailService extends Component
{
    /**
     * Notifies admin when he entered to the system
     *
     * @param UserNotificationInterface $event
     * @return bool
     */
    public function notifyUser(UserNotificationInterface $event)
    {
        return Yii::$app->mailer->compose()
                                ->setFrom('ishop@service.com')
                                ->setTo($event->getEmail())
                                ->setSubject($event->getSubject())
                                ->send();
    }
}
