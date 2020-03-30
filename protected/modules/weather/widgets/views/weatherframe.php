<?php

use yii\helpers\Url;
use humhub\libs\Html;
use humhub\models\Setting;

\humhub\modules\weather\Assets::register($this);
?>

<div class="panel panel-default panel-weather" id="panel-weather">
    <?= \humhub\widgets\PanelMenu::widget(['id' => 'panel-weather']); ?>
  <div class="panel-heading">
    <i class="fa fa-cloud">&nbsp;</i><?= Yii::t('WeatherModule.base', '<strong>Weather</strong>'); ?>
  </div>
  <div class="panel-body">

<?= Html::beginTag('div') ?>
<a class="weatherwidget-io" href="<?= $weatherUrl ?>" data-label_1="<?= $location ?>" data-label_2="WEATHER" data-theme="original" ><?= $location ?> WEATHER</a>
<script>
$(document).on('ready pjax:success', function() { __weatherwidget_init() });
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
</script>
<?= Html::endTag('div'); ?>

</div>
</div>
