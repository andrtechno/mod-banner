<?php
namespace panix\mod\banner\models;

use panix\engine\behaviors\TranslateBehavior;
use panix\engine\db\ActiveRecord;

class Banner extends ActiveRecord {

    const MODULE_ID = 'banner';

    public $content;
    public $image;
    public $translationClass = BannerTranslate::class;

    public function getForm() {
        Yii::app()->controller->widget('ext.tinymce.TinymceWidget');
        Yii::import('ext.bootstrap.fileinput.FileInput');
        return new CMSForm(array(
            'showErrorSummary' => true,
            'attributes' => array(
                'id' => __CLASS__,
                'enctype' => 'multipart/form-data',
            ),
            'elements' => array(
                'image' => array(
                    'type' => 'FileInput',
                    'visible' => true,
                    'options' => array(
                        'showUpload' => false,
                        'showPreview' => true,
                        'overwriteInitial' => true,
                        'showRemove' => false,
                        'showClose' => false,
                        'showCaption' => false,
                        'browseLabel' => '',
                        'removeLabel' => '',
                        'elErrorContainer' => '#kv-avatar-errors',
                        'msgErrorClass' => 'alert alert-danger',
                        'initialPreview' => $this->getInitialPreview(),
                        'allowedFileExtensions' => array("jpg", "png", "gif"),
                        'fileActionSettings' => array(
                            'showDrag' => false
                        ),
                        'initialPreviewConfig' => array(
                            array(
                                'width' => '120px',
                                'url' => Yii::app()->createUrl('/admin/banner/default/removefile'), // server delete action
                                'key' => $this->id,
                            )
                        ),
                    ),
                    'hint' => self::t('IMAGE_HINT'),
                    'afterContent' => '<div id="kv-avatar-errors" style="display:none"></div>'
                ),
                'content' => array(
                    'type' => 'textarea',
                    'class' => 'editor'
                ),
            ),
            'buttons' => array(
                'submit' => array(
                    'type' => 'submit',
                    'class' => 'btn btn-success',
                    'label' => $this->isNewRecord ? Yii::t('app', 'CREATE', 0) : Yii::t('app', 'SAVE')
                )
            )
                ), $this);
    }

    public function getGridColumns() {
        return array(
            array(
                'name' => 'image',
                'type' => 'html',
                'htmlOptions' => array('class' => 'image'),
                'filter' => false,
                'value' => 'Html::link(Html::image($data->getImageUrl("100x100"),"",array("class"=>"img-thumbnail")),$data->getOriginalImageUrl())'
            ),
            array(
                'name' => 'date_create',
                'value' => 'CMS::date($data->date_create)',
                'htmlOptions' => array('class' => 'text-center'),
            ),
            array(
                'name' => 'date_update',
                'value' => 'CMS::date($data->date_update)',
                'htmlOptions' => array('class' => 'text-center'),
            ),
            'DEFAULT_CONTROL' => array(
                'class' => 'ButtonColumn',
                'template' => '{switch}{update}{delete}',
            ),
            'DEFAULT_COLUMNS' => array(
                array('class' => 'CheckBoxColumn'),
                array('class' => 'ext.sortable.SortableColumn')
            //   array('class' => 'HandleColumn')
            ),
        );
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return '{{%banner}}';
    }


    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return [
            array('image, content', 'type', 'type' => 'string'),
            array('image', 'FileValidator', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
            //array('image', 'required', 'on'=>'insert'),
            array('date_create, date_update', 'date', 'format' => 'yyyy-MM-dd HH:mm:ss'),
        ];
    }


    public function behaviors() {
        return \yii\helpers\ArrayHelper::merge([
            'translate' => [
                'class' => TranslateBehavior::class,
                'translationAttributes' => [
                    'content',
                ]
            ],
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

    public function getTranslations() {
        return $this->hasMany($this->translationClass, ['object_id' => 'id']);
    }
    public function getTranslation()
    {
        return $this->hasOne($this->translationClass, ['object_id' => 'id']);
    }

}
