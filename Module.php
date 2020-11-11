<?php

namespace panix\mod\banner;

use Yii;
use panix\engine\Html;
use panix\engine\WebModule;

class Module extends WebModule
{

    public $icon = 'images';


    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => $this->name,
                        'url' => ['/admin/banner'],
                        'icon' => $this->icon,
                        'visible' => Yii::$app->user->can('/banner/admin/default/index') || Yii::$app->user->can('/banner/admin/default/*')
                    ],
                ],
            ],
        ];
    }

    public function getInfo()
    {
        return [
            'label' => Yii::t('banner/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('banner/default', 'MODULE_DESC'),
            'url' => ['/admin/banner'],
        ];
    }
}
