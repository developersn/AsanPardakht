<?php  

defined('BASEPATH') or exit('E:Login');

class Login extends CI_Controller {
	public $time_in_moderate = 60 ; //minute
	
		private function _is_admin()
		{
			$this->load->library('session');
			$user_id = $this->session->userdata('user_id');
			if($user_id == $_SERVER['REMOTE_ADDR'])
				return true ;
				return false;
		}
		

	function index()
	{
		$this->main->session_start();
		$this->load->library('session');
		if($this->_is_admin())
			redirect('admin');
			
		if( ! empty($_POST['user_name']))
		{
			$username = strip_tags($_POST['user_name']);
			$c_username = $this->config->item('username');
			$u = ($username == $c_username)?true:false ;
			
			if(empty($u))
				redirect('login?m=2');
				
			$pass = strip_tags($_POST['pass']);
			$c_pass = $this->config->item('password');
			$u = ($pass == $c_pass)?1:0 ;
			
			if(empty($u))
				redirect('login?m=2');

			$this->load->library('elxiscaptcha');
			if( ! $this->elxiscaptcha->_check_captcha($_POST['capt'],$_SESSION['captlogin']))
				redirect('login?m=7');
			
			
				// add prev activity
				$this->session->set_userdata('prev_activity', time());
				$this->session->set_userdata('user_id', $_SERVER['REMOTE_ADDR']);
				redirect('admin');

			
			
		}
		else
			$this->load->view('admin/login');
	}
	
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
