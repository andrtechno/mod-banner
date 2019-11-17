<?php

namespace panix\mod\banner\models;

use panix\engine\db\ActiveRecord;
use panix\engine\Html;
use panix\engine\traits\query\DefaultQueryTrait;
use panix\engine\traits\query\TranslateQueryTrait;
use yii\db\ActiveQuery;

class BannerQuery extends ActiveQuery
{

    use DefaultQueryTrait, TranslateQueryTrait;

}
