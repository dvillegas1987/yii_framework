<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\widgets\ActiveForm;
use yii\web\response;
use yii\helpers\Html;
use yii\data\Pagination;
use app\models\FormRegister;
use yii\widgets\Pjax;
use app\models\Users;
use yii\helpers\Url;
use yii\web\Session;
use yii\data\ActiveDataProvider;
use app\models\FormRecoverPass;
use app\models\FormResetPass;
use yii\data\SqlDataProvider;
use yii\db\command;
use yii\helpers\ArrayHelper;
use app\components\AccessRule;
use yii\db\Query;

use app\models\User;

class SiteController extends Controller
{
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
                           'actions' => ['index','create'],
                           'allow' => true,
                           // Allow users, moderators and admins to create
                           'roles' => [
                               User::ROLE_DOCENTE,
                           ],
                       ],
                       [
                           'actions' => ['update'],
                           'allow' => true,
                           // Allow moderators and admins to update
                           'roles' => [
                               User::ROLE_DOCENTE,
                           ],
                       ],
                       [
                           'actions' => ['index','view'],
                           'allow' => true,
                           // Allow role_view to view
                           'roles' => [
                               User::ROLE_DOCENTE,
                           ],
                       ],
                       [
                           'actions' => ['index','logout'],
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

     /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','create','update','view','delete','index'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['logout','create','update','view','delete','index'],
                        //Esta propiedad establece que tiene permisos
                        'allow' => true,
                        //Usuarios autenticados, el signo ? es para invitados
                        'roles' => ['@'],
                        //Este método nos permite crear un filtro sobre la identidad del usuario
                        //y así establecer si tiene permisos o no
                        'matchCallback' => function ($rule, $action) {
                            //Llamada al método que comprueba si es un administrador
                            return User::isUserAdmin(Yii::$app->user->identity->id);
                        },
                    ],
                    [
                       //Los usuarios simples tienen permisos sobre las siguientes acciones
                       'actions' => ['logout','view','index'],
                       //Esta propiedad establece que tiene permisos
                       'allow' => true,
                       //Usuarios autenticados, el signo ? es para invitados
                       'roles' => ['@'],
                       //Este método nos permite crear un filtro sobre la identidad del usuario
                       //y así establecer si tiene permisos o no
                       'matchCallback' => function ($rule, $action) {
                          //Llamada al método que comprueba si es un usuario simple
                          return User::isUserSimple(Yii::$app->user->identity->id);
                      },
                   ],
                ],
            ],
           //Controla el modo en que se accede a las acciones, en este ejemplo a la acción logout
           //sólo se puede acceder a través del método post
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }*/
    
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

    public function actionUser(){

        return $this->render('site/index');

    }

    public function actionAdmin(){

        return $this->render('/credito');

    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {  

        $this->layout ='loginLayout';
        if (!\Yii::$app->user->isGuest) {

              if (User::isUserAdmin(Yii::$app->user->identity->id))
              {
               return $this->redirect(["/credito"]);
              }
              else
              {
               return $this->redirect(["site/index"]);
              }
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if (User::isUserAdmin(Yii::$app->user->identity->id))
            {
             return $this->redirect(["/credito"]);
            }
            else
            {
             return $this->redirect(["site/index"]);
            }

        }else {
           return $this->render('login', [
               'model' => $model,
           ]);
        }
     }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

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

    public function actionAbout()
    {
        return $this->render('about');
    }




    //registro y ecncriptacion

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
  
 public function actionConfirm()
 {
    $table = new Users;
    if (Yii::$app->request->get())
    {
   
        //Obtenemos el valor de los parámetros get
        $id = Html::encode($_GET["id"]);
        $authKey = $_GET["authKey"];
    
        if ((int) $id)
        {
            //Realizamos la consulta para obtener el registro
            $model = $table
            ->find()
            ->where("id=:id", [":id" => $id])
            ->andWhere("authKey=:authKey", [":authKey" => $authKey]);
 
            //Si el registro existe
            if ($model->count() == 1)
            {
                $activar = Users::findOne($id);
                $activar->activate = 1;
                if ($activar->update())
                {
                    echo "Registro llevado a cabo correctamente, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                }
                else
                {
                    //echo "Ha ocurrido un error al realizar el registro, redireccionando ...";
                    echo "Registro llevado a cabo correctamente, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                }
             }
            else //Si no existe redireccionamos a login
            {
                return $this->redirect(["site/login"]);
            }
        }
        else //Si id no es un número entero redireccionamos a login
        {
            return $this->redirect(["site/login"]);
        }
    }
 }
 
 public function actionRegister()
 {

  $this->layout ='registerLayout';



  //Creamos la instancia con el model de validación
  $model = new FormRegister();
   
  //Mostrará un mensaje en la vista cuando el usuario se haya registrado
  $msg = null;
   
  //Validación mediante ajax
  /*if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
	{
	    Yii::$app->response->format = Response::FORMAT_JSON;
	    return ActiveForm::validate($model);
	}*/
   
  //Validación cuando el formulario es enviado vía post
  //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
  //También previene por si el usuario tiene desactivado javascript y la
  //validación mediante ajax no puede ser llevada a cabo
  if ($model->load(Yii::$app->request->post()))
  {
   if($model->validate())
   {
    //Preparamos la consulta para guardar el usuario
    $table = new Users;
    $table->username = $model->username;
    $table->email = $model->email;
    //Encriptamos el password
    $table->password = crypt($model->password, Yii::$app->params["salt"]);

    $table->nombre = $model->nombre;
    $table->apellido = $model->apellido;
    $table->adjunto_foto = 'uploads/foto_perfil/foto_default.jpg';
    $table->role = $model->role;

    //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
    //clave será utilizada para activar el usuario
    $table->authKey = $this->randKey("abcdef0123456789", 200);
    //Creamos un token de acceso único para el usuario
    $table->accessToken = $this->randKey("abcdef0123456789", 200);

    $table->activate = 1;

    //Si el registro es guardado correctamente
    if ($table->insert())
    {
     //Nueva consulta para obtener el id del usuario
     //Para confirmar al usuario se requiere su id y su authKey
     $user = $table->find()->where(["email" => $model->email])->one();
     $id = urlencode($user->id);
     $authKey = urlencode($user->authKey);
      
     $subject = "Confirmar registro";
     //$body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
     //$body .= "<a href='http://localhost/crediexpress/web/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."'>Confirmar</a>";
      $body = "<div id=':mh' class='a3s aXjCH'><u></u>
<div style='margin:0;padding:0'>
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
    <tbody><tr>
        <td bgcolor='#ececec' align='center' style='padding:0px 15px 30px 15px'>
            <table border='0' cellpadding='0' cellspacing='0' width='570'>                
                <tbody><tr>
                    <td bgcolor='#ececec' height='20'></td>
                </tr>
                <tr>
                    <td bgcolor='#ececec'>
                        
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' style='width:100%!important'>
                            <tbody>
                            <tr>
                                <td>
                                    
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='width:100%!important'>
                                        <tbody>
                                            <tr>
                                                <td bgcolor='#ececec' align='center'  style='height:30px;font-size:11px;font-family:Helvetica,Arial,sans-serif;color:#ffffff;background-color:#4258A9;'>
                                                    TECH - TEST
                                                </td>
                                            </tr>
                                        <tr>
                                            <td bgcolor='#ffffff' align='center' style='padding:30px 30px 0px;font-size:28px;line-height:30px;font-family:Helvetica,Arial,sans-serif;color:#000000;border-radius:5px 5px 0 0'>
                                                Activa tu cuenta
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='width:100%!important'>
                                        <tbody><tr>
                                            <td bgcolor='#ffffff' align='center' style='padding:20px 30px;font-size:14px;line-height:25px;font-family:Helvetica,Arial,sans-serif;color:#000000'>
                                               Estas a punto de finalizar tu registro en el Sistema. A continuación presiona el botón para activar tu cuenta. Gracias.                                            
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor='#ffffff' style='padding:0 30px'>
                        
                        <table cellspacing='0' cellpadding='0' border='0' width='100%' style='width:100%!important'>
                            <tbody><tr>
                                <td valign='top' style='padding:0;border-bottom:1px solid #e5e5e5;width:100%!important'>
                                    <div>
                                        
                                        <table cellpadding='0' cellspacing='0' border='0' width='100%' align='center' style='width:100%!important'>
                                            <tbody><tr>
                                                <td style='padding:0 0 20px'>
                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='width:100%!important'>
                                                        <tbody><tr>
                                                            <td align='center'>
                                                                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='width:100%!important'>
                                                                    <tbody><tr>
                                                                        <td align='center'>
                                                                            <a href='http://crediexpress.tech-test.com.ar/web/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."' style='font-size:16px;font-family:Helvetica,Arial,sans-serif;font-weight:normal;color:#ffffff;text-decoration:none;background-color:#3c8dbc;border-top:15px solid #3c8dbc;border-bottom:15px solid #3c8dbc;border-left:25px solid #3c8dbc;border-right:25px solid #3c8dbc;border-radius:3px;display:inline-block;width:80%' >ACTIVAR CUENTA</a>     
                                                                        </td>
                                                                    </tr>
                                                                </tbody></table>
                                                            </td>
                                                        </tr>
                                                    </tbody></table>                                                
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
                
                <tr>
                    <td bgcolor='#ffffff' style='border-radius:0 0 5px 5px'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' style='width:100%!important'>
                            <tbody><tr>
                                <td>
                                    
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='width:100%!important'>
                                        <tbody><tr>
                                            <td align='center' style='padding:20px;font-size:14px;line-height:25px;font-family:Helvetica,Arial,sans-serif;color:#000000'>
                                                Si no te registraste en el Sistema, ignora este correo electrónico.
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>
        </td>
    </tr>
</tbody>
</table>
</div>
</div>";




     //Enviamos el correo
     Yii::$app->mailer->compose()
     ->setTo($user->email)
     ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
     ->setSubject($subject)
     ->setHtmlBody($body)
     ->send();
     
     $model->username = null;
     $model->email = null;
     $model->password = null;
     $model->password_repeat = null;
     $model->nombre = null;
     $model->apellido = null;

     
     $msg = "Operacion exitosa. Ahora sólo falta que confirmes tu registro en tu cuenta de correo.";
    }
    else
    {
     $msg = "Ha ocurrido un error al llevar a cabo tu registro.";
    }
     
   }
   else
   {
    $model->getErrors();
   }
  }
  return $this->render("register", ["model" => $model, "msg" => $msg]);
 }



  //Crear una nueva contraseña en caso de haberla olvidado

    public function actionRecoverpass()
    {
         //Instancia para validar el formulario
         $this->layout ='recoverpassLayout';
         $model = new FormRecoverPass;
         
         //Mensaje que será mostrado al usuario en la vista
        $msg = null;
     
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
        {
       //Buscar al usuario a través del email
       $table = Users::find()->where("email=:email", [":email" => $model->email]);
       
       //Si el usuario existe
       if ($table->count() == 1)
       {
        //Crear variables de sesión para limitar el tiempo de restablecido del password
        //hasta que el navegador se cierre
        $session = new Session;
        $session->open();
        
        //Esta clave aleatoria se cargará en un campo oculto del formulario de reseteado
        $session["recover"] = $this->randKey("abcdef0123456789", 200);
        $recover = $session["recover"];
        
        //También almacenaremos el id del usuario en una variable de sesión
        //El id del usuario es requerido para generar la consulta a la tabla users y 
        //restablecer el password del usuario
        $table = Users::find()->where("email=:email", [":email" => $model->email])->one();
        $session["id_recover"] = $table->id;
        
        //Esta variable contiene un número hexadecimal que será enviado en el correo al usuario 
        //para que lo introduzca en un campo del formulario de reseteado
        //Es guardada en el registro correspondiente de la tabla users
        $verification_code = $this->randKey("abcdef0123456789", 8);
        //Columna verification_code
        $table->verification_code = $verification_code;
        //Guardamos los cambios en la tabla users
        $table->save();
        
        //Creamos el mensaje que será enviado a la cuenta de correo del usuario
        $subject = "Recuperar password";
        $body = "<p>Copie el siguiente código de verificación para restablecer su password: ";
        $body .= "<strong>".$verification_code."</strong></p>";
        $body .= "<a href='http://crediexpress.tech-test.com.ar/web/index.php?r=site/resetpass'>Recuperar password</a>";


        //Enviamos el correo
        Yii::$app->mailer->compose()
        ->setTo($model->email)
        ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
        ->setSubject($subject)
        ->setHtmlBody($body)
        ->send();
        
        //Vaciar el campo del formulario
        $model->email = null;
        
        //Mostrar el mensaje al usuario
        $msg = "Le hemos enviado un mensaje a su cuenta de correo para que pueda resetear su password.";
       }
       else //El usuario no existe
       {
        $msg = "Ha ocurrido un error";
       }
      }
      else
      {
       $model->getErrors();
      }
     }
     return $this->render("recoverpass", ["model" => $model, "msg" => $msg]);
    }

    public function actionResetpass()
    {
     //Instancia para validar el formulario
     $this->layout ='resetpassLayout';
     $model = new FormResetPass;
     
     //Mensaje que será mostrado al usuario
     $msg = null;
     
     //Abrimos la sesión
     $session = new Session;
     $session->open();
     
     //Si no existen las variables de sesión requeridas lo expulsamos a la página de inicio
     if (empty($session["recover"]) || empty($session["id_recover"]))
     {
      return $this->redirect(["site/index"]);
     }
     else
     {
      
      $recover = $session["recover"];
      //El valor de esta variable de sesión la cargamos en el campo recover del formulario
      $model->recover = $recover;
      
      //Esta variable contiene el id del usuario que solicitó restablecer el password
      //La utilizaremos para realizar la consulta a la tabla users
      $id_recover = $session["id_recover"];
      
     }
     
     //Si el formulario es enviado para resetear el password
     if ($model->load(Yii::$app->request->post()))
     {
      if ($model->validate())
      {
       //Si el valor de la variable de sesión recover es correcta
       if ($recover == $model->recover)
       {
        //Preparamos la consulta para resetear el password, requerimos el email, el id 
        //del usuario que fue guardado en una variable de session y el código de verificación
        //que fue enviado en el correo al usuario y que fue guardado en el registro
        $table = Users::findOne(["email" => $model->email, "id" => $id_recover, "verification_code" => $model->verification_code]);
        
        //Encriptar el password
        $table->password = crypt($model->password, Yii::$app->params["salt"]);
        
        //Si la actualización se lleva a cabo correctamente
        if ($table->save())
        {
         
         //Destruir las variables de sesión
         $session->destroy();
         
         //Vaciar los campos del formulario
         $model->email = null;
         $model->password = null;
         $model->password_repeat = null;
         $model->recover = null;
         $model->verification_code = null;
         
         $msg = "Contraseña reseteada correctamente, redireccionando a la página de login ...";
         $msg .= "<meta http-equiv='refresh' content='5; ".Url::toRoute("site/login")."'>";
        }
        else
        {
         $msg = "Ha ocurrido un error";
        }
        
       }
       else
       {
        $model->getErrors();
       }
      }
     }
     
     return $this->render("resetpass", ["model" => $model, "msg" => $msg]);
     
    }

}
