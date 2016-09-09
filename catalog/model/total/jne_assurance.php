<?php
class ModelTotalJneAssurance extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		$this->load->language('total/jne_assurance');

        $sub_total = $this->cart->getSubTotal();
        $sub_total = ($sub_total * 2 / 100) + 5000;
            
		$total_data[] = array(
			'code'       => 'sub_total',
			'title'      => $this->language->get('text_total'),
			'value'      => $sub_total,
			'sort_order' => $this->config->get('jne_assurance_sort_order')
		);

		$total += $sub_total;
	}
}