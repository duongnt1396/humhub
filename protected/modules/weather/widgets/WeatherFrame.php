<?php

namespace humhub\modules\weather\widgets;

use Yii;
use humhub\components\Widget;

/**
 *
 * @author Felli
 */
class WeatherFrame extends Widget
{
    public $contentContainer;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $url = Yii::$app->getModule('weather')->getServerUrl() . '/';

        $location = Yii::$app->getModule('weather')->getLocation();

        return $this->render('weatherframe', ['weatherUrl' => $url, 'location' => $location]);
    }
}
