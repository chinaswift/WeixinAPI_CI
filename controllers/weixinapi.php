<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Weixinapi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('weixin');
	}

	public function index()
	{	
		// 没接收到用户发送过来的信息？	
		if ( ! $msg = $this->weixin->msg())
		{
			// todo

			return;
		}

		// 用户发送的是地理位置?
		if ((string)$msg->MsgType == 'location')
		{	
			// todo

			return;
		}		

		// 用户发送文本信息？
		if ((string)$msg->MsgType == 'text')
		{
			// 用户关注微信账号后的自动回复
			if ((string)$msg->Content == 'subscribe')
			{
				$this->weixin->send('text', array(
				'to'      => (string)$msg->FromUserName,
				'from'    => (string)$msg->ToUserName,
				'time'    => now(),
				'content' => "Welcome"
				));		

				return;		
			}

			if ((string)$msg->Content == '谢谢')
			{
				// 发送文本回复
				$this->weixin->send('text', array(
					'to'      => (string)$msg->FromUserName,
					'from'    => (string)$msg->ToUserName,
					'time'    => now(),
					'content' => 'You are welcome'
				));
				return;				
			}							

			if ((string)$msg->Content == '图文')
			{
				// 发送图文回复
				$this->weixin->send('news', array(
					'to'      => (string)$msg->FromUserName,
					'from'    => (string)$msg->ToUserName,
					'time'    => now(),
					'items'   => array(
						'title'       => '标题',
						'description' => '描述内容',
						'picurl'      => 'This is an url link for image',
						'url'         => 'This is an url link'
					)
				));
				return;				
			}
		}
	}
}

