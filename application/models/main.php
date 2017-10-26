<?php
defined('BASEPATH') or die("E: in main model");

// add lang
include_once APPPATH.'language/persian/persian.php';

class Main extends CI_Model{
	
		
		
			/**
		* Date format to timestamp
		* data must be like 1390-03-09 and time must be like 23:45
		*
		*		### this function need to jmktime function ###
		*
		* @param $date string like 1390-03-09
		* @param $time string like 20:42
		* @return int(10) timestamp
		*/
		function date_str_to_timestamp($date,$time)
		{
			$date = trim($date);
			$time = trim($time);
			$da = explode('-',$date);
			$ti = explode(':',$time);
			return pmktime($ti[0],$ti[1],1,$da[1],$da[2],$da[0]);
		}
		
		
		
		/* function session start */
		function session_start()
		{
			$sessionid = session_id();
			if(empty($sessionid))
				session_start();
		}
		
		function _is_admin()
	{
		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');
		if($user_id == $_SERVER['REMOTE_ADDR'])
			return true ;
			return false;
	}
	

}