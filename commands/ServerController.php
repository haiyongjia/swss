<?php

namespace app\commands;

use app\helper\Tool;
use app\helper\swoole_websocket\Websocket;

/**
 * websocket服务器
 * 启动命令:/data/code/website/websocket/commands/websocket start
 */
class ServerController extends \wii\console\Controller {

	//每次启动redis的存储用的key
	public $rkey;

	//启动服务
	public function actionIndex() {
		//初始化
		$this->rkey = Tool::getNonceStr(5);

		//配置服务器
		$server = new \swoole_websocket_server("0.0.0.0", 9501);
		$server->set([
			'worker_num' => 100,
			'max_request' => 500,  //设置worker进程的最大任务数
			'max_conn' => 50000,  //最大连接数-不能大于65535个
			'user' => 'www',  //设置worker/task子进程的所属用户
			'group' => 'www',  //设置worker/task子进程的所属用户组
			'log_file' => '/data/server_logs/swoole.log',  //指定swoole错误日志文件
			'log_level' => 2,  //错误日志打印的等级
			'daemonize' => 1,  //守护进程运行
		]);
		//绑定事件
		$server->on('open', [$this, 'onOpen']);
		$server->on('message', [$this, 'onMessage']);
		$server->on('close', [$this, 'onClose']);
		//启动服务
		$server->start();
	}

	//连接事件
	public function onOpen($serv, $request) {
	}

	//消息事件
	public function onMessage($serv, $frame) {
	}

	//关闭事件
	public function onClose($serv, $fd) {
	}


}




