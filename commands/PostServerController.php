<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\PostSocket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class PostServerController extends Controller
{

	public function actionInit()
	{
		echo "Start server";
		
		$server = IoServer::factory(
	        new HttpServer(
	            new WsServer(
	                new PostSocket()
	            )
	        ),
	        8080
	    );

	    $server->run();
	}
}