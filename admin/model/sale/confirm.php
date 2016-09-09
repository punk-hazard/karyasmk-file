<?php
class ModelSaleConfirm extends Model {
	
	public function deleteKonfirm($confirm_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "konfirmasi WHERE konfirmasi_id = '" . (int)$confirm_id . "'");

	}	

	public function getOrderStatus($order_status_id) {
      	$query = $this->db->query("SELECT name FROM " . DB_PREFIX . "order_status where order_status_id='".(int)$order_status_id."' and language_id='".(int)$this->config->get('config_language_id')."'");
		
		return $query->row['name'];
	}
	
	public function editReceipt($konfirmasi_id,$no_receipt) {
  	$this->db->query("UPDATE " . DB_PREFIX . "konfirmasi SET no_receipt = '" .$no_receipt. "'  WHERE konfirmasi_id='".$konfirmasi_id."'");
	}
	
     public function getStoreName($store_id){
    $query=$this->db->query("SELECT name FROM " . DB_PREFIX . "store WHERE store_id='".(int)$store_id."'");
    
    if($query->num_rows) {
        return $query->row['name'];
        }
    }
	
	public function uninstallTable() {
	$error=0;
	$sql="drop table IF EXISTS " . DB_PREFIX . "konfirmasi";
	if(!$this->db->query($sql)) 
	{
		$error++; 
		   }
	
	if($error < 1)	
   return true;
   else 
   return false;
	}
    
	public function getKonfirm($confirm_id) {
		$query = $this->db->query("SELECT DISTINCT k.*,o.order_status_id as order_status_id,o.order_id,os.name,kts.store_id FROM " . DB_PREFIX . "konfirmasi as k, `" . DB_PREFIX . "order` o, " . DB_PREFIX . "order_status as os, ".DB_PREFIX . "konfirmasi_to_store as kts WHERE k.konfirmasi_id=kts.konfirmasi_id AND k.email=o.email AND k.no_order=o.order_id AND os.order_status_id=o.order_status_id AND k.konfirmasi_id='".$confirm_id."'");
		return $query->row;
	}

	public function getConfirms($data = array()) {
		if ($data) {
			$sql = "SELECT DISTINCT k.*,o.order_status_id,o.order_id,os.name, kts.store_id FROM " . DB_PREFIX . "konfirmasi as k, `" . DB_PREFIX . "order` o, " . DB_PREFIX . "order_status as os , ".DB_PREFIX . "konfirmasi_to_store as kts WHERE k.konfirmasi_id=kts.konfirmasi_id ";
            
            if (isset($data['store_id']) && $data['store_id'] != "") {
				$sql .= " AND kts.store_id='".(int)$data['store_id']."' AND k.email=o.email AND k.no_order=o.order_id  AND os.order_status_id=o.order_status_id and o.language_id=os.language_id";	
			} else {
           $sql.=" AND k.email=o.email AND k.no_order=o.order_id  AND os.order_status_id=o.order_status_id and o.language_id=os.language_id";
           }
             
            if (isset($data['order_status_id']) && $data['order_status_id'] != "") {
           $sql.=" AND o.order_status_id='".(int)$data['order_status_id']."'";
            }
            		
			$sort_data = array(
				'no_order',
				'email',
				'tgl_bayar',
				'jml_bayar',
				'store_id',
				'bank_transfer',
				'metode_pembayaran',
				'pengirim'
			);		
		
                      
		 if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY k.no_order";	
		 	}
			
			if (isset($data['order']) && ($data['order'] == 'ASC')) {
				$sql .= " ASC";
			} else {
				$sql .= " DESC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}		

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
			
			return $query->rows;
		} else {		
				$query = $this->db->query("SELECT DISTINCT k.*,o.order_status_id,o.order_id,os.name FROM " . DB_PREFIX . "konfirmasi as k, `" . DB_PREFIX . "order` o, " . DB_PREFIX . "order_status as os WHERE k.email=o.email AND k.no_order=o.order_id AND os.order_status_id=o.order_status_id AND o.language_id=os.language_id ORDER BY k.no_order DESC"); 
	
			return $query->rows;
			
		}
	}
	
	public function getTotalConfirms($data = array()) {     
        if($data) {
			
		$sql="SELECT COUNT(*) AS total FROM " . DB_PREFIX . "konfirmasi as k, " . DB_PREFIX . "konfirmasi_to_store as kts WHERE k.konfirmasi_id=kts.konfirmasi_id";
		
		if (isset($data['store_id'])) {
			$sql .= " AND kts.store_id='".(int)$data['store_id']."'";
		}
        
            $query=$this->db->query($sql);
            
    } else {    
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "konfirmasi");
        }
		
        return $query->row['total'];
	}	
  
	public function getStatuses()
	{
	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status");
	
	return $query->row;
	
	}
	
	
}
?>
