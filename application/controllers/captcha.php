<?php

defined('BASEPATH') or die(" no captcha");

class Captcha extends CI_controller{
	
	function __construct()
	{
		parent::__construct();
		@session_start();
		$this->load->library('elxiscaptcha');
	}
	
	function index()
	{
		//($null === null) or show_404();
		$this->elxiscaptcha->elxiscaptcha(5,12,'png');
		$this->elxiscaptcha->display();
		$_SESSION['captindex'] = $this->elxiscaptcha->getEncString();
	}
	
	
	function make($str = '')
	{
		//($null === null) or show_404();
		$access = FALSE;
		
		switch($str)
		{
			case 'login':
			case 'tribune':
			case 'contact':
				$access = TRUE ;
			break;
			
			default:
				$access = FALSE;
		}
		
			if( ! $access)
				_not_found('No captcha access');
		
		$this->elxiscaptcha->elxiscaptcha(5,12,'png');
		$this->elxiscaptcha->display();
		$_SESSION['capt'.$str] = $this->elxiscaptcha->getEncString();
	}
	
}