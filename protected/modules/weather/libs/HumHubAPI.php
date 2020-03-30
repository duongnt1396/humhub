<?php

namespace humhub\modules\weather\libs;

use Yii;
use yii\helpers\Json;
use humhub\libs\CURLHelper;
use yii\base\InvalidArgumentException;

/**
 * HumHubAPI provides access to humhub.com for fetching available modules or latest version.
 *
 */
class HumHubAPI
{

    /**
     * HumHub API
     *
     * @param string $action
     * @param array $params
     * @return array
     */
    public static function request($action, $params = [])
    {
        if (!Yii::$app->params['humhub']['apiEnabled']) {
            return [];
        }

        $url = Yii::$app->params['humhub']['apiUrl'] . '/' . $action;
        $params['version'] = urlencode(Yii::$app->version);
        $params['installId'] = Yii::$app->getModule('weather')->settings->get('installationId');

        $url .= '?';
        foreach ($params as $name => $value) {
            $url .= urlencode($name) . '=' . urlencode($value)."&";
        }
        try {
            $http = new \Zend\Http\Client($url, [
                'adapter' => '\Zend\Http\Client\Adapter\Curl',
                'curloptions' => CURLHelper::getOptions(),
                'timeout' => 30
            ]);

            $response = $http->send();
            $json = $response->getBody();
        } catch (\Zend\Http\Client\Adapter\Exception\RuntimeException $ex) {
            Yii::error('Could not connect to HumHub API! ' . $ex->getMessage());
            return [];
        } catch (Exception $ex) {
            Yii::error('Could not get HumHub API response! ' . $ex->getMessage());
            return [];
        }

        try {
            return Json::decode($json);
        } catch (InvalidArgumentException $ex) {
            Yii::error('Could not parse HumHub API response! ' . $ex->getMessage());
            return [];
        }
    }

    /**
     * Fetch latest Module version online
     *
     * @return string latest Module Version
     */
    public static function getLatestVersion()
    {
        $latestVersion = Yii::$app->cache->get('latestVersion');
        if ($latestVersion === false) {
            $info = self::request('v1/modules/getLatestVersion');

            if (isset($info['latestVersion'])) {
                $latestVersion = $info['latestVersion'];
            }

            Yii::$app->cache->set('latestVersion', $latestVersion);
        }

        return $latestVersion;
    }

}
