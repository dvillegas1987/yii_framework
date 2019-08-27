<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Users extends ActiveRecord{
    
    public static function getDb()
    {
        return Yii::$app->db;
    }
    
    public static function tableName()
    {
        return 'usuario';
    }
    
    public $foto_perfil;
    public $roles;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'nombre', 'apellido','adjunto_foto'/*, 'authKey', 'accessToken'*/], 'required'],
            [['adjunto_foto'], 'string'],
            ['roles','safe'],
            [['activate', 'role'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 80],
            [['password', 'authKey', 'accessToken', 'verification_code'], 'string', 'max' => 250],
            [['nombre', 'apellido'], 'string', 'max' => 200],
            /*['foto_perfil', 'required', 'whenClient' => "function (attribute, value) {

                var archivo = $('#users-foto_perfil').val();

                if(archivo == ''){
                    return true;
                }else{
                    return false;
                }
                
            }"]*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'activate' => 'Activate',
            'verification_code' => 'Verification Code',
            'roles' => 'Rol',
            'adjunto_foto' => 'Foto de perfil',
            'foto_perfil' => 'Foto de perfil'
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasMany(Rol::className(), ['role' => 'codigo']);
    }
}