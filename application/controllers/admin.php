<?php 
defined('BASEPATH') or die('Oops!');

class Admin extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
			$user_id = $this->session->userdata('user_id');
			if($user_id != $_SERVER['REMOTE_ADDR'])
			redirect('login?m=4');
		
		// csrf
	
		$_REQUEST = array_merge($_GET,$_POST);
		//$this->output->enable_profiler(false);
	}
	
	

	/* index */
	public function index()
	{
		$inpage = ! empty($_GET['index'])?intval($_GET['index']):0;
		$pageconf = array(
			'all'=>$this->db->query("SELECT count(id) as _count FROM `order`")->row()->_count ,	 
			'range'=>30, 	
			'inpage'=>$inpage,	
			'limit'=>0 ,	
			'url'=>site_url('admin?index=') 
			);

			$pagenumber = new MY_Pagination($pageconf);
			$data= array('pagenumber'=> $pagenumber->pagenumber());
			//print_r($data);
			$offset = 0;
			if( ! empty($_GET['index']))
				$offset = (intval($_GET['index'])-1) * 30;
				
			$data['items'] = $this->db->query("select * from `order` order by id desc limit {$offset},30 ")->result();			
			
			
		$out = array();
		$this->load->view('index',$data);
	}
	
//===========end =================\\
	/* out put func */
	
	
	/* logout */
	function logout()
	{
		$this->main->session_start();

		$this->load->library('session');
		$this->session->unset_userdata('user_id');
		$this->session->set_userdata('user_id',"reza");
		
		redirect('login/?m=1');
	}
	
	function report()
	{
		if( ! empty($_POST["timestamp"]))
		{
			$from = (int) self::_str2time($_POST['timestamp']);
			$this->load->helper('download');
			$name = 'report-from-'.pdate('Y-m-d',$from);
			$items = $this->db->query("select * from `order` where `time`>$from order by id ")->result();
			
			/*$items = array();
			$items[1] = new stdclass;
			$items[1]->id = 1;
			$items[1]->au = 1;
			$items[1]->price = 1;
			$items[1]->time = 1;
			$items[1]->status = 1;*/
			$this->_makeXls($name,$items);
		}
		else
		{
			$this->load->view('report');
		}
	}
	
	public function _makeXls($name , $items)
	{
		
		$data = array();
		$data[] = array('Id','Authority','Price (toman)','Date','Status?');
		foreach($items as $item)
			$data[] = array($item->id,(string) $item->au,$item->price,pdate('Y-m-d H:i',$item->time),$item->status?'TRUE':'    ');
		
		// filename for download 
		$filename = "{$name}-at-" . pdate('Y-m-d') . ".xls"; 
		header("Content-Disposition: attachment; filename=\"{$filename}\"");
		header("Content-Type: application/vnd.ms-excel;charset=UTF-8");
		foreach($data as $row) 
		{ 
			 array_walk($row, 'cleanData');
			echo implode("\t", array_values($row)) . "\r\n"; 
		}
		//Yii::app()->end();
		exit;
	}
	
	static public function _str2time($str = NULL)
		{
			if( ! $str)
				return '0000000000';
			$t1 = explode('-',$str);
			
			if( ! is_array($t1) or count($t1)<3)
				return '0000000000';
			$t1 = array_map('intval',$t1);
			return (int) pmktime(0,1,1,$t1[1],$t1[2],$t1[0]);
		}
	
}
function cleanData(&$str)
 { 
	 $str = preg_replace("/\t/", "\\t", $str); 
	 $str = preg_replace("/\r?\n/", "\\n", $str);
	  if(strstr($str, '"'))
	  $str = '"' . str_replace('"', '""', $str) . '"';
	  $str = mb_convert_encoding($str, 'UTF-8');
 }
