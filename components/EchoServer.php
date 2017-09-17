<?php 
namespace suite117\chat\components;

use consik\yii2websocket\events\WSClientMessageEvent;
use consik\yii2websocket\WebSocketServer;

class EchoServer extends WebSocketServer
{
    
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_CLIENT_MESSAGE, function (WSClientMessageEvent $e) {
            $e->client->send( $e->message );
        });
    }
    
}