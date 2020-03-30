<?php

namespace humhub\modules\weather\notifications;

use Yii;
use humhub\modules\notification\components\NotificationCategory;

/**
 * Description of AdminNotificationCategory
 *
 * @author buddha
 */
class WeatherNotificationCategory extends NotificationCategory
{

    public $id = 'weather';

    public $sortOrder = 100;

    public function getDescription()
    {
        return Yii::t('WeatherModule.notification', 'Receive Notifications new versions of the Weather module.');
    }

    public function getTitle()
    {
        return Yii::t('WeatherModule.notification', 'Weather Module Updates');
    }

}
