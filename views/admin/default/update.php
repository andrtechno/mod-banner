
<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;


/**
 * @var \panix\mod\banner\models\Banner|\panix\engine\behaviors\UploadFileBehavior $model
 */
$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title"><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">

        <?= $form->field($model, 'content')->textarea(); ?>
        <?= $form->field($model, 'image', [
            'parts' => [
                '{buttons}' => $model->getFileHtmlButton('image')
            ],
            'template' => '<div class="col-sm-4 col-lg-2">{label}</div>{beginWrapper}{input}{buttons}{hint}{error}{endWrapper}'
        ])->hint($model::t('IMAGE_HINT'))->fileInput() ?>
    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>


