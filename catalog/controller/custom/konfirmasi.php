<?php 
class ControllerCustomKonfirmasi extends Controller {
	private $error = array(); 
	    
  	public function index() {

    if($this->config->get('konfirmasi_login_status')) {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('custom/konfirmasi', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', 'konfirmasi=1', 'SSL'));
		}
    }
        
  	$this->load->language('custom/konfirmasi');
  	$this->load->model('custom/konfirmasi');
    	
   $data['heading_title'] = $this->language->get('heading_title');
   $data['upload_transfer_receipt'] = (int)$this->config->get('konfirmasi_transfer_receipt');
	
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');
   
	$this->document->setTitle($this->language->get('heading_title'));	
	$this->load->model('custom/konfirmasi');

   
   $data['breadcrumbs'] = array();
	$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('custom/konfirmasi', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);			
    
            $data['orders'] = array();
        
        if ($this->customer->isLogged()) {
    
          $this->load->model('account/order');
        
        $order_total = $this->model_account_order->getTotalOrders();
        if(!$order_total) {
         $data['empty_order'] = 1;
        } else {
         $data['empty_order'] = 0;
        }

        $results = $this->model_account_order->getOrders();
        
        $data['order_total'] = $this->model_account_order->getTotalOrders();

		foreach ($results as $result) {
			$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
			$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);

			$data['orders'][] = array(
				'order_id'          => $result['order_id'],
				'payment_amount'    => $result['total'],
				'name'              => $result['firstname'] . ' ' . $result['lastname'],
				'status'            => $result['status'],
				'date_added'        => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'             => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value'])
			);
		}
    }
			// Payment Methods
			$method_data = array();
			
			$payment_address['country_id']=1;
			$payment_address['zone_id']=1;
			$payment_address['geo_zone_id']=null;

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('payment');
			
						$recurring = $this->cart->hasRecurringProducts();
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('payment/' . $result['code']);

					$method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, 1000000);

					if ($method) {
						if ($recurring) {
							if (method_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_payment_' . $result['code']}->recurringPayments()) {
								$method_data[$result['code']] = $method;
							}
						} else {
							$method_data[$result['code']] = $method;
						}
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$data['payment_methods'] = $method_data;
			
	
		if (isset($this->session->data['payment_method']['code'])) {
			$data['code'] = $this->session->data['payment_method']['code'];
		} else {
		   $data['code'] = null;
		} 
		
		 if(isset($this->request->post['code'])) {
			$data['upload_code'] = $this->request->post['code'];
		}
		else {
		$data['upload_code']='';
			}
			
	 	$data['heading_title'] = $this->language->get('heading_title');
	 	$data['logged'] =  $this->customer->isLogged() ? true : false;	 	
	 	$data['text_form_konfirmasi'] = $this->language->get('text_form_konfirmasi');
	 	$data['text_loading'] = $this->language->get('text_loading');
	 	$data['konfirmasi_status'] = $this->config->get('konfirmasi_transfer_receipt') ? true : false;

	 	
    	$data['entry_jml_bayar'] = $this->language->get('entry_jml_bayar');
	 	$data['entry_upload_bukti_transfer'] = $this->language->get('entry_upload_bukti_transfer');    	
    	$data['entry_no_order'] = $this->language->get('entry_no_order');
    	$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_bank_transfer'] = $this->language->get('entry_bank_transfer');
		$data['help_bank_transfer'] = $this->language->get('help_bank_transfer');
    	$data['entry_metode_pembayaran'] = $this->language->get('entry_metode_pembayaran');
    	$data['entry_tgl_bayar'] = $this->language->get('entry_tgl_bayar');
    	$data['entry_pengirim'] = $this->language->get('entry_pengirim');
    	$data['entry_nama_bank_pengirim'] = $this->language->get('entry_nama_bank_pengirim');
    	
    	$data['text_konfirmasi'] = $this->language->get('text_konfirmasi');
    	$data['text_your_details'] = $this->language->get('text_your_details');
    
    	$data['entry_enquiry'] = $this->language->get('entry_enquiry');
    	
    	$data['button_upload'] = $this->language->get('button_upload');
		$data['entry_captcha'] = $this->language->get('entry_captcha');
        
        $data['confirmed_orders'] = array();
        
        if ($this->customer->isLogged()) {
            $data['confirmed_orders'] = $this->model_custom_konfirmasi->getConfirmedOrders($this->customer->getId());
        }
        

		if (isset($this->error['jml_bayar'])) {
    		$data['error_jml_bayar'] = $this->error['jml_bayar'];
		} else {
			$data['error_jml_bayar'] = '';
		}
		if (isset($this->error['no_order'])) {
    		$data['error_no_order'] = $this->error['no_order'];
		} else {
			$data['error_no_order'] = '';
		}
		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}
		if (isset($this->error['bank_transfer'])) {
    		$data['error_bank_transfer'] = $this->error['bank_transfer'];
		} else {
			$data['error_bank_transfer'] = '';
		}
		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}		
		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}	
		if (isset($this->error['metode_pembayaran'])) {
			$data['error_metode_pembayaran'] = $this->error['metode_pembayaran'];
		} else {
			$data['error_metode_pembayaran'] = '';
		}
		if (isset($this->error['tgl_bayar'])) {
			$data['error_tgl_bayar'] = $this->error['tgl_bayar'];
		} else {
			$data['error_tgl_bayar'] = '';
		}
		if (isset($this->error['pengirim'])) {
			$data['error_pengirim'] = $this->error['pengirim'];
		} else {
			$data['error_pengirim'] = '';
		}
		
		
		if (isset($this->error['nama_bank_pengirim'])) {
			$data['error_nama_bank_pengirim'] = $this->error['nama_bank_pengirim'];
		} else {
			$data['error_nama_bank_pengirim'] = '';
		}
	
		$data['action'] = $this->url->link('custom/konfirmasi');

    	$data['button_submit'] = $this->language->get('button_submit');
       
        
		if (isset($this->request->post['no_order'])) {
			$data['no_order'] = $this->request->post['no_order'];
		} else {
			$data['no_order'] = '';
		}
