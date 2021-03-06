<?php

namespace panix\mod\banner\controllers\admin;

use panix\mod\banner\models\BannerSearch;
use Yii;
use panix\mod\banner\models\Banner;
use panix\engine\controllers\AdminController;

class DefaultController extends AdminController
{

    public function actions()
    {
        return [
            'sortable' => [
                'class' => \panix\engine\grid\sortable\Action::class,
                'modelClass' => Banner::class,
            ],
            'switch' => [
                'class' => \panix\engine\actions\SwitchAction::class,
                'modelClass' => Banner::class,
            ],
            'delete' => [
                'class' => \panix\engine\actions\DeleteAction::class,
                'modelClass' => Banner::class,
            ],
            'delete-file' => [
                'class' => \panix\engine\actions\DeleteFileAction::class,
                'modelClass' => Banner::class,
            ],
        ];
    }

    /**
     * Display banner list.
     */
    public function actionIndex()
    {
        $this->pageName = Yii::t('banner/default', 'MODULE_NAME');
        $this->view->params['breadcrumbs'] = [$this->pageName];

        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        if (Yii::$app->user->can("/{$this->module->id}/{$this->id}/*") || Yii::$app->user->can("/{$this->module->id}/{$this->id}/create")) {
            $this->buttons = [
                [
                    'label' => Yii::t('banner/Banner', 'CREATE_BANNER'),
                    'url' => ['create'],
                    'icon' => 'add',
                    'options' => ['class' => 'btn btn-success']
                ]
            ];
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);

    }

    public function actionUpdate($id = false)
    {
        $model = Banner::findModel($id);
        $isNew = $model->isNewRecord;
        $this->pageName = ($isNew) ? $model::t('CREATE_BANNER') : $model::t('UPDATE_BANNER');

        $this->view->params['breadcrumbs'] = [
            [
                'label' => Yii::t('banner/default', 'MODULE_NAME'),
                'url' => ['index']
            ],
            $this->pageName
        ];

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            return $this->redirectPage($isNew, $post);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionCreate()
    {
        return $this->actionUpdate(false);
    }
}
