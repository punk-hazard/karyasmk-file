<?php
class ControllerTotalTransferCode extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('total/transfer_code');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('transfer_code', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_substraction'] = $this->language->get('text_substraction');
		$data['text_addition'] = $this->language->get('text_addition');

		$data['entry_sum'] = $this->language->get('entry_sum');
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
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/total', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('total/transfer_code', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('total/transfer_code', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['transfer_code_status'])) {
			$data['transfer_code_status'] = $this->request->post['transfer_code_status'];
		} else {
			$data['transfer_code_status'] = $this->config->get('transfer_code_status');
		}

		if (isset($this->request->post['transfer_code_sum'])) {
			$data['transfer_code_sum'] = $this->request->post['transfer_code_sum'];
		} else {
			$data['transfer_code_sum'] = $this->config->get('transfer_code_sum');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('total/transfer_code', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/transfer_code')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}