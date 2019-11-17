<?php

namespace panix\mod\banner\controllers\admin;

use panix\mod\banner\models\BannerSearch;
use Yii;
use panix\mod\banner\models\Banner;
use panix\engine\controllers\AdminController;

class DefaultController extends AdminController {

    /**
     * Display banner list.
     */
    public function actionIndex() {
        $this->pageName = Yii::t('banner/default', 'MODULE_NAME');
        $this->breadcrumbs = [$this->pageName];

        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $this->buttons = [
            [
                'label' => Yii::t('banner/admin', 'CREATE_BANNER'),
                'url' => ['create'],
                'icon' => 'add',
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);

    }

    public function actionUpdate($id = false) {
        $model = Banner::findModel($id);
        $isNew = $model->isNewRecord;
        $this->pageName = ($isNew) ? $model::t('CREATE_BANNER') : $model::t('UPDATE_BANNER');

        $this->breadcrumbs = [
            [
                'label'=>Yii::t('banner/default', 'MODULE_NAME'),
                'url'=>['index']
            ],
            $this->pageName
        ];


        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            $this->redirectPage($isNew, $post);

        }

        return $this->render('update', ['model' => $model]);
    }


}
