<?php

namespace suite117\chat\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $message
 * @property integer $userId
 * @property string $updateDate
 */
class Chat extends \yii\db\ActiveRecord {

    public $userModel;
    public $userField;
    public $theme;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message'], 'required'],
            [['userId'], 'integer'],
            [['updateDate', 'message'], 'safe']
        ];
    }

    public function getUser() {
        if (isset($this->userModel))
            return $this->hasOne($this->userModel, ['id' => 'userId']);
        else
            return $this->hasOne(Yii::$app->getUser()->identityClass, ['id' => 'userId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'userId' => 'User',
            'updateDate' => 'Update Date',
        ];
    }

    public function beforeSave($insert) {
        $this->userId = Yii::$app->user->id;
        return parent::beforeSave($insert);
    }

    public static function records() {
        // 'id desc'
        $models = array_reverse(static::find()->orderBy(['id' => SORT_DESC ])->limit(50)->all());
        
        
        return $models;
    }

    public function data() {
        $userField = $this->userField;
        $output = '';
        $models = Chat::records();
        $n = 0;
        if ($models)
            foreach ($models as $model) {
                if (isset($model->user->$userField)) {
                    $avatar = $model->user->$userField;
                } else{
                    $avatar = Yii::$app->assetManager->getPublishedUrl("@vendor/suite117/yii2-chat-adminlte/assets/img/avatar.png");
                }
                  
                if ($this->theme == "direct-chat") {
                    $output .= '<div class="direct-chat-msg' . ($n % 2 == 0 ? '' : ' right') . '">
                      <div class="direct-chat-info clearfix">
                        
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="' . $avatar . '" alt="message user image">
                      <!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
<span class="direct-chat-name pull-left">' . $model->user->username .'</span>
                        <span class="direct-chat-timestamp pull-right"><i class="fa fa-clock-o"></i> ' . \kartik\helpers\Enum::timeElapsed($model->updateDate) . '</span>
<br>
                        ' . $model->message . '
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>';
                }
                else {
                    $output .= '<div class="item">
                    <img class="online" alt="user image" src="' . $avatar . '">
                    <p class="message">
                        <a href="#" class="name">
                              <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> ' . \kartik\helpers\Enum::timeElapsed($model->updateDate) . '</small>
                            ' . $model->user->username . '
                        </a>
                       ' . $model->message . '
                    </p>
 
                    </div>';
                }
            
                
                $n++;
                
            }

        return $output;
    }

}
