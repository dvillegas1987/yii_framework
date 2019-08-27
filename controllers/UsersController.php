<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\SqlDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\User;
use app\components\AccessRule;
/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
       {
           return [
               'verbs' => [
                   'class' => VerbFilter::className(),
                   'actions' => [
                       'delete' => ['post'],
                   ],
               ],
               'access' => [
                   'class' => AccessControl::className(),
                   // We will override the default rule config with the new AccessRule class
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                   'only' => ['index','create', 'update', 'delete','view','logout'],
                   'rules' => [
                       [
                           'actions' => ['index','create', 'update', 'delete','view','logout'],
                           'allow' => true,
                           // Allow users, moderators and admins to create
                           'roles' => [
                               User::ROLE_DIRECCION,
                           ],
                       ],

                       [
                           'actions' => ['index','view','update','create'],
                           'allow' => true,
                           // Allow users, moderators and admins to create
                           'roles' => [
                               User::ROLE_DIRECCION,
                           ],
                       ],
                       [
                           'actions' => ['update','view'],
                           'allow' => true,
                           // Allow moderators and admins to update
                           'roles' => [
                               User::ROLE_DOCENTE
                           ],
                       ],
                       [
                           'actions' => ['index','update','view'],
                           'allow' => true,
                           // Allow role_view to view
                           'roles' => [
                               User::ROLE_DIRECCION,
                           ],
                       ],
                       [
                           'actions' => ['index','view','update','logout'],
                           'allow' => true,
                           // Allow role_view to view
                           'roles' => [
                               User::ROLE_DIRECCION,
                               User::ROLE_DOCENTE,
                               User::ROLE_ALUMNO,
                              
                           ],
                       ],
                   ],
               ],            
           ];
       }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    private function randKey($str='', $long=0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }


    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();



        if ($model->load(Yii::$app->request->post())) {


            $imageName = $model->email.'_'.$model->nombre;
            $model->foto_perfil = UploadedFile::getInstanceByName('Users[foto_perfil]');

            if(isset($model->foto_perfil) ) {
	            $model->foto_perfil->saveAs('uploads/foto_perfil/'.$imageName.'.'.$model->foto_perfil->extension );
	            $model->adjunto_foto = 'uploads/foto_perfil/'.$imageName.'.'.$model->foto_perfil->extension;
	        }else{
	        	//$model->foto_perfil->saveAs('uploads/foto_perfil/foto_default.jpg');
	            $model->adjunto_foto = 'uploads/foto_perfil/foto_default.jpg';	
	        }    

            $model->password = crypt($model->password, Yii::$app->params["salt"]);
            $model->authKey = $this->randKey("abcdef0123456789", 200);
            $model->accessToken = $this->randKey("abcdef0123456789", 200);
            $model->activate =1;

            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }

           
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            //$model->password = crypt($model->password, Yii::$app->params["salt"]);


            $imageName = $model->id.'_'.$model->nombre;
            $model->foto_perfil = UploadedFile::getInstanceByName('Users[foto_perfil]');

            if(isset($model->foto_perfil) ) {

                $model->foto_perfil->saveAs( 'uploads/foto_perfil/'.$imageName.'.'.$model->foto_perfil->extension );
                $model->adjunto_foto = 'uploads/foto_perfil/'.$imageName.'.'.$model->foto_perfil->extension;

            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
       



        /*$model = $this->findModel($id);

        if (isset($id)) {

            Yii::$app->db->createCommand("update seg_users
                    set nombre='$model->nombre'
                    where id='$id'")->execute();
    

            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
