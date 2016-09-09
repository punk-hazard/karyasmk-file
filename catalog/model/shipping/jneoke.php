<?php
class ModelShippingJneOke extends Model {
	function getQuote($address) {
		$this->load->language('shipping/jneoke');
 
   $berat = $this->cart->getWeight();
   $unit=$this->weight->getUnit($this->config->get('config_weight_class_id'));
      
// format in KG
    if($unit == 'g') {
   $berat = round($berat / 1000,1,PHP_ROUND_HALF_UP);
   } else if($unit == 'kg') {
    $berat = round($berat,1,PHP_ROUND_HALF_UP);
   }
        
    $costs = array();
    if(!empty($address['sub_district_id'])) {
    $costs = $this->cache->getCosts($this->config->get('jne_city_id'),$address['sub_district_id'],1000,"OKE","JNE");
    }
		if ($costs) {
			$status = true;

                if ($this->cart->getSubTotal() < $this->config->get('jneoke_total')) {
			$status = false;
		}
		
		} else {
			$status = false;
		} // else of address selection query
		

		
		$method_data = array();

        
		if ($status) {
            
		$text=false;
		$query_filter=$this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_shipping_filtered WHERE shipping_code='jneoke.jneoke'");
		if((int)$query_filter->row['total'] > 0) {
		
		$products_data=$this->getProducts();
		if(!empty($products_data))
		{
				/*create array from product_data*/
			$products_id=array();
			foreach($products_data as $k => $v) {
			array_push($products_id,$v['product_id']);
			}

		/*select product notification*/
		$arr_error=array();
		$arr_test=array();
	
		$products=$this->getProductFiltered('jneoke.jneoke');
	    foreach ($products as $product_id) {
			array_push($arr_test,$product_id);
		}

		  $product_error=$this->is_in_array($arr_test,$products_id);
		 if($product_error || gettype($product_error) == 'array') {
				$text=$this->language->get('text_method_failed')."<br/> <ol>";
				foreach($products_data as $k => $v) {
					if(in_array($v['product_id'],$product_error))
						$text.="<li>".$v['name']."</li>";
				}  
				$text.="</ol>";
			} 
		else {
			$text=false;
			} 
		}
	} // end of filter products 
        $cost = $costs['cost'];
       
            
        $berat = explode('.',$berat);
		
        if(empty($berat[1]))
		{ 
			$berat[1]=0;
		   }
			/* penentuan harga */
		
        if ((float)$berat[0] < 1){
		$cost = $cost;	
		$berat=$berat[0].".".$berat[1];	
		}
		elseif((float)$berat[1]<=3){
		$cost = $berat[0] * $cost;
		$berat=$berat[0];
		}
		else{
		$cost = ($berat[0]+1) * $cost;
		$berat=$berat[0].".".$berat[1];
		}
            
            /*total shipping*/
		$h_fee=(float)$this->config->get('jne_handling_fee');
		if($this->config->get('jne_handling_fee_mode') == "perweight") {
		  $cost += ($h_fee*(int)$berat);
		} else {
		  $cost += $h_fee;
		}
      
            
			$quote_data = array();
			
      		$quote_data['jneoke'] = array(
        		'code'         => 'jneoke.jneoke',
        		'title'        => $this->language->get('text_description'),
        		'cost'         => $cost,
                'text_kg'         => $this->language->get('text_kg'),
        		'text_day'         => $this->language->get('text_day'),
        		'weight'         => $berat,
        		'image'         => 'catalog/view/theme/default/image/shipping/jneoke.png',
        		'etd'         => $costs['etd'],
        		'tax_class_id' => $this->config->get('jneoke_tax_class_id'),
                'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('jneoke_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
      		);

      		$method_data = array(
        		'code'       => 'jneoke.jneoke',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('jneoke_sort_order'),
        		'error'      => $text
      		);
		}
	
		return $method_data;
	}
private function getProducts() {
	 $products_data= array();

            $products = $this->cart->getProducts();

            foreach ($products as $product) {
                $product_total = 0;

                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total += $product_2['quantity'];
                    }
                }
                $products_data[] = array(
                    'product_id'          => $product['product_id'],
                    'name'                => $product['name'],
                );
            }
			/*END OF PRODUCT DATA*/
		return $products_data;
	}
 function is_in_array($needle, $haystack) {
$a=array();
    foreach ($needle as $stack) {

        if (in_array($stack, $haystack)) {
             array_push($a,$stack);
        }
    }
	if(count($a)> 0)
	return $a;
	else 
	return false;
	}
public function getProductFiltered($shipping_code) {
		$product_filtered_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_shipping_filtered WHERE shipping_code = '" .$shipping_code . "' ORDER BY filtered_id ASC");
		foreach ($query->rows as $result) {
			$product_filtered_data[] = $result['product_id'];
		}
		return $product_filtered_data;
	}
}
?>