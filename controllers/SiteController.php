<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use app\models\Films;
use app\models\FilmsSearch;
use app\models\User;

/**
 * SiteController контроллер главной страницы, реализует действия над картотекой
 * с контролем доступа
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'index', 'error', 'setfilmsinpage'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => [User::PERMISSION_EDITFILMS],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Начальная страница
     * @return генерируется список
     */
    public function actionIndex()
    {
        $itemsInPage = Films::getFilmsInPage();
        $searchModel = new FilmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $itemsInPage);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотр фильма
     * @param integer $id - идентификатор фильма
     * @return генерируется просмотр
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание фильма
     * @return генерируется форма
     */
    public function actionCreate()
    {
        $model = new Films();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Обновление новости
     * @param integer $id - идентификатор
     * @return генерируется форма
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаление фильма
     * @param integer $id - идентификатор
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Установка количества отображаемых фильмов на странице
     */
    public function actionSetfilmsinpage($filmsinpage){
        Films::setFilmsInPage($filmsinpage);
        return '';
    }
    
    /**
     * Поиск по id
     * @param integer $id - идентификатор
     * @return объект Films
     * @throws NotFoundHttpException если не найдено
     */
    protected function findModel($id)
    {
        if (($model = Films::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
