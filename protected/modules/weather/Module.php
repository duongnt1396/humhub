<?php

namespace humhub\modules\weather;

use Yii;
use yii\helpers\Url;
use humhub\modules\weather\notifications\NewVersionAvailable;

class Module extends \humhub\components\Module
{

    /**
     * @var boolean check daily for new HumHub version
     */
    public $dailyCheckForNewVersion = true;

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/weather/admin/index']);
    }

    public function getServerUrl()
    {
        $url = $this->settings->get('serverUrl');
        if (empty($url)) {
            return 'https://forecast7.com';
        }
        return $url;
    }

    public function getLocation()
    {
        $location = $this->settings->get('location');
        if (empty($location)) {
            return '';
        }
        return $location;
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
        if (Yii::$app->user->isAdmin()) {
            return [
                NewVersionAvailable::class
            ];
        }

        return [];
    }
}
