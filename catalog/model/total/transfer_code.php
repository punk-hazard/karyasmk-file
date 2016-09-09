<?php
class ModelTotalTransferCode extends Model {
	public function getTotal($total) {
		$this->load->language('total/transfer_code');

if(isset($this->session->data['transfer_code']) && $this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
    	
		$total['totals'][] = array(
			'code'       => 'transfer_code',
			'title'      => $this->language->get('text_transfer_code'),
			'value'      => !empty($this->config->get('transfer_code_sum')) ? -(int)$this->session->data['transfer_code'] :  (int)$this->session->data['transfer_code'],
			'sort_order' => ($this->config->get('total_sort_order') - 1)
		);
    
    if(!empty($this->config->get('transfer_code_sum')))
        $total['total'] -= (int)$this->session->data['transfer_code'];
    else 
        $total['total'] += (int)$this->session->data['transfer_code'];
	}
  }        
}