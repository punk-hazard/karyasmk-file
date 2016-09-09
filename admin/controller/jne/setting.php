<?php
class ControllerJneSetting extends Controller { 
	private $error = array();

	public function index() {
		$this->load->language('jne/setting');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('jne/setting');
		
 	$url="";
  $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('jne/setting', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['token'] = $this->session->data['token'];			
		
			if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
			}
		else if (isset($this->request->get['install']) && $this->request->get['install'] == "true") {
			$data['success'] = $this->language->get('success_install');	
		} 
		else if (isset($this->request->get['uninstall']) && $this->request->get['uninstall'] == "true") {
			$data['success'] = $this->language->get('success_uninstall');	
		}		
		else {
			$data['success'] = '';
		}	
		
	$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('jne', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
		}
	
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_options'] = $this->language->get('text_options');
		$data['text_shipping_basis'] = $this->language->get('text_shipping_basis');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['help_handling_fee'] = $this->language->get('help_handling_fee');
		$data['entry_handling_fee'] = $this->language->get('entry_handling_fee');
		$data['help_handling_fee_mode'] = $this->language->get('help_handling_fee_mode');

		$data['entry_handling_fee_mode'] = $this->language->get('entry_handling_fee_mode');
		$data['entry_progress'] = $this->language->get('entry_progress');
		$data['entry_province'] = $this->language->get('entry_province');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_sub_district'] = $this->language->get('entry_sub_district');
		$data['entry_wooden_package'] = $this->language->get('entry_wooden_package');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
				
		$data['text_total_mode'] = $this->language->get('text_total_mode');
		$data['text_weight_mode'] = $this->language->get('text_weight_mode');
		$data['text_none'] = $this->language->get('text_none');
		
		$data['tab_general'] = $this->language->get('tab_general');		
		$data['tab_upload'] = $this->language->get('tab_upload');		
		
		$data['entry_upload'] = $this->language->get('entry_upload');		
		$data['help_upload'] = $this->language->get('help_upload');		
		$data['entry_status'] = $this->language->get('entry_status');		

		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_loading'] = $this->language->get('text_loading');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_install'] = $this->language->get('button_install');
		$data['button_uninstall'] = $this->language->get('button_uninstall');
		$data['button_clear'] = $this->language->get('button_clear');
		
		$data['text_install_table'] = $this->language->get('text_install_table');
		$data['text_install'] = $this->language->get('text_install');
		$data['text_uninstall'] = $this->language->get('text_uninstall');
		$data['action'] = $this->url->link('jne/setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['settings'] = array(
					'install'   => $this->url->link('jne/setting/install', 'token=' . $this->session->data['token'], 'SSL'),
					'uninstall' => $this->url->link('jne/setting/uninstall', 'token=' . $this->session->data['token'], 'SSL'),
					'installed' => $this->cleansUpTable()
				);

	    $this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
        
        $data['token'] = $this->session->data['token'];
        
		 /*POST DATA HANDLING*/
		if (isset($this->request->post['jne_handling_fee'])) {
			$data['jne_handling_fee'] = $this->request->post['jne_handling_fee'];
		} else {
			$data['jne_handling_fee'] = $this->config->get('jne_handling_fee');
		}
        
		if (isset($this->request->post['jne_handling_fee_mode'])) {
			$data['jne_handling_fee_mode'] = $this->request->post['jne_handling_fee_mode'];
		} else {
			$data['jne_handling_fee_mode'] = $this->config->get('jne_handling_fee_mode');
		}
        
        if (isset($this->request->post['jne_province_id'])) {
			$data['jne_province_id'] = $this->request->post['jne_province_id'];
		} else {
			$data['jne_province_id'] = $this->config->get('jne_province_id');
		}
        
         if (isset($this->request->post['jne_wooden_package'])) {
			$data['jne_wooden_package'] = $this->request->post['jne_wooden_package'];
		} else {
			$data['jne_wooden_package'] = $this->config->get('jne_wooden_package');
		}
        
         if (isset($this->request->post['jne_city_id'])) {
			$data['jne_city_id'] = $this->request->post['jne_city_id'];
		} else {
			$data['jne_city_id'] = $this->config->get('jne_city_id');
		}
        
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
			}
		else if (isset($this->request->get['install']) && $this->request->get['install'] == "true") {
			$data['success'] = $this->language->get('success_install');	
		} 
		else if (isset($this->request->get['uninstall']) && $this->request->get['uninstall'] == "true") {
			$data['success'] = $this->language->get('success_uninstall');	
		}		
		else {
			$data['success'] = '';
		}
		
	$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
				
