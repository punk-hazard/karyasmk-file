<?php
class ModelShippingJne extends Model {
	
public function getProductFiltered($shipping_code) {
		$product_filtered_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_shipping_filtered WHERE shipping_code = '" .$shipping_code . "' ORDER BY filtered_id ASC");
		foreach ($query->rows as $result) {
			$product_filtered_data[] = $result['product_id'];
		}
		return $product_filtered_data;
	}
 public function addProductFiltered($data,$shipping_code) {
 	$this->db->query("DELETE FROM " . DB_PREFIX . "product_shipping_filtered WHERE shipping_code = '" . $shipping_code . "'");
foreach ($data as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_shipping_filtered SET product_id = '" . (int)$product_id . "',  shipping_code = '" . $shipping_code . "'");
			}
		
	}
public function DeleteAllProductFiltered($shipping_code){
 	$this->db->query("DELETE FROM " . DB_PREFIX . "product_shipping_filtered WHERE shipping_code = '" . $shipping_code . "'");
	}
}