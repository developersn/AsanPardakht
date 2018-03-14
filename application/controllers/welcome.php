<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		$this->output->enable_profiler(false);
		if( ! empty($_POST['price']) and $_POST['price']>=100 and is_numeric($_POST['price']))
		{
			$data = array(
				'au'=>str_replace('.','_temp_',microtime(true)-1300000000) ,
				'price'=> (int) $_POST['price'] ,
				'description'=> strip_tags($_POST['desc']) ,
				'name'=> strip_tags($_POST['name']) ,
				'phone'=> strip_tags($_POST['mob']) ,
				'email'=> strip_tags($_POST['email']) ,
				'time'=> time(),
				'status'=> 0 ,
			);
			 $this->db->insert('order', $data);
			
			unset($data['description'] , $data['name'] , $data['phone'] , $data['email']  );
			$query = $this->db->get_where('order', $data, 1)->row();
			//print_r($query->id);
			// Security
			@session_start();
			$sec = uniqid();
			$md = md5($sec.'vm');
			// Security
			
			$api = $this->config->item('sn_api') ;
			$webservice = $this->config->item('sn_webservice') ;
			$amount = $data['price'] ; //Tooman
			$callbackUrl = site_url('welcome/back/'.$data['time']).'?order_id='.$query->id.'&md='.$md.'&sec='.$sec;
			$orderId = $query->id;			
		
	                        if($webservice==1){
			                $data_string = json_encode(array(
							'pin'=> $api,
							'price'=> $amount,
							'callback'=> $callbackUrl ,
							'order_id'=> $orderId,
							'ip'=> $_SERVER['REMOTE_ADDR'],
							'email'=>strip_tags($_POST['email']),
							'name'=>strip_tags($_POST['name']),
							'mobile'=>strip_tags($_POST['mob']),
							'callback_type'=>2
							));
	                        }
                        	else
	    
                            	   if($webservice==0){
                            	    $data_string = json_encode(array(
                            						'pin'=> $api,
                            							'price'=> $amount,
                            						'callback'=> $callbackUrl ,
                            						'order_id'=> $orderId,
                            						'ip'=> $_SERVER['REMOTE_ADDR'],
                            						'callback_type'=>2
                            						));
						
	                        }
      
							$ch = curl_init('https://developerapi.net/api/v1/request');
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Content-Type: application/json',
							'Content-Length: ' . strlen($data_string))
							);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
							$result = curl_exec($ch);
							curl_close($ch);
                                        
                                        
                                        $res=$json['result'];
                                        
                                        switch ($res) {
                                        case -1:
                                        $msg = "پارامترهای ارسالی برای متد مورد نظر ناقص یا خالی هستند . پارمترهای اجباری باید ارسال گردد";
                                        break;
                                        case -2:
                                        $msg = "دسترسی api برای شما مسدود است";
                                        break;
                                        case -6:
                                        $msg = "عدم توانایی اتصال به گیت وی بانک از سمت وبسرویس";
                                        break;
                                        
                                        case -9:
                                        $msg = "خطای ناشناخته";
                                        break;
                                        
                                        case -20:
                                        $msg = "پین نامعتبر";
                                        break;
                                        case -21:
                                        $msg = "ip نامعتبر";
                                        break;
                                        
                                        case -22:
                                        $msg = "مبلغ وارد شده کمتر از حداقل مجاز میباشد";
                                        break;
                                        
                                        
                                        case -23:
                                        $msg = "مبلغ وارد شده بیشتر از حداکثر مبلغ مجاز هست";
                                        break;
                                        
                                        case -24:
                                        $msg = "مبلغ وارد شده نامعتبر";
                                        break;
                                        
                                        case -26:
                                        $msg = "درگاه غیرفعال است";
                                        break;
                                        
                                        case -27:
                                        $msg = "آی پی مسدود شده است";
                                        break;
                                        
                                        case -28:
                                        $msg = "آدرس کال بک نامعتبر است ، احتمال مغایرت با آدرس ثبت شده";
                                        break;
                                        
                                        case -29:
                                        $msg = "آدرس کال بک خالی یا نامعتبر است";
                                        break;
                                        
                                        case -30:
                                        $msg = "چنین تراکنشی یافت نشد";
                                        break;
                                        
                                        case -31:
                                        $msg = "تراکنش ناموفق است";
                                        break;
                                        
                                        case -32:
                                        $msg = "مغایرت مبالغ اعلام شده با مبلغ تراکنش";
                                        break;
                                        
                                        
                                        case -35:
                                        $msg = "شناسه فاکتور اعلامی order_id نامعتبر است";
                                        break;
                                        
                                        case -36:
                                        $msg = "پارامترهای برگشتی بانک bank_return نامعتبر است";
                                        break;
                                        case -38:
                                        $msg = "تراکنش برای چندمین بار وریفای شده است";
                                        break;
                                        
                                        case -39:
                                        $msg = "تراکنش در حال انجام است";
                                        break;
                                        
                                        case 1:
                                        $msg = "پرداخت با موفقیت انجام گردید.";
                                        break;
                                        
                                        default:
                                        $msg = $json['msg'];
                                        }






							$json = json_decode($result,true);
							if(!empty($json['result']) AND $json['result'] == 1)
							{
							// Set Session
							$_SESSION[$sec] = [
								'price'=>$amount ,
								'order_id'=>$invoice_id ,
								'au'=>$json['au'] ,
							];
							$this->db->where('id', $query->id);
							$this->db->update('order', array('au'=>$josn['au'])); 
							
							die('<div style="display:none">'.$json['form'].'</div>Please wait ... <script language="javascript">document.payment.submit(); </script>');
							
							}else{
							print_r($msg);
							die;
							}
		}
		$this->load->view('welcome_message');
	}
	
	function back($time = 0)
	{
				
		$time = (int) $time;
		
		$id = (int) $_GET['order_id'];
		$data = array(
			'time'=>$time ,
			'id'=>$id ,
			'status'=> 0 ,
		);
		$query = $this->db->get_where('order', $data, 1)->row();
		
		$out = array();
		if(empty($query))
			$out['status']=0;
		else
		{
		// Security
$sec=$_GET['sec'];
$mdback = md5($sec.'vm');
$mdurl=$_GET['md'];
// Security
$transData = $_SESSION[$sec];
$au=$transData['au']; //
						$bank_return = $_POST + $_GET ;
						$data_string = json_encode(array (
						'pin' => $this->config->item('sn_api'),
						'price' => $query->price,
						'order_id' => $query->id,
						'au' => $_GET['au'],
						'bank_return' =>$bank_return,
						));

						$ch = curl_init('https://developerapi.net/api/v1/verify');
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($data_string))
						);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
						$result = curl_exec($ch);
						curl_close($ch);
						$json = json_decode($result,true);

   $res=$json['result'];
                                        
                                        switch ($res) {
                                        case -1:
                                        $msg = "پارامترهای ارسالی برای متد مورد نظر ناقص یا خالی هستند . پارمترهای اجباری باید ارسال گردد";
                                        break;
                                        case -2:
                                        $msg = "دسترسی api برای شما مسدود است";
                                        break;
                                        case -6:
                                        $msg = "عدم توانایی اتصال به گیت وی بانک از سمت وبسرویس";
                                        break;
                                        
                                        case -9:
                                        $msg = "خطای ناشناخته";
                                        break;
                                        
                                        case -20:
                                        $msg = "پین نامعتبر";
                                        break;
                                        case -21:
                                        $msg = "ip نامعتبر";
                                        break;
                                        
                                        case -22:
                                        $msg = "مبلغ وارد شده کمتر از حداقل مجاز میباشد";
                                        break;
                                        
                                        
                                        case -23:
                                        $msg = "مبلغ وارد شده بیشتر از حداکثر مبلغ مجاز هست";
                                        break;
                                        
                                        case -24:
                                        $msg = "مبلغ وارد شده نامعتبر";
                                        break;
                                        
                                        case -26:
                                        $msg = "درگاه غیرفعال است";
                                        break;
                                        
                                        case -27:
                                        $msg = "آی پی مسدود شده است";
                                        break;
                                        
                                        case -28:
                                        $msg = "آدرس کال بک نامعتبر است ، احتمال مغایرت با آدرس ثبت شده";
                                        break;
                                        
                                        case -29:
                                        $msg = "آدرس کال بک خالی یا نامعتبر است";
                                        break;
                                        
                                        case -30:
                                        $msg = "چنین تراکنشی یافت نشد";
                                        break;
                                        
                                        case -31:
                                        $msg = "تراکنش ناموفق است";
                                        break;
                                        
                                        case -32:
                                        $msg = "مغایرت مبالغ اعلام شده با مبلغ تراکنش";
                                        break;
                                        
                                        
                                        case -35:
                                        $msg = "شناسه فاکتور اعلامی order_id نامعتبر است";
                                        break;
                                        
                                        case -36:
                                        $msg = "پارامترهای برگشتی بانک bank_return نامعتبر است";
                                        break;
                                        case -38:
                                        $msg = "تراکنش برای چندمین بار وریفای شده است";
                                        break;
                                        
                                        case -39:
                                        $msg = "تراکنش در حال انجام است";
                                        break;
                                        
                                        case 1:
                                        $msg = "پرداخت با موفقیت انجام گردید.";
                                        break;
                                        
                                        default:
                                        $msg = $json['msg'];
                                        }






                    if($json['result'] == 1)
			        {
					$out['status'] =1;
					$out['au'] =$_GET['au'];
					$_GET['au'] = $json['au'];
					$this->db->where('id', $id);
					$this->db->update('order', array('status'=>1)); 
					}
					else
					{
					$out['status'] =0;
						print_r($msg);
				    }
					}
				
		
		
		//print_r($out);
		$this->load->view('back',$out);
		
		
		
	}
	
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */