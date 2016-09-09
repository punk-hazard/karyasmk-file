<?php
class ModelTotalJnePk extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		$this->load->language('total/jne_pk');

 		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
        $value = $this->session->data['shipping_method']['cost'] * 2;   
		$total_data[] = array(
			'code'       => 'jne_pk',
			'title'      => $this->language->get('text_total'),
			'value'      => $value,
			'sort_order' => $this->config->get('jne_pk_sort_order')
		);

		$total += $value;
        
        }
    }
}