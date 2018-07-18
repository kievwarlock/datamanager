<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $name
 * @property int $owner_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $owner
 * @property User $owner0
 * @property GroupAccount[] $groupAccounts
 * @property Post[] $posts
 */
class Group extends ActiveRecord
{


    public $accounts;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                 'value' => new Expression('NOW()'),
            ],
        ];
    }



    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        if( is_array( $this->accounts ) ){
            $oldAcc = ArrayHelper::map($this->groupAccounts, 'account_id', 'account_id');
            if( is_array($oldAcc) ){
                $accToInsert = array_diff( $this->accounts, $oldAcc );
                if( is_array($accToInsert) and count($accToInsert) > 0 ){
                    $this->createNewAccounts($accToInsert);
                }
                $accToDelete = array_diff( $oldAcc , $this->accounts );
                if( is_array($accToDelete) and count($accToDelete) > 0 ){
                    GroupAccount::deleteAll( ['and',['group_id'=> $this->id], ['account_id'=> $accToDelete] ]);
                }
            }

        }else{
            $this->unlinkAll('groupAccounts', true);
        }
    }

    private function createNewAccounts( $accounts_array  ){

        if( is_array($accounts_array) ) {

            foreach ($accounts_array as $account ){
                $group_account = new GroupAccount();
                $group_account->account_id = $account;
                $group_account->link('group', $this);
                //$group_account->group_id = $this->id;
                //$group_account->save();
            }

        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        //$this->owner_id = $this->owner->username;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'owner_id'], 'required'],
            [['name'], 'string'],
            [['owner_id'], 'integer'],
            [[ 'created_at', 'updated_at', 'accounts'], 'safe'],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'owner_id' => 'Owner ID',
            'accounts' => 'Accounts id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner0()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupAccounts()
    {
        return $this->hasMany(GroupAccount::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['group_id' => 'id']);
    }
}
