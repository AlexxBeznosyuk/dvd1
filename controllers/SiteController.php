<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SaveForm;
use app\models\ItemSearch;
use app\models\Genres;
use app\models\Items;
use app\models\Countries;
use app\models\Rewiews;
use app\models\RewiewsForm;
use app\models\Types;
use app\models\FilterForm;
use yii\helpers\Html;
use yii\web\UploadedFile;


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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   
        $genres = Genres::find()->all();
        $countries = Countries::find()->orderBy('id')->all();
        $types = Types::find()->all();

        $filterSearch = new FilterForm();
        $filter = $filterSearch->search(Yii::$app->request->post());

        $query = Items::find();        
        $items = $query->where($filter['where'])->orderBy($filter['order']);

        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $items->count(),
        ]);
        $items = $items->offset($pagination->offset)
                ->limit($pagination->limit)->all();

        return $this->render('index', [
            'items' => $items,
            'genres' => $genres,
            'countries' => $countries,
            'types' => $types,
            'active_page' => Yii::$app->request->get('page', 1),
            'count_pages' => $pagination->getPageCount(),
            'pagination' => $pagination,
            'filterSearch' => $filterSearch,
            'post' => $_POST,
            'fil' => $filter
        ]);
    }
    public function actionDetail()
    {
        $request = Yii::$app->request;

        $query = Items::find()->where(['id' => $request->get('itemid')])->one();   

        if($request->get('del')){
            $delRew = Rewiews::findOne($request->get('del'));
            if(is_object($delRew))
            $delRew->delete();
            return $this->redirect(["site/detail", 'itemid' => $query->id]);
        }

        if($request->post('rating') !== null){
            if($query->countRewiew == null){
                $query->countRewiew = 1;
                $query->rating = $request->post('rating');
                if($query->save()){
                   // return $this->refresh();
                };
            }else{
                $rat = $query->rating;
                $count = $query->countRewiew;
                $res = ($rat*$count + $request->post('rating'))/++$count;
                $res = round($res, 2);
                $query->rating = $res;
                $query->countRewiew = $count;
                if($query->save(false)){
                   // return $this->refresh();
                };
            }
        }

        $model = new RewiewsForm();
        if ($model->load(Yii::$app->request->post())) {
                $rewiew = new Rewiews();
                $rewiew->username = $model->username;
                $rewiew->msg = $model->msg;
                $rewiew->itemid = $request->get('itemid');
                $rewiew->date = time();
                if ($rewiew->save()){
                    Yii::$app->session->setFlash('AddRewiew');
                    return $this->refresh();
                }
        }        

    
        return $this->render('detail', [
            'model' => $model,
            'item' => $query,
            'fil' => $res
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSitemanager(){
        $model = new SaveForm();
        $types = Types::find()->where('id > 0')->all(); 
        $genres = Genres::find()->where('id > 0')->all();
        $countries = Countries::find()->where('id > 0')->all(); 

        $post = Yii::$app->request->post();
        if($post['genre']){
            $g = new Genres();
            $g->name = Html::encode($post['genre']);
            $g->save() ? Yii::$app->session->setFlash('successAdd') : [];
            return $this->refresh();
        }
        if($post['country']){
            $c = new Countries();
            $c->name = Html::encode($post['country']);
            $c->save() ? Yii::$app->session->setFlash('successAdd') : [];
            return $this->refresh();
        }
        if($post['type']){
            $t = new Types();
            $t->name = Html::encode($post['type']);
            $t->save() ? Yii::$app->session->setFlash('successAdd') : [];
            return $this->refresh();
        }
         
        if ($model->load(Yii::$app->request->post())) {            
            $item = new Items();
            $item->title = Html::encode($model->title);
            $item->year = Html::encode($model->year);
            $img = UploadedFile::getInstance($model, 'img');
            $model->upload();
            $item->img =$img->name;  
            $item->description = Html::encode($model->description);
            $item->trailer = $model->trailer;
            $item->genre = $model->genre;
            $item->type = $model->type;
            $item->country = $model->country;
            if ($item->save()){
                Yii::$app->session->setFlash('Successful_save');
                return $this->refresh();
            }
        }
        return $this->render('sitemanager', [
            'model' => $model,
            'item' => $item,
            'countries' => $countries,
            'types' => $types,
            'genres' => $genres,  
        ]);
    }
}