$this->response->setOutput($this->load->view('jne/jne_setting.tpl', $data));
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'jne/setting')) {
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

public function moveFile() {
$tmp_path=DIR_APPLICATION;
$default_path=HTTP_CATALOG."vqmod/xml";
if(!is_dir($tmp_path)) {
	   mkdir($default_path, 0755); 
  }
  if(rename($default_path."/jneshipping_halalprowebdesign.xml",$tmp_path."/jneshipping_halalprowebdesign.xml"))
   return true;
	else 
	return false;
}
	
public function uninstall() {
 		$this->load->model('jne/setting');
 		if($this->model_jne_setting->uninstallTable())
		 {
			$this->response->redirect($this->url->link('jne/setting', 'token=' . $this->session->data['token']."&uninstall=true", 'SSL'));	
		 		}
		 else {
			$this->response->redirect($this->url->link('jne/setting', 'token=' . $this->session->data['token']."&uninstall=false", 'SSL'));			 
		 }
}
public function install() {
		$this->load->model('jne/setting');

	$error=2;
		 	if($this->model_jne_setting->installTable())
		 {
			$error--;
		 		}
			if($this->model_jne_setting->insertBasicRows())
		 	{
		 	$error--;
		 		}
		 	if($error < 1)	
  					 	$this->response->redirect($this->url->link('jne/setting', 'token=' . $this->session->data['token']."&install=true", 'SSL'));	
   		else 
		 	$this->response->redirect($this->url->link('jne/setting', 'token=' . $this->session->data['token']."&install=false", 'SSL'));	
   		  }
private function cleansUpTable()	
{
	$error=0;
	$tables=array("country_hpwd","product_shipping_filtered");
	for($i=0; $i <= count($tables)-1; $i++) {
	if($this->model_jne_setting->tableExist($tables[$i]) < 1)
		{
		$error++;			
			}
		}
	
	if($error < 1)	
   return true;
   else 
   return false;
		}
	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			

			$data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);


		}

		$this->response->setOutput(json_encode($json));
	}
public function upload() {
		$this->load->language('jne/setting');
		$this->load->model('jne/setting');
		
		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'jne/setting')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			if (!empty($this->request->files['file']['name'])) {
				if (substr($this->request->files['file']['name'], -4) != '.csv' ) {
					$json['error'] = $this->language->get('error_filetype');
				}

				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}
			
	if (!$json) {
			// If no temp directory exists create it
			$path = 'temp-' . md5(mt_rand());

			if (!is_dir(DIR_APPLICATION."data/". $path)) {
				mkdir(DIR_APPLICATION."data/". $path, 0777);
			}
}
			// Set the steps required for installation
			$json['step'] = array();
			$json['overwrite'] = array();

			if (strrchr($this->request->files['file']['name'], '.') == '.csv') {
				$file = DIR_APPLICATION."data/" . $path . '/file.csv';
 
				// If CSV file copy it to the temporary directory
				move_uploaded_file($this->request->files['file']['tmp_name'], $file);

				if (file_exists($file)) {
				$json['step'][] = array(
						'text' => $this->language->get('text_csv'),
						'url'  => str_replace('&amp;', '&', $this->url->link('jne/setting/csv', 'token=' . $this->session->data['token'], 'SSL')),
						'path' => $path
					);

					// Clear temporary files
					$json['step'][] = array(
						'text' => $this->language->get('text_remove'),
						'url'  => str_replace('&amp;', '&', $this->url->link('jne/setting/remove', 'token=' . $this->session->data['token'], 'SSL')),
						'path' => $path,
						'filename' => $this->request->files['file']['name']
					);
				} else {
					$json['error'] = $this->language->get('error_file');
				}
			}


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
public function clear() {
		$this->load->language('jne/setting');

		$json = array();

		if (!$this->user->hasPermission('modify', 'jne/setting')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$directories = glob(DIR_APPLICATION.'data/temp-*', GLOB_ONLYDIR);

			foreach ($directories as $directory) {
				// Get a list of files ready to upload
				$files = array();

				$path = array($directory . '*');

				while (count($path) != 0) {
					$next = array_shift($path);

					foreach (glob($next) as $file) {
						if (is_dir($file)) {
							$path[] = $file . '/*';
						}

						$files[] = $file;
					}
				}

				sort($files);

				rsort($files);

				foreach ($files as $file) {
					if (is_file($file)) {
						unlink($file);
					} elseif (is_dir($file)) {
						rmdir($file);
					}
				}

				if (file_exists($directory)) {
					rmdir($directory);
				}
			}

			$json['success'] = $this->language->get('text_clear');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
public function csv() {
	$this->load->language('jne/setting');

		$json = array();

		if (!$this->user->hasPermission('modify', 'jne/setting')) {
			$json['error'] = $this->language->get('error_permission');
		}

		$file = DIR_APPLICATION."data/". str_replace(array('../', '..\\', '..'), '', $this->request->post['path']) . '/file.csv';

		if (!file_exists($file)) {
			$json['error'] = $this->language->get('error_file');
		}

		if (!$json) {
			$this->load->model('jne/setting');

			// If csv file just put it straight into the DB
			$csv = file_get_contents($file);

			if ($csv) {
				try {
				$this->model_jne_setting->importCSV($csv);
				$this->model_jne_setting->mergeTableKecamatan();
				} catch(Exception $exception) {
					$json['error'] = sprintf($this->language->get('error_exception'), $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine());
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

public function remove() {
		$this->load->language('jne/setting');

		$json = array();

		if (!$this->user->hasPermission('modify', 'jne/setting')) {
			$json['error'] = $this->language->get('error_permission');
		}
	
		$directory = DIR_APPLICATION ."data/". str_replace(array('../', '..\\', '..'), '', $this->request->post['path']);

		if (!is_dir($directory)) {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$json) {
			// Get a list of files ready to upload
			$files = array();

			$path = array($directory . '*');

			while (count($path) != 0) {
				$next = array_shift($path);

				foreach (glob($next) as $file) {
					if (is_dir($file)) {
						$path[] = $file . '/*';
					}

					$files[] = $file;
				}
			}

			sort($files);

			rsort($files);

			foreach ($files as $file) {
				if (is_file($file)) {
					unlink($file);
				} elseif (is_dir($file)) {
					rmdir($file);
				}
			}

			if (file_exists($directory)) {
				rmdir($directory);
			}

			$json['success'] = sprintf($this->language->get('text_success_import'),$this->request->post['filename']);
			
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>
