<?php

namespace panix\mod\banner\models;

use yii\db\ActiveRecord;

/**
 * Class BannerTranslate
 *
 * @property string $content
 * @package panix\mod\banner\models
 */
class BannerTranslate extends ActiveRecord
{
    public static $translationAttributes = ['content'];

    public static function tableName()
    {
        return '{{%banner_translate}}';
    }

}