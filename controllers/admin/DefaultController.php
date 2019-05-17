<?php

namespace panix\mod\banner\controllers\admin;

use panix\mod\banner\models\BannerSearch;
use Yii;
use panix\mod\banner\models\Banner;
use panix\engine\controllers\AdminController;

class DefaultController extends AdminController {

    public function actions2() {
        return array(
            'switch' => array(
                'class' => 'ext.adminList.actions.SwitchAction',
            ),
            'delete' => array(
                'class' => 'ext.adminList.actions.DeleteAction',
            ),
            'sortable' => array(
                'class' => 'ext.sortable.SortableAction',
                'model' => Banner::find(),
            ),
            'removefile' => array(
                'class' => 'ext.bootstrap.fileinput.actions.RemoveFileAction',
                'model' => Banner::find(),
                'dir' => 'banner',
                'attribute' => 'image'
            ),
        );
    }

    /**
     * Display banner list.
     */
    public function actionIndex() {
        $this->pageName = Yii::t('banner/default', 'MODULE_NAME');
        $this->breadcrumbs = [$this->pageName];

        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);

    }

    /**
     * Create or update new page
     * @param boolean $new
     */
    public function actionUpdate($new = false) {
        $model = Banner::findModel($new);

        $this->pageName = ($model->isNewRecord) ? $model::t('PAGE_TITLE', 0) : $model::t('PAGE_TITLE', 1);

        $this->breadcrumbs = array(
            Yii::t('banner/default', 'MODULE_NAME') => $this->createUrl('index'),
            $this->pageName
        );

        // $oldImage = $model->image;
        if (Yii::$app->request->isPost) {
            $model->attributes = $_POST['Banner'];
            if ($model->validate()) {
                $model->save();

              //  $this->redirect(array('index'));
                $this->refresh();
            }
        }
        return $this->render('update', ['model' => $model]);
    }


}
