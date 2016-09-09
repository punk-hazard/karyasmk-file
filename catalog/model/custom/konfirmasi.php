<?php
class ModelCustomKonfirmasi extends Model {
	public function insertKonfirmasi($data) {
        
  	$this->load->language('custom/konfirmasi');
        
$this->db->query("INSERT INTO " . DB_PREFIX . "konfirmasi SET email = '" . $data['email']. "', no_order = '" .(int)$data['no_order']. "',tgl_bayar = '" . $data['tgl_bayar']. "', jml_bayar = '" . $data['jml_bayar']. "', bank_transfer = '" . $data['bank_transfer']. "', pengirim='".$data['pengirim']."', metode_pembayaran='".$data['metode_pembayaran']."', nama_bank_pengirim='".$data['nama_bank_pengirim']."', code='".$data['code']."', tanggal=NOW()");	
    
         $konfirmasi_id=$this->db->getLastId();
            $order_id = $data['no_order'];
        
        if((int)$this->config->get('konfirmasi_order_status')) {    
$this->db->query("UPDATE " . DB_PREFIX ."order SET order_status_id='".(int)$this->config->get('konfirmasi_order_status')."' WHERE order_id='".(int)$data['no_order']."'");  
        
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id. "', order_status_id = '" . (int)$this->config->get('konfirmasi_order_status') . "', notify = '0', comment = '".$this->language->get('text_payment_comment')."', date_added = NOW()");

         }
    
    if((int)$this->config->get('konfirmasi_substract_stock')) {   
        				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

        foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "'");

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "'");
					}
				}
            }
        $this->db->query("INSERT INTO " . DB_PREFIX . "konfirmasi_to_store SET konfirmasi_id = '" . (int)$konfirmasi_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "'");
	}
	
	public function getTotalConfirmations() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "konfirmasi");
		
		return $query->row['total'];
	}
	
     public function getConfirmedOrders($customer_id) {
        $data = array();
        
      	$query = $this->db->query("SELECT o.order_id FROM `".DB_PREFIX."order` as o, ".DB_PREFIX."konfirmasi as k  WHERE o.order_id = k.no_order AND o.customer_id = '".(int)$customer_id."' ");
        
        if($query) {
            foreach($query->rows as $row) {
                $data[] = $row['order_id'];
            }
        }
		return $data;
	}
	
    
	public function getOrderStatus() {
      	$query = $this->db->query("SELECT name FROM `" . DB_PREFIX . "order_status` where order_status_id='".(int)$this->config->get('konfirmasi_order_status')."' and language_id='".(int)$this->config->get('config_language_id')."'");
		
		return $query->row['name'];
	}
	
	
	public function cekExistOrder($email,$no_order) {
	$query =$this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE email='".$email."' and order_id='".$no_order."'");
	return $query->row['total'];
	}
	
	public function cekExistKonfirmasi($email,$no_order) {
	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "konfirmasi as k 
	WHERE k.email='".$email."' and k.no_order='".$no_order."'");
	return $query->row['total'];
	}
   
       
	public function getKonfirm($confirm_id) {
		$query = $this->db->query("SELECT DISTINCT k.*,o.order_status_id as order_status_id,o.order_id,os.name,kts.store_id FROM " . DB_PREFIX . "konfirmasi as k, `" . DB_PREFIX . "order` o, " . DB_PREFIX . "order_status as os, ".DB_PREFIX . "konfirmasi_to_store as kts WHERE k.konfirmasi_id=kts.konfirmasi_id AND k.email=o.email AND k.no_order=o.order_id AND os.order_status_id=o.order_status_id AND k.konfirmasi_id='".$confirm_id."'");
		return $query->row;
	}
    
	public function editKonfirm($order_id,$konfirmasi_id,$data) {
    if($this->config->get('konfirmasi_substract_stock')) { 
        
          // cek apakah order status id sama dengan sblmnya 
        $konfirmasi = $this->getKonfirm($konfirmasi_id);
        $order_status_id = $konfirmasi['order_status_id'];
        
        if((( $data['order_status_id'] + $order_status_id ) % 2 ) > 0) {   
            
                if($this->config->get('konfirmasi_return_stock_status') == $data['order_status_id']) {

        		// Stock subtraction
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "'");

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}
            }
        }
      }

	}
}
