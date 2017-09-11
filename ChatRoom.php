<?php

/**
 * @link https://github.com/suite117/yii2-chat-adminlte
 * @copyright Copyright (c) 2015 Andy fitria <suite117@gmail.com>
 * @license MIT
 */

namespace suite117\chat;

use Yii;
use yii\base\Widget;
use suite117\chat\models\Chat;

/**
 * @author Andy Fitria <suite117@gmail.com>
 */
class ChatRoom extends Widget {

    public $sourcePath = '@vendor/suite117/yii2-chat-adminlte/assets';
    public $css;
    public $js = [ // Configured conditionally (source/minified) during init()
        'js/chat.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $models;
    public $url;
    public $userModel;
    public $userField;
    public $model;
    public $loadingImage;
    
    // chat o direct-chat
    public $theme = "direct-chat";

    public function init() {
        $this->model = new Chat();
        if ($this->userModel === NULL) {
            $this->userModel = Yii::$app->getUser()->identityClass;
        }

        $this->model->userModel = $this->userModel;
        $this->model->theme = $this->theme;

        if ($this->userField === NULL) {
            $this->userField = 'avatarImage';
        }

        $this->model->userField = $this->userField;
        Yii::$app->assetManager->publish("@vendor/suite117/yii2-chat-adminlte/assets/img/loadingAnimation.gif");
        $this->loadingImage = Yii::$app->assetManager->getPublishedUrl("@vendor/suite117/yii2-chat-adminlte/assets/img/loadingAnimation.gif");

        
        parent::init();
    }

    public function run() {
        parent::init();
        ChatJs::register($this->view);
        $model = new Chat();
        $model->userModel = $this->userModel;
        $model->userField = $this->userField;
        $model->theme = $this->theme;
        $data = $model->data();
        return $this->render('index', [
                    'data' => $data,
                    'url' => $this->url,
                    'userModel' => $this->userModel,
                    'userField' => $this->userField,
                    'loading' => $this->loadingImage,
                    'theme' => $this->theme,
        ]);
    }

    public static function sendChat($post) {
        if (isset($post['message']))
            $message = $post['message'];
        
        if (isset($post['userfield']))
            $userField = $post['userfield'];
        
        if (isset($post['model']))
            $userModel = $post['model'];
        else
            $userModel = Yii::$app->getUser()->identityClass;
        
        if (isset($post['theme']))
            $theme = $post['theme'];
        

        $model = new \suite117\chat\models\Chat;
        $model->userModel = $userModel;
        $model->theme = $theme;
        if ($userField)
            $model->userField = $userField;

        if ($message) {
            $model->message = $message;
            $model->userId = Yii::$app->user->id;

            if ($model->save()) {
                echo $model->data();
            } else {
                print_r($model->getErrors());
                exit(0);
            }
        } else {
            echo $model->data();
        }
    }

}
