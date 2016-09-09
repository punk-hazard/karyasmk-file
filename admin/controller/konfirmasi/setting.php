<?php
class ControllerKonfirmasiSetting extends Controller { 
	private $error = array();
	public function index() {

		$this->load->language('konfirmasi/setting');
				$this->document->setTitle($this->language->get('heading_title'));
				
			$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('konfirmasi/setting', 'token=' . $this->session->data['token'],'SSL')
   		);
   		
		
		$data['settings'] = array(
            'install'   => $this->url->link('konfirmasi/setting/install', 'token=' . $this->session->data['token'], 'SSL'),
            'uninstall' => $this->url->link('konfirmasi/setting/uninstall', 'token=' . $this->session->data['token'], 'SSL'),
            'installed' => $this->cleansUpTable()
        );

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('konfirmasi', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

		}
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_order_status'] = $this->language->get('text_order_status');
		$data['text_activate_confirmation'] = $this->language->get('text_activate_confirmation');
		$data['text_list_limit'] = $this->language->get('text_list_limit');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_enable'] = $this->language->get('text_enable');
		$data['text_disable'] = $this->language->get('text_disable');
		$data['text_install_table'] = $this->language->get('text_install_table');
        
		$data['button_save'] = $this->language->get('button_save');
		
		$data['action'] = $this->url->link('konfirmasi/setting', 'token=' . $this->session->data['token'], 'SSL');
        
		$data['entry_substract_stock'] = $this->language->get('entry_substract_stock');
		$data['entry_return_stock_status'] = $this->language->get('entry_return_stock_status');
		$data['help_return_stock_status'] = $this->language->get('help_return_stock_status');
		
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_login_confirmation'] = $this->language->get('text_login_confirmation');
		$data['text_transfer_receipt_mandatory'] = $this->language->get('text_transfer_receipt_mandatory');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['button_install'] = $this->language->get('button_install');
		$data['button_uninstall'] = $this->language->get('button_uninstall');

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
        
        $this->load->model('localisation/order_status');	

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();	
        
	/*POST DATA HANDLING*/

        if (isset($this->request->post['konfirmasi_status'])) {
			$data['konfirmasi_status'] = $this->request->post['konfirmasi_status'];
		} else {
			$data['konfirmasi_status'] = $this->config->get('konfirmasi_status');
		}
        
        if (isset($this->request->post['konfirmasi_login_status'])) {
			$data['konfirmasi_login_status'] = $this->request->post['konfirmasi_login_status'];
		} else {
			$data['konfirmasi_login_status'] = $this->config->get('konfirmasi_login_status');
		}
        
        if (isset($this->request->post['konfirmasi_substract_stock'])) {
			$data['konfirmasi_substract_stock'] = $this->request->post['konfirmasi_substract_stock'];
		} else {
			$data['konfirmasi_substract_stock'] = $this->config->get('konfirmasi_substract_stock');
		}   
        
        if (isset($this->request->post['konfirmasi_return_stock_status'])) {
			$data['konfirmasi_return_stock_status'] = $this->request->post['konfirmasi_return_stock_status'];
		} else {
			$data['konfirmasi_return_stock_status'] = $this->config->get('konfirmasi_return_stock_status');
		}
        
        if (isset($this->request->post['konfirmasi_order_status'])) {
			$data['konfirmasi_order_status'] = $this->request->post['konfirmasi_order_status'];
		} else if($this->config->get('konfirmasi_order_status')) {
			$data['konfirmasi_order_status'] = $this->config->get('konfirmasi_order_status');
		} else {
			$data['konfirmasi_order_status'] = $this->config->get('config_order_status_id');        
        }
        
		if (isset($this->request->post['konfirmasi_list_limit'])) {
			$data['konfirmasi_list_limit'] = $this->request->post['konfirmasi_list_limit'];
		} else {
			$data['konfirmasi_list_limit'] = $this->config->get('konfirmasi_list_limit');
		}
		
			if (isset($this->request->post['konfirmasi_transfer_receipt'])) {
			$data['konfirmasi_transfer_receipt'] = $this->request->post['konfirmasi_transfer_receipt'];
		} else {
			$data['konfirmasi_transfer_receipt'] = $this->config->get('konfirmasi_transfer_receipt');
		}
		
	$data['modules'] = array();
		
		if (isset($this->request->post['konfirmasi_module'])) {
			$data['modules'] = $this->request->post['konfirmasi_module'];
		} elseif ($this->config->get('konfirmasi_module')) { 
			$data['modules'] = $this->config->get('konfirmasi_module');
		}		
	
	
	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
				
	$this->response->setOutput($this->load->view('konfirmasi/setting.tpl', $data));

	}



	private function validate() {
		if (!$this->user->hasPermission('modify', 'konfirmasi/setting')) {
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

public function install() {
		$this->load->model('konfirmasi/setting');
		$table_exist=$this->model_konfirmasi_setting->tableExist('konfirmasi');
		if($table_exist < 1)
		{
		 		if($this->model_konfirmasi_setting->installTable())
		 		{
			$this->response->redirect($this->url->link('konfirmasi/setting', 'token=' . $this->session->data['token']."&uninstall=true", 'SSL'));	
		 			}
		  }
		}
public function uninstall() {
		$this->load->model('konfirmasi/setting');
		if($this->model_konfirmasi_setting->uninstallTable())
		 {
			$this->response->redirect($this->url->link('konfirmasi/setting', 'token=' . $this->session->data['token']."&uninstall=true", 'SSL'));	
		 		}
		}
		
private function cleansUpTable()	
{
	$this->load->model('konfirmasi/setting');
	$error=0;
	if($this->model_konfirmasi_setting->tableExist('konfirmasi') < 1)
	{
	 $error++;
	  }
	
	if($error < 1)	
   return true;
   else 
   return false;
		}
}
?>