<?php

use humhub\components\Migration;
use humhub\modules\weather\notifications\NewVersionAvailable;

class update_notification extends Migration
{
    public function up()
    {
        $this->update('notification', ['class' => NewVersionAvailable::class], ['class' => 'HumHubUpdateNotification']);
    }

    public function down()
    {
        echo "update_notification cannot be reverted.\n";

        return false;
    }
}