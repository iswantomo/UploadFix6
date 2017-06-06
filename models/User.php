<?php

namespace app\models;

use Yii;
//use app\models\Login; 

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 */
class User extends \yii\db\ActiveRecord  implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
	public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password','name'], 'required'],
            //[['username'], 'safe'],
            [['username', 'password'], 'string', 'max' => 25],
            [['name'], 'string', 'max' => 30],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'username' => 'NIM',
            'password' => 'Password',
            'name' => 'Nama',
        ];
    }

    public static function findByUsername($username){
        //mencari user login berdasarkan username dan hanya dicari 1.
        $user = User::find()->where(['username'=>$username])->one(); 
        if(count($user)){
            return new static($user);
        }
        return null;
    }


    public function getId(){
        return $this->id;
    }	

    public function validatePassword($password){
        return $this->password === md5($password);
    }
	
    public static function findIdentityByAccessToken($token, $type = null){
		return 1;
    }
    public function getAuthKey(){
        return 1;
    }

    public function validateAuthKey($authKey){
        return 1;
    }

    public static function findIdentity($id){
        $user = User::findOne($id); 
        if(count($user)){
            return new static($user);
        }
		return null;
    }
	
}
