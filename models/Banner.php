<?php

namespace panix\mod\banner\models;

use panix\engine\db\ActiveRecord;

class Banner extends ActiveRecord
{

    const MODULE_ID = 'banner';

    public $image;
    public $translationClass = BannerTranslate::class;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            array('image, content', 'type', 'type' => 'string'),
            array('image', 'FileValidator', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
            //array('image', 'required', 'on'=>'insert'),
            array('date_create, date_update', 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'),
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
