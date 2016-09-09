<?php
class ModelKonfirmasiSetting extends Model {
	public function editsSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($group) . "'");

		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($group) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
			}
		}
	}
	public function uninstallTable() {
	$error=0;
    $sqls=array();
	$sqls[]="drop table IF EXISTS " . DB_PREFIX . "konfirmasi";
	$sqls[]="drop table IF EXISTS " . DB_PREFIX . "konfirmasi_to_store";
    
foreach($sqls as $sql)  {       
	if(!$this->db->query($sql)) 
	{
		$error++; 
		   }
    }
        
	if($error < 1)	
   return true;
   else 
   return false;
	}
	
	public function ifInstalled($type,$code) {
		$extension_data = array();
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' AND `code` = '" . $this->db->escape($code) . "' ");
		
		return $query->row['total'];
	}


	public function tableExist($table) {
		$extension_data = array();
		$query = $this->db->query("SHOW TABLES LIKE '%".$table."%'");
		return $query->num_rows;
	}

	public function installTable() {
    $error = 0;    
    $sqls = array();
        
    $sqls[]=" CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "konfirmasi_to_store` (
    `konfirmasi_id` int(11) NOT NULL,
    `store_id` int(11) NOT NULL,
    PRIMARY KEY (`konfirmasi_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$sqls[]=" CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "konfirmasi` (
  `konfirmasi_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL,
  `no_order` varchar(15) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `jml_bayar` int(11) NOT NULL,
  `bank_transfer` varchar(20) NOT NULL,
  `resi` varchar(30) NOT NULL,
  `metode_pembayaran` varchar(20) NOT NULL,
  `pengirim` varchar(80) NOT NULL,
  `nama_bank_pengirim` varchar(50) NOT NULL,
  `code` varchar(255) NOT NULL,
  `no_receipt` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`konfirmasi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
";

foreach($sqls as $sql)  {       
	if(!$this->db->query($sql)) 
	   $error++;
	 }
        
if($error < 1)	
   return true;
   else 
   return false;
        
    }
}
?>