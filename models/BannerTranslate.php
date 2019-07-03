<?php

namespace panix\mod\banner\models;

use yii\db\ActiveRecord;

class BannerTranslate extends ActiveRecord
{
    public static $translationAttributes = ['content'];

    public static function tableName()
    {
        return '{{%banner_translate}}';
    }

}