if (isset($this->request->post['jml_bayar'])) {
			$data['jml_bayar'] = $this->request->post['jml_bayar'];
		} else {
			$data['jml_bayar'] = "";
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}

		if (isset($this->request->post['bank_transfer'])) {
			$data['bank_transfer'] = $this->request->post['bank_transfer'];
		} else {
			$data['bank_transfer'] = "";
		}
		
		if (isset($this->request->post['metode_pembayaran'])) {
			$data['metode_pembayaran'] = $this->request->post['metode_pembayaran'];
		} else {
			$data['metode_pembayaran'] = '';
		}
		if (isset($this->request->post['tgl_bayar'])) {
			$data['tgl_bayar'] = $this->request->post['tgl_bayar'];
		} else {
			$data['tgl_bayar'] = '';
		}
		if (isset($this->request->post['pengirim'])) {
			$data['pengirim'] = $this->request->post['pengirim'];
		} else {
			$data['pengirim'] = '';
		}
		if (isset($this->request->post['nama_bank_pengirim'])) {
			$data['nama_bank_pengirim'] = $this->request->post['nama_bank_pengirim'];
		} else {
			$data['nama_bank_pengirim'] = '';
		}
		
          if ($this->config->get('config_google_captcha_status')) {
			$this->document->addScript('https://www.google.com/recaptcha/api.js');

			$data['site_key'] = $this->config->get('config_google_captcha_public');
		} else {
			$data['site_key'] = '';
		}
        
			if (isset($this->request->post['captcha'])) {
			$data['captcha'] = $this->request->post['captcha'];
		} else {
			$data['captcha'] = '';
		}
 
 		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
        $this->response->setOutput($this->load->view('custom/konfirmasi', $data));
 	
  	}
		public function success() {
		$this->load->language('custom/konfirmasi');
		$this->load->model('custom/konfirmasi');

		$this->document->setTitle($this->language->get('heading_title')); 

      	$data['breadcrumbs'] = array();

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);

      	$data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('custom/konfirmasi'),
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$data['heading_title'] = $this->language->get('heading_title');
    	$data['text_message'] = sprintf($this->language->get('text_message'),$this->model_custom_konfirmasi->getOrderStatus());
    	$data['text_konfirmasi'] = $this->language->get('text_konfirmasi');
    	$data['button_submit'] = $this->language->get('button_submit');
 $data['button_continue'] = $this->language->get('button_continue');
    	$data['continue'] = $this->url->link('common/home');

		
            $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		
	       $this->response->setOutput($this->load->view('common/success', $data));

	}
	
  	private function validate() {
    	if ((utf8_strlen($this->request->post['no_order']) < 1)) {
      		$this->error['no_order'] = $this->language->get('error_no_order');
    	}
      if (utf8_strlen($this->request->post['jml_bayar']) < 4 ) {
      		$this->error['jml_bayar'] = $this->language->get('error_jml_bayar');
    	}
    	
    	if (utf8_strlen($this->request->post['bank_transfer']) < 3) {
      		$this->error['bank_transfer'] = $this->language->get('error_bank_transfer');
    	}

    	if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if (utf8_strlen($this->request->post['metode_pembayaran']) < 3) {
      		$this->error['metode_pembayaran'] = $this->language->get('error_metode_pembayaran');
    	}
    	if (utf8_strlen($this->request->post['tgl_bayar']) < 10) {
      		$this->error['tgl_bayar'] = $this->language->get('error_tgl_bayar');
    	}
    	if((int)$this->config->get('konfirmasi_transfer_receipt')) {
    		if (utf8_strlen($this->request->post['code']) < 40) {
      		$this->error['code'] = $this->language->get('error_code');	
    			}
    	}
    	if (utf8_strlen($this->request->post['pengirim']) < 3) {
      		$this->error['pengirim'] = $this->language->get('error_pengirim');
    	}
    	if (utf8_strlen($this->request->post['nama_bank_pengirim']) < 3) {
      		$this->error['nama_bank_pengirim'] = $this->language->get('error_nama_bank_pengirim');
    	}
        if(!$this->customer->isLogged()) {
                if ($this->config->get('config_google_captcha_status')) {
			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('config_google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

			$recaptcha = json_decode($recaptcha, true);

			if (!$recaptcha['success']) {
				$this->error['captcha'] = $this->language->get('error_captcha');
			}
		  }
		}
		return !$this->error;  
  	}	  
  	
  	public function upload() {
		$this->load->language('tool/upload');

		$json = array();

		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array();

			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

			$filetypes = explode("\n", $extension_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array();

			$allowed=array("image/png","image/jpeg","image/gif","image/bmp");
			
			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json) {
			$file = $filename . '.' . md5(mt_rand());

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file);

			// Hide the uploaded file name so people can not link to it directly.
			$this->load->model('tool/upload');

			$json['code'] = $this->model_tool_upload->addUpload($filename, $file);

			$json['success'] = $filename;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
    
    public function save() {
			$this->language->load('custom/konfirmasi');
			$this->load->model('custom/konfirmasi');
			
			$json=array();

    		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
	    $existOrder=$this->model_custom_konfirmasi->cekExistOrder($this->request->post['email'],$this->request->post['no_order']);
	   
	    if($existOrder > 0) { 
	     $existConfirm=$this->model_custom_konfirmasi->cekExistKonfirmasi($this->request->post['email'],$this->request->post['no_order']);
	      if($existConfirm < 1) {
              
            $this->model_custom_konfirmasi->insertKonfirmasi($this->request->post);
              $order_id = $this->request->post['no_order'];

        $this->load->model('account/order');

        // HTML Mail    
		$order_info = $this->model_account_order->getOrder($order_id);

              if($order_info) {    
            $mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->request->post['email']);
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('customer_email_subject'), $order_id ,$this->config->get('config_name')), ENT_QUOTES, 'UTF-8'));

              
              	$data['title'] = sprintf($this->language->get('admin_email_subject'), $order_info['order_id'], html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

			$data['text_greeting'] = sprintf($this->language->get('text_new_confirmation_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
    
            $data['store_name'] = $order_info['store_name'];
            $data['store_name'] = $order_info['store_name'];
			$data['store_url'] = $order_info['store_url'];
    
            $data['text_confirmation_detail'] =$this->language->get('text_confirmation_detail');
            $data['text_new_confirmation_greeting'] =$this->language->get('text_new_confirmation_greeting');
            $data['text_order_id'] =$this->language->get('text_order_id');
            $data['text_payment_amount'] =  $this->language->get('text_payment_amount');
            $data['text_confirmation_date'] =$this->language->get('text_confirmation_date');
            $data['text_email'] =  $this->language->get('text_email');
            $data['text_payment_method'] =  $this->language->get('text_payment_method');
            $data['text_bank_account'] =    $this->language->get('text_bank_account');
            $data['text_bank_account_name'] =$this->language->get('text_bank_account_name');
            $data['text_transfer_receipt'] =$this->language->get('text_transfer_receipt');
            $data['text_new_footer'] =$this->language->get('text_new_footer');
            $data['text_new_powered'] =$this->language->get('text_new_powered');
            $data['text_customer_name'] =$this->language->get('text_customer_name');
            $data['text_destination_bank'] =$this->language->get('text_destination_bank');
    
            $data['order_id'] = $order_info['order_id'];
            $data['customer_name'] = $order_info['firstname']." ".$order_info['lastname'];
            $data['confirmation_date'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
            $data['payment_amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'],$order_info['currency_value']);
            $data['payment_method'] = ucfirst(str_replace("_"," ",$this->request->post['metode_pembayaran']));
            $data['destination_bank'] = ucfirst(str_replace("_"," ",$this->request->post['bank_transfer']));
            $data['bank_account'] = ucfirst(str_replace("_"," ",$this->request->post['nama_bank_pengirim']));
            $data['bank_account_name'] = $this->request->post['pengirim'];
            $data['transfer_receipt'] = $this->getUploadLink($this->request->post['code']);

    
            $data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');		

            $data['text_footer'] = $this->language->get('text_new_confirmation');
			$data['text_powered'] = $this->language->get('text_new_powered'); 
				
            $mail->setHtml($this->load->view('custom/mail_konfirmasi', $data));
         
			$mail->send();  
                    
        // Send email to customer
           $mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
                  
			$mail->setTo($this->request->post['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('customer_email_subject'), $order_id ,$this->config->get('config_name')), ENT_QUOTES, 'UTF-8'));
              
            $data['text_customer_greeting'] =$this->language->get('text_customer_greeting');
            $data['text_footer_customer'] =$this->language->get('text_footer_customer');

              $mail->setHtml($this->load->view('custom/mail_konfirmasi_customer', $data));

			$mail->send();
          }
        $json['success']= sprintf($this->language->get('text_message'),$this->model_custom_konfirmasi->getOrderStatus());

		} else
	      {
            $json['success'] = '';
	        $json['error']['warning'] = $this->language->get('error_confirm_exist');
		  }
                 
	    }
	    else {
        $json['success'] = '';
	    $json['error']['warning'] = $this->language->get('error_order_notexist');
	  
	    }	
    } 
    
        
	if (isset($this->error['no_order'])) {
    		$json['error']['no_order'] = $this->error['no_order'];
		} else {
			$json['error']['no_order'] = '';
		}
		
		if (isset($this->error['email'])) {
    		$json['error']['email'] = $this->error['email'];
		} else {
			$json['error']['email'] = '';
		}
	
		if (isset($this->error['jml_bayar'])) {
			$json['error']['jml_bayar'] = $this->error['jml_bayar'];
		} else {
			$json['error']['jml_bayar'] = '';
		}
        
        if (isset($this->error['pengirim'])) {
			$json['error']['pengirim'] = $this->error['pengirim'];
		} else {
			$json['error']['pengirim'] = '';
		}
        
        if (isset($this->error['nama_bank_pengirim'])) {
			$json['error']['nama_bank_pengirim'] = $this->error['nama_bank_pengirim'];
		} else {
			$json['error']['nama_bank_pengirim'] = '';
		}
		
		if (isset($this->error['tgl_bayar'])) {
			$json['error']['tgl_bayar'] = $this->error['tgl_bayar'];
		} else {
			$json['error']['tgl_bayar'] = '';
		}
        
        if (isset($this->error['bank_transfer'])) {
			$json['error']['bank_transfer'] = $this->error['bank_transfer'];
		} else {
			$json['error']['bank_transfer'] = '';
		}
		
		
			if (isset($this->error['code'])) {
			$json['error']['code'] = $this->error['code'];
		} else {
			$json['error']['code'] = '';
		}
    
		$this->response->setOutput(json_encode($json));	
   } 
    
public function paymentAmount() {
    $this->load->model('account/order'); 
    
    $json = array();
    
        if(isset($this->request->get['order_id'])) {
            $order_info = $this->model_account_order->getOrder($this->request->get['order_id']);
                if($order_info) {
                $total = explode(".",$order_info['total']); 
                $json['total'] = $total[0]; 
                $json['symbol_left'] = $this->currency->getSymbolLeft($order_info['currency_code']);
                } else {
                $json['total'] = ''; 
                $json['symbol_left'] = $this->currency->getSymbolLeft($this->session->data['currency']);
                }
            }
    
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
}
    
protected function getUploadLink($code) {
        $this->load->model('tool/upload');
        
		$bukti_transfer=array();		
		    		 if($code) {
    	$upload_info = $this->model_tool_upload->getUploadByCode($code);
		$bukti_transfer= array(
								'value' => $upload_info['name'],
								'href'  => $this->url->link('tool/upload/download','&code=' . $upload_info['code'], 'SSL')
							);
							
				}	
		return $bukti_transfer;
	} 
    
}
