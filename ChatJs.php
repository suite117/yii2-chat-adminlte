<?php

/**
 * @link https://github.com/suite117/yii2-chat-adminlte
 * @copyright Copyright (c) 2014 Andy fitria 
 * @license MIT
 */

namespace suite117\chat;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Andy Fitria <suite117@gmail.com>
 */
class ChatJs extends AssetBundle {

    public $sourcePath = '@vendor/suite117/yii2-chat-adminlte/assets';
    public $js = [
        'js/chat.js',
    ];
    
    public $css = [
        'css/chat.css',
    ];
    
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
