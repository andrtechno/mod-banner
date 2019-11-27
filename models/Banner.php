<?php

namespace panix\mod\banner\models;

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
                [
                    'class' => \panix\engine\grid\sortable\Column::class,
                    'url' => ['/admin/banner/default/sortable']
                ],
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content', 'url', 'url_name'], 'string'],
            [['image', 'url', 'url_name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge([
            'upload' => [
                'class' => 'panix\engine\behaviors\UploadFileBehavior',
                'files' => [
                    'image' => '@uploads/banner',
                ],
                'options' => [
                    'watermark' => false
                ]
            ]
        ], parent::behaviors());
    }
}
