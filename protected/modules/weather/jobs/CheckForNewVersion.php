<?php

namespace humhub\modules\weather\jobs;

use humhub\modules\weather\libs\HumHubAPI;
use humhub\modules\weather\Module;
use humhub\modules\weather\notifications\NewVersionAvailable;
use humhub\modules\queue\ActiveJob;
use humhub\modules\user\models\Group;
use Yii;


/**
 * CheckForNewVersion checks for new HumHub version and sends a notification to
 * the administrators
 *
 */
class CheckForNewVersion extends ActiveJob
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var Module $weatherModule */
        $weatherModule = Yii::$app->getModule('weather');

        if (!$weatherModule->dailyCheckForNewVersion || !Yii::$app->params['humhub']['apiEnabled']) {
            return;
        }

        $latestVersion = HumHubAPI::getLatestVersion();

        if (!empty($latestVersion)) {

            $adminUserQuery = Group::getAdminGroup()->getUsers();

            $latestNotifiedVersion = $weatherModule->settings->get('lastVersionNotify');
            $adminsNotified = !($latestNotifiedVersion == "" || version_compare($latestVersion, $latestNotifiedVersion, ">"));
            $newVersionAvailable = (version_compare($latestVersion, Yii::$app->version, ">"));

            $updateNotification = new NewVersionAvailable();

            // Cleanup existing notifications
            if (!$newVersionAvailable || ($newVersionAvailable && !$adminsNotified)) {
                foreach ($adminUserQuery->all() as $admin) {
                    $updateNotification->delete($admin);
                }
            }

            // Create new notification
            if ($newVersionAvailable && !$adminsNotified) {
                $updateNotification->sendBulk($adminUserQuery);
                $weatherModule->settings->set('lastVersionNotify', $latestVersion);
            }
        }
    }

}