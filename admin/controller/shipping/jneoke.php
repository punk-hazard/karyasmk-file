<?php
class ControllerShippingJneOke extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/jneoke');
 		$data['token'] = $this->session->data['token'];
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('shipping/jne');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('jneoke', $this->request->post);		
			if(isset($this->request->post['product_filtered'])) {
			$this->model_shipping_jne->addProductFiltered($this->request->post['product_filtered'],'jneoke.jneoke');		
			}
			else {
			$this->model_shipping_jne->DeleteAllProductFiltered('jneoke.jneoke');					
			}
			
			$this->session->data['success'] = $this->language->get('text_success');
					
		$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		
		$data['entry_total'] = $this->language->get('entry_total');
		$data['help_total'] = $this->language->get('help_total');
		
		$data['entry_product_filtered'] = $this->language->get('entry_product_filtered');
		$data['help_product_filtered'] = $this->language->get('help_product_filtered');
		
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
			'href'      => $this->url->link('shipping/jneoke', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
			
		/*categories*/
		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories(0);
	
		if (isset($this->request->post['product_filtered'])) {
			$products = $this->request->post['product_filtered'];
		} 
		elseif (isset($this->request->get['shipping_code'])) {		
			$products = $this->model_shipping_jne->getProductFiltered($this->request->get['shipping_code']);
		} 
		else {
			$products = array();
		}
	
		$data['product_filtered'] = array();
		$this->load->model('catalog/product');
		foreach ($products as $filtered_id) {
			$filtered_info = $this->model_catalog_product->getProduct($filtered_id);
			
			if ($filtered_info) {
				$data['product_filtered'][] = array(
					'product_id' => $filtered_info['product_id'],
					'name'       => $filtered_info['name']
				);
			}
		}
		
	
		$data['action'] = $this->url->link('shipping/jneoke', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
	
		if (isset($this->request->post['jneoke_total'])) {
			$data['jneoke_total'] = $this->request->post['jneoke_total'];
		} else {
			$data['jneoke_total'] = $this->config->get('jneoke_total');
		}

		if (isset($this->request->post['jneoke_geo_zone_id'])) {
			$data['jneoke_geo_zone_id'] = $this->request->post['jneoke_geo_zone_id'];
		} else {
			$data['jneoke_geo_zone_id'] = $this->config->get('jneoke_geo_zone_id');
		}
		
		if (isset($this->request->post['jneoke_status'])) {
			$data['jneoke_status'] = $this->request->post['jneoke_status'];
		} else {
			$data['jneoke_status'] = $this->config->get('jneoke_status');
		}
			if (isset($this->request->post['jneoke_tax_class_id'])) {
      		$data['jneoke_tax_class_id'] = $this->request->post['jneoke_tax_class_id'];
    	}  else {
			$data['jneoke_tax_class_id'] = $this->config->get('jneoke_tax_class_id');
    	}	
    			
		if (isset($this->request->post['jneoke_sort_order'])) {
			$data['jneoke_sort_order'] = $this->request->post['jneoke_sort_order'];
		} else {
			$data['jneoke_sort_order'] = $this->config->get('jneoke_sort_order');
		}				
		
		$this->load->model('localisation/geo_zone');
		
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$this->load->model('localisation/tax_class');
		
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
								
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/jneoke.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/jneoke')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
public function category() {
		$json = array();
				
		$this->load->model('catalog/product');
							
		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
							
		$results = $this->model_catalog_product->getProductsByCategoryId($category_id);
							
		foreach ($results as $result) {
			$json[] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model']
			);
		}
							
		$this->response->setOutput(json_encode($json));
	}

public function filtered() {
		$json = array();

		$this->load->model('catalog/product');
		$this->load->model('shipping/jne');
				
		if (isset($this->request->post['product_filtered'])) {
			$products = $this->request->post['product_filtered'];
		} 
		else {
			$products = $this->model_shipping_jne->getProductFiltered('jneoke.jneoke');
		} 
		/*else {
			$products = array();
		}*/
				
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
							
			if ($product_info) {
				$json[] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name'],
					'model'      => $product_info['model']
				);
			}
		}
							
		$this->response->setOutput(json_encode($json));
	}
}
?>