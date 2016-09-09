<?php
class ModelShippingKontakShipping extends Model {
	function getQuote($address) {
		$this->load->language('shipping/kontak_shipping');
			
		$method_data = array();
	
   $berat = $this->cart->getWeight();
   $unit=$this->weight->getUnit($this->config->get('config_weight_class_id'));
        
    if($unit == 'g') {
   $berat = $berat;
   } else if($unit == 'kg') {
    $berat = $berat * 1000;
   }
        
        // normalization
    if($berat == 0) {
    $berat = 1;
        } 
        
		$quote_data = array();
      	$quote_data['kontak_shipping'] = array(
        		'code'         => 'kontak_shipping.kontak_shipping',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => 0,
        		'weight'        => $berat / 1000,
                'text_kg'         => $this->language->get('text_kg'),
        		'text_day'         => $this->language->get('text_day'),
        		'etd'        => '0',
        		'tax_class_id' => 0,
                'text'         => $this->currency->format(0, $this->session->data['currency'])
      		);

      		$method_data = array(
        		'code'       => 'kontak_shipping',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('kontak_shipping_sort_order'),
        		'error'      => false
      		);
		
	
		return $method_data;
	}
}
?>