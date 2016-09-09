<?php
class ControllerSaleConfirm extends Controller { 
	private $error = array();

	public function index() {
		$this->load->language('sale/confirm');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('sale/confirm');
                
		$this->getList();
	}

public function history() {
		$this->load->language('sale/order');

		$data['text_no_results'] = $this->language->get('text_no_results');

		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_notify'] = $this->language->get('column_notify');
		$data['column_comment'] = $this->language->get('column_comment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$this->load->model('sale/order');

		$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('sale/confirm/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('sale/order_history.tpl', $data));
	}

	public function edit() {
		$this->load->language('sale/confirm');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/confirm');
				
		$data['column_no_order'] = $this->language->get('column_no_order');
		
		$this->getForm();
	}
	public function delete() {
		$this->load->language('sale/confirm');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/confirm');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $confirm_id) {
				$this->model_sale_confirm->deleteKonfirm($confirm_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		
        $data['token'] = $this->session->data['token'];
        
        if((int)$this->config->get('config_admin_limit') > 0) { 
			$limit=$this->config->get('config_admin_limit');
		} else {
			$limit=20;		
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date';
		}
        
        if (isset($this->request->get['filter_store_id'])) {
			$filter_store_id = $this->request->get['filter_store_id'];
		} else {
			$filter_store_id = '';
		}
        
          if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = '';
		}
        
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
        
         if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}
        
         if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
							
		$data['delete'] = $this->url->link('sale/confirm/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		
		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['confirms'] = array();

		$filter_data = array(
			'store_id'  => $filter_store_id,
			'order_status_id'  => $filter_order_status_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
		
        $this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();
        
        $this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        
		$konfirmasi_total = $this->model_sale_confirm->getTotalConfirms($filter_data);
		$results = $this->model_sale_confirm->getConfirms($filter_data);
		
		$this->load->model('tool/upload');
		
    	foreach ($results as $result) {	
					
			$data['confirms'][] = array(
				'konfirmasi_id' => $result['konfirmasi_id'],
				'no_order'   => $result['no_order'],
				'tgl_bayar'     => $this->formatDateId($result['tgl_bayar']),
				'email'     => $result['email'],
				'store'     => (int)$result['store_id'] ? $this->model_sale_confirm->getStoreName($result['store_id']) : $this->language->get('text_default_store'),
				'jml_bayar'     => $this->currency->format($result['jml_bayar'],$this->session->data['currency']),
				'bank_transfer'     => ucfirst(str_replace("_"," ",$result['bank_transfer'])),
				'metode_pembayaran'=> $result['metode_pembayaran'],
				'pengirim'=> $result['pengirim'],
				'nama_bank_pengirim'=> $result['nama_bank_pengirim'],
				'bukti_transfer'=> $this->getUploadLink($result['code']),
				'status_order'=> $result['name'],
				'edit'         => $this->url->link('sale/confirm/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'].'&konfirmasi_id=' . $result['konfirmasi_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_all_store'] = $this->language->get('text_all_store');
		$data['text_all_order_statuses'] = $this->language->get('text_all_order_statuses');
		$data['text_default_store'] = $this->language->get('text_default_store');

        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
		
		$data['column_store'] = $this->language->get('column_store');
		$data['column_no_order'] = $this->language->get('column_no_order');
		$data['column_bukti_transfer'] = $this->language->get('column_bukti_transfer');
		$data['column_tgl_bayar'] = $this->language->get('column_tgl_bayar');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_status_order'] = $this->language->get('column_status_order');
		$data['column_jml_bayar'] = $this->language->get('column_jml_bayar');		
		$data['column_action'] = $this->language->get('column_action');
		$data['column_bank_transfer'] = $this->language->get('column_bank_transfer');
		$data['column_pengirim'] = $this->language->get('column_pengirim');
		$data['column_metode_pembayaran'] = $this->language->get('column_metode_pembayaran');
		$data['column_nama_bank_pengirim'] = $this->language->get('column_nama_bank_pengirim');
		
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_filter'] = $this->language->get('button_filter');
 
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
        
         if ($filter_store_id) {
			$url .= '&filter_store_id='.$filter_store_id;
		} 
        
         if ($filter_order_status_id) {
			$url .= '&filter_order_status_id='.$filter_order_status_id;
		} 
		
$data['sort_tgl_bayar'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=tgl_bayar' . $url, 'SSL');
$data['sort_no_order'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=no_order' . $url, 'SSL');
$data['sort_email'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');
$data['sort_store_id'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=store_id' . $url, 'SSL');
$data['sort_jml_bayar'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=jml_bayar' . $url, 'SSL');
$data['sort_bank_transfer'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=bank_transfer' . $url, 'SSL');
$data['sort_metode_pembayaran'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=metode_pembayaran' . $url, 'SSL');
$data['sort_pengirim'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=pengirim' . $url, 'SSL');
$data['sort_status_order'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=status_order' . $url, 'SSL');
		
		$data['sort_confirm'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . '&sort=confirm' . $url, 'SSL');
		
			$url = '';
			

		if (isset($this->request->get['no_order'])) {
			$url .= '&no_order=' . $this->request->get['no_order'];
		}
		
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
												
		if (isset($this->request->get['email'])) {
			$url .= '&email=' . $this->request->get['email'];
		}
		if (isset($this->request->get['status_order'])) {
			$url .= '&status_order=' . $this->request->get['status_order'];
		}
		if (isset($this->request->get['date'])) {
			$url .= '&tgl_bayar=' . $this->request->get['tgl_bayar'];
		}
          if ($filter_store_id) {
			$url .= '&filter_store_id='.$filter_store_id;
		} 
        if ($filter_order_status_id) {
			$url .= '&filter_order_status_id='.$filter_order_status_id;
		} 
		
		$pagination = new Pagination();
		$pagination->total = $konfirmasi_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['filter_store_id'] = $filter_store_id;
		$data['filter_order_status_id'] = $filter_order_status_id;

		$data['results'] = sprintf($this->language->get('text_pagination'), ($konfirmasi_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($konfirmasi_total - $limit)) ? $konfirmasi_total : ((($page - 1) * $limit) + $limit), $konfirmasi_total, ceil($konfirmasi_total / $limit));


    $data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
				
	$this->response->setOutput($this->load->view('sale/confirm.tpl', $data));
	}

	protected function getUploadLink($code) {
		$bukti_transfer=array();		
		    		 if($code) {
    	$upload_info = $this->model_tool_upload->getUploadByCode($code);
		$bukti_transfer= array(
								'value' => $upload_info['name'],
								'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], 'SSL')
							);
							
				}	
		return $bukti_transfer;
	}
	private function getForm() {
        if(isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        } else {
            $order_id = '0';
        }
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_default'] = $this->language->get('text_default');
		$data['text_edit_confirm'] = $this->language->get('text_edit_confirm');
		$data['text_enabled'] = $this->language->get('text_enabled');
    	$data['text_disabled'] = $this->language->get('text_disabled');
        
		$data['entry_change_order_status'] = $this->language->get('entry_change_order_status');	

        
    	 $data['button_save'] = $this->language->get('button_save');
    	
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_receipt'] = $this->language->get('entry_receipt');
		$data['entry_send_email_notif'] = $this->language->get('entry_send_email_notif');
		$data['entry_send_email_notif_help'] = $this->language->get('entry_send_email_notif_help');
		$data['entry_bukti_transfer'] = $this->language->get('entry_bukti_transfer');
		$data['entry_no_order'] = $this->language->get('entry_no_order');
		$data['entry_tgl_bayar'] = $this->language->get('entry_tgl_bayar');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_jml_bayar'] = $this->language->get('entry_jml_bayar');		
		$data['entry_action'] = $this->language->get('entry_action');
		$data['entry_status_order'] = $this->language->get('entry_status_order');
		$data['entry_bank_transfer'] = $this->language->get('entry_bank_transfer');
		$data['entry_metode_pembayaran'] = $this->language->get('entry_metode_pembayaran');
		$data['entry_pengirim'] = $this->language->get('entry_pengirim');
		$data['entry_nama_bank_pengirim'] = $this->language->get('entry_nama_bank_pengirim');
		$data['button_delete'] = $this->language->get('button_delete');
		
		$data['button_send'] = $this->language->get('button_send');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_history_add'] = $this->language->get('button_history_add');
		$data['button_receipt_add'] = $this->language->get('button_receipt_add');
		$data['button_ip_add'] = $this->language->get('button_ip_add');
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_history'] = $this->language->get('tab_history');
		
		$data['text_history'] = $this->language->get('text_history');
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_notify'] = $this->language->get('entry_notify');
		$data['entry_comment'] = $this->language->get('entry_comment');
	
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
	 	if (isset($this->error['status_order'])) {
			$data['error_status_order'] = $this->error['status_order'];
		} else {
			$data['error_status_order'] = array();
		}
		
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
        
        if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}
        
        if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
							
		
			
		if (isset($this->request->get['konfirmasi_id'])) {
			$confirm_info = $this->model_sale_confirm->getKonfirm($this->request->get['konfirmasi_id']);
		}
		
$data['action'] = $this->url->link('sale/confirm/edit', 'token=' . $this->session->data['token'] . '&order_id=' . $order_id.'&konfirmasi_id=' . $this->request->get['konfirmasi_id'] . $url, 'SSL');
		
		$data['cancel'] = $this->url->link('sale/confirm', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$data['token'] = $this->session->data['token'];
			
		//LOAD MODEL 
		$this->load->model('localisation/order_status');	

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();	

        $this->load->model('sale/order');

        $order_info = $this->model_sale_order->getOrder($order_id);

		if ($order_info) {
            
        $data['store_name'] = $order_info['store_name'];
        $data['store_url'] = $order_info['store_url'];
        $data['order_id'] = $order_id;
            
        }
        
		if (isset($confirm_info)) {
		$this->load->model('tool/upload');	
		$upload_info = $this->model_tool_upload->getUploadByCode($confirm_info['code']);
		
		$bukti_transfer=array();
		
		if($confirm_info['code']) {
		$bukti_transfer= array(
								'value' => $upload_info['name'],
								'href'  => $this->url->link('tool/upload/download', 'token=' . $this->session->data['token'] . '&code=' . $upload_info['code'], 'SSL')
							);
		}
											
		$data['no_order'] = $confirm_info['no_order'];
		if(isset($confirm_info['no_receipt']))
		{
	$data['no_receipt'] = $confirm_info['no_receipt'];	
		 } else {
	$data['no_receipt'] = "";		 
		 }

		$data['tgl_bayar'] = $this->formatDateId($confirm_info['tgl_bayar']);
		$data['order_id']= $confirm_info['order_id'];                
		$data['konfirmasi_id']= $confirm_info['konfirmasi_id'];
		$data['store']= $confirm_info['store_id'] ? $this->model_sale_confirm->getStoreName($confirm_info['store_id']) : $this->language->get('text_default_store');
		$data['email'] = $confirm_info['email'];
		$data['order_status_id'] = $confirm_info['order_status_id'];
		$data['jml_bayar'] = $this->currency->format($confirm_info['jml_bayar'],'IDR',1,true);		
		$data['bank_transfer'] = ucfirst(str_replace("_"," ",$confirm_info['bank_transfer']));
		$data['pengirim'] = $confirm_info['pengirim'];
		$data['bukti_transfer'] = $bukti_transfer;
		$data['metode_pembayaran'] = $confirm_info['metode_pembayaran'];
		$data['nama_bank_pengirim'] = $confirm_info['nama_bank_pengirim'];

		} else {
			$data['no_order'] = '';
		$data['no_receipt'] = '';
		$data['store'] = '';
		$data['tgl_bayar'] = '';
		$data['order_id'] = '';
		$data['email'] = '';
		$data['order_status_id'] =  '';
		$data['jml_bayar'] = '';		
		$data['bank_transfer'] = '';
		$data['pengirim'] = '';
		$data['bukti_transfer'] ='';
		$data['nama_bank_pengirim'] = '';
		}
		
        // API login
			$this->load->model('user/api');

			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

			if ($api_info) {
				$data['api_id'] = $api_info['api_id'];
				$data['api_key'] = $api_info['key'];
				$data['api_ip'] = $this->request->server['REMOTE_ADDR'];
			} else {
				$data['api_id'] = '';
				$data['api_key'] = '';
				$data['api_ip'] = '';
			}

        
	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
				
	$this->response->setOutput($this->load->view('sale/confirm_form.tpl', $data));
	
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/confirm')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

private function formatDateId($date) {
		/*FORMAT TGL BAYAR*/
		   $format = array(
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu',
        'Jan' => 'Januari',
        'Feb' => 'Februari',
        'Mar' => 'Maret',
        'Apr' => 'April',
        'May' => 'Mei',
        'Jun' => 'Juni',
        'Jul' => 'Juli',
        'Aug' => 'Agustus',
        'Sep' => 'September',
        'Oct' => 'Oktober',
        'Nov' => 'November',
        'Dec' => 'Desember'
    );

    /* Fri, 04 Jun 1993 */
	$date = date('D, j M Y', strtotime($date));
	$date=strtr($date, $format);
	 
	return $date;
	}
	
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/confirm')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	public function addReceipt() {
		$this->language->load('sale/confirm');
		$this->load->model('sale/confirm');
				
		$json=array();
		
   	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_confirm->editReceipt($this->request->post['konfirmasi_id'],$this->request->post['no_receipt']);
			
			//$this->session->data['success'] = $this->language->get('text_success_receipt_added');
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
        
          if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id='.$filter_store_id;
		    } 
         if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id='.$filter_order_status_id;
		    } 
			
			$json['success']='ok';
			$json['description'] = $this->language->get('text_success_receipt_added');
		
			}
		
		 else {
  	$json['success']='';
  	$json['description']=$this->language->get('error_warning');
  				}
  				
  				
  				  //	$json['success']='ok';
  				  	
			$this->response->setOutput(json_encode($json));	
		
		}
}
?>
