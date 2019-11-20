<?php

namespace panix\mod\banner\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m180917_196318_banner
 */
use panix\mod\banner\models\Banner;
use panix\mod\banner\models\BannerTranslate;
use panix\engine\db\Migration;

class m180917_196318_banner extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable(Banner::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'image' => $this->string(255),
            'url_name' => $this->string(255),
            'url' => $this->string(255),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'ordern' => $this->integer()->unsigned(),
            'switch' => $this->boolean()->defaultValue(1),
        ]);

        $this->createTable(BannerTranslate::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'object_id' => $this->integer()->unsigned(),
            'language_id' => $this->tinyInteger()->unsigned(),
            'content' => $this->text()
        ]);

        $this->createIndex('switch', Banner::tableName(), 'switch');
        $this->createIndex('ordern', Banner::tableName(), 'ordern');

        $this->createIndex('object_id', BannerTranslate::tableName(), 'object_id');
        $this->createIndex('language_id', BannerTranslate::tableName(), 'language_id');

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable(Banner::tableName());
        $this->dropTable(BannerTranslate::tableName());
    }

}
