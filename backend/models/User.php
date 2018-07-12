<?php

namespace app\models;

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
                if( isset( $this->password_hash ) and !empty($this->password_hash) ){
                    $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
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



}
