<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\weather\notifications;

use Yii;
use yii\helpers\Url;
use yii\bootstrap\Html;
use humhub\modules\notification\components\BaseNotification;
use humhub\modules\weather\libs\HumHubAPI;

/**
 * HumHubUpdateNotification
 *
 * Notifies about new HumHub Version
 *
 * @since 0.11
 */
class NewVersionAvailable extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'weather';

    /**
     * @inheritdoc
     */
    public $requireOriginator = false;

    /**
     * @inheritdoc
     */
    public $requireSource = false;

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return Url::to(['@web/marketplace/update']);
    }

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new WeatherNotificationCategory;
    }

    /**
     * @inheritdoc
     */
    public function getLatestVersion()
    {
        return HumHubAPI::getLatestVersion();
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return Yii::t('WeatherModule.notification', "There is an update for the Weather module!", ['version' => Html::tag('strong', $this->getLatestVersion())]);
    }

}

?>
