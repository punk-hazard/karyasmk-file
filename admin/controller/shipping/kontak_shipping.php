<?php
class ControllerShippingKontakShipping extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/kontak_shipping');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('kontak_shipping', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['help_total'] = $this->language->get('help_total');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/kontak_shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('shipping/kontak_shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
	
		if (isset($this->request->post['kontak_shipping_total'])) {
			$data['kontak_shipping_total'] = $this->request->post['kontak_shipping_total'];
		} else {
			$data['kontak_shipping_total'] = $this->config->get('kontak_shipping_total');
		}

		if (isset($this->request->post['kontak_shipping_geo_zone_id'])) {
			$data['kontak_shipping_geo_zone_id'] = $this->request->post['kontak_shipping_geo_zone_id'];
		} else {
			$data['kontak_shipping_geo_zone_id'] = $this->config->get('kontak_shipping_geo_zone_id');
		}
		
		if (isset($this->request->post['kontak_shipping_status'])) {
			$data['kontak_shipping_status'] = $this->request->post['kontak_shipping_status'];
		} else {
			$data['kontak_shipping_status'] = $this->config->get('kontak_shipping_status');
		}
		
		if (isset($this->request->post['kontak_shipping_sort_order'])) {
			$data['kontak_shipping_sort_order'] = $this->request->post['kontak_shipping_sort_order'];
		} else {
			$data['kontak_shipping_sort_order'] = $this->config->get('kontak_shipping_sort_order');
		}				
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
								
			$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/kontak_shipping.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/kontak_shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>