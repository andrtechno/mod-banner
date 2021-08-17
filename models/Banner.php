<?php

namespace panix\mod\banner\models;

use Yii;
use panix\engine\db\ActiveRecord;
use panix\engine\Html;

/**
 * Class Banner
 * @property integer $id
 * @property string $url_name
 * @property string $url
 * @property string $image
 * @property integer $ordern
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package panix\mod\banner\models
 */
class Banner extends ActiveRecord
{

    const MODULE_ID = 'banner';

    const route = '/admin/banner/default';
    public $translationClass = BannerTranslate::class;

    public static function find()
    {
        return new BannerQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    public function getGridColumns()
    {
        return [
            'image' => [
                'class' => 'panix\engine\grid\columns\ImageColumn',
                'attribute' => 'image',
                'value' => function ($model) {
                    return Html::a(Html::img($model->getImageUrl('image', '800x250'), ['class' => 'img-thumbnail_']), $model->getImageUrl('image'), ['data-fancybox' => 'gallery', 'pjax' => 0]);
                }
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\sortable\Column'],
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            ],
        ];
    }

    public function rules()
    {
        list($pcSizeMaxWidth, $pcSizeMaxHeight) = explode('x', Yii::$app->getModule(self::MODULE_ID)->pcMaxSize);
        list($mobileSizeMaxWidth, $mobileSizeMaxHeight) = explode('x', Yii::$app->getModule(self::MODULE_ID)->pcMaxSize);


        list($pcSizeMinWidth, $pcSizeMinHeight) = explode('x', Yii::$app->getModule(self::MODULE_ID)->pcMinSize);
        list($mobileSizeMinWidth, $mobileSizeMinHeight) = explode('x', Yii::$app->getModule(self::MODULE_ID)->pcMinSize);


        return [
            [['content', 'url', 'url_name'], 'string'],
            [['image', 'image_mob', 'url', 'url_name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['image', 'image_mob'], 'default'],
            [['image'], 'image', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'webp'], 'maxWidth' => $pcSizeMaxWidth, 'maxHeight' => $pcSizeMaxHeight, 'minWidth' => $pcSizeMinWidth, 'minHeight' => $pcSizeMinHeight],
            [['image_mob'], 'image', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'webp'], 'maxWidth' => $mobileSizeMaxWidth, 'maxHeight' => $mobileSizeMaxHeight, 'minWidth' => $mobileSizeMinWidth, 'minHeight' => $mobileSizeMinHeight],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge([
            'uploadFile' => [
                'class' => 'panix\engine\behaviors\UploadFileBehavior',
                'files' => [
                    'image' => '@uploads/banner',
                    'image_mob' => '@uploads/banner_mob',
                ],
                'options' => [
                    'watermark' => false
                ]
            ]
        ], parent::behaviors());
    }
}
