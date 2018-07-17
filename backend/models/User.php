<?php

namespace app\models;

use common\models\AuthAssignment;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $newrole;
    public $newpass;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($insert) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
                $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
                $this->status = 10;
                Yii::$app->session->setFlash('success', 'Запись создана');

            } else {

                $status = 'Запись обновлена!';

                if( isset( $this->newpass ) and !empty($this->newpass) ){
                    $this->password_hash = Yii::$app->security->generatePasswordHash($this->newpass);
                    $status .= 'Пароль обновлён!';
                }
                Yii::$app->session->setFlash('success', $status);
            }
            return true;
        }
        return false;
    }


    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        if( isset($this->newrole) ){

            if ($insert) {
                $model_auth =  new AuthAssignment();
                $model_auth->user_id = $this->id;
                $model_auth->item_name = $this->newrole;
                $model_auth->save();
            }else{
                $model_auth = $this->authAssignment;
                $model_auth->item_name = $this->newrole;
                $model_auth->update();
            }


        }

    }

    public function afterFind(){
        $this->newrole = $this->role;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            //[['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['username', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['newrole','newpass' ], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            //'auth_key' => 'Auth Key',
            //'password_hash' => 'Password Hash',
            //'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'newrole' => 'Роль пользователя',
            'newpass' => 'Новый пароль'
        ];
    }


    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function getRole()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name'])->via('authAssignment');
    }


}
