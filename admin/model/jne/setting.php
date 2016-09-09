<?php
class ModelJneSetting extends Model {
public function ifInstalled($type,$code) {
		$extension_data = array();
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "extension WHERE `type` = '" . $this->db->escape($type) . "' AND `code` = '" . $this->db->escape($code) . "' ");
		
		return (int)$query->row['total'];
	}
public function uninstallTable() {
$sqls[]=" drop table IF EXISTS `" . DB_PREFIX . "country`";
$sqls[]=" RENAME TABLE `" . DB_PREFIX . "country_hpwd` TO " . DB_PREFIX . "country"; 
$sqls[]=" delete FROM `" . DB_PREFIX . "setting` where " . DB_PREFIX . "setting.code like '%jne%'";
$sqls[]=" ALTER TABLE `" . DB_PREFIX . "address` DROP `sub_district_id`; ";
$sqls[]=" ALTER TABLE `" . DB_PREFIX . "order` DROP `payment_sub_district_id`; ";
$sqls[]=" ALTER TABLE `" . DB_PREFIX . "affiliate` DROP `sub_district_id`; ";    
$sqls[]=" ALTER TABLE `" . DB_PREFIX . "order` DROP `shipping_sub_district_id`; ";

$error=0;
foreach ($sqls as $sql)
{

	if(!$this->db->query($sql)) 
	{
		$error++; 
		   }
	sleep(0.2);
		}
	  if($error < 1)	
   return true;
   else 
   return false;
}
	
public function countRows($table) {
	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "".$table."");
	return $query->row['total'];
	}
	public function tableExist($table) {
		$query = $this->db->query("SHOW TABLES LIKE '%".$table."%'");
		return $query->num_rows;
	}

	public function installTable() {
		$sqls=array();
		

if($this->tableExist('country_hpwd') < 1) {
$sqls[]="  RENAME TABLE " . DB_PREFIX . "country TO " . DB_PREFIX . "country_hpwd ; ";
}

$sqls[]=" ALTER TABLE " . DB_PREFIX . "address ADD sub_district_id INT(4) NOT NULL AFTER address_id ; ";
$sqls[]=" ALTER TABLE " . DB_PREFIX . "affiliate ADD sub_district_id INT(4) NOT NULL AFTER affiliate_id ; ";
$sqls[]=" ALTER TABLE `" . DB_PREFIX . "order` ADD payment_sub_district_id INT(4) NOT NULL AFTER payment_zone_id ; ";
$sqls[]=" ALTER TABLE `" . DB_PREFIX . "order` ADD shipping_sub_district_id INT(4) NOT NULL AFTER shipping_zone_id ; ";

$sqls[]=" CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "country (
  `country_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `code` varchar(10) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `address_format` varchar(200) NOT NULL,
  `iso_code_2` varchar(5) NOT NULL,
  `iso_code_3` varchar(5) NOT NULL,
  `postcode_required` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ; ";

$sqls[]="CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "product_shipping_filtered (
  `filtered_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `shipping_code` varchar(30) NOT NULL,
  PRIMARY KEY (`filtered_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ; ";

$error=0;
foreach ($sqls as $sql)
{

	if(!$this->db->query($sql)) 
	{
		$error++; 
		   }
	sleep(0.2);
		}
	  if($error < 1)	
   return true;
   else 
   return false;
   
	
}
public function insertBasicRows() {

$sqls[]=" TRUNCATE " . DB_PREFIX . "country";

$sqls[]="INSERT INTO " . DB_PREFIX . "country  (`country_id`, `name`, `code`, `status`, `address_format`, `iso_code_2`, `iso_code_3`, `postcode_required`) VALUES
(1, 'Bali', '', '1', '', '', '', '1'),
(2, 'Bangka Belitung', '', '1', '', '', '', '1'),
(3, 'Banten', '', '1', '', '', '', '1'),
(4, 'Bengkulu', '', '1', '', '', '', '1'),
(5, 'DI Yogyakarta', '', '1', '', '', '', '1'),
(6, 'DKI Jakarta', '', '1', '', '', '', '1'),
(7, 'Gorontalo', '', '1', '', '', '', '1'),
(8, 'Jambi', '', '1', '', '', '', '1'),
(9, 'Jawa Barat', '', '1', '', '', '', '1'),
(10, 'Jawa Tengah', '', '1', '', '', '', '1'),
(11, 'Jawa Timur', '', '1', '', '', '', '1'),
(12, 'Kalimantan Barat', '', '1', '', '', '', '1'),
(13, 'Kalimantan Selatan', '', '1', '', '', '', '1'),
(14, 'Kalimantan Tengah', '', '1', '', '', '', '1'),
(15, 'Kalimantan Timur', '', '1', '', '', '', '1'),
(16, 'Kalimantan Utara', '', '1', '', '', '', '1'),
(17, 'Kepulauan Riau', '', '1', '', '', '', '1'),
(18, 'Lampung', '', '1', '', '', '', '1'),
(19, 'Maluku', '', '1', '', '', '', '1'),
(20, 'Maluku Utara', '', '1', '', '', '', '1'),
(21, 'Nanggroe Aceh Darussalam (NAD)', '', '1', '', '', '', '1'),
(22, 'Nusa Tenggara Barat (NTB)', '', '1', '', '', '', '1'),
(23, 'Nusa Tenggara Timur (NTT)', '', '1', '', '', '', '1'),
(24, 'Papua', '', '1', '', '', '', '1'),
(25, 'Papua Barat', '', '1', '', '', '', '1'),
(26, 'Riau', '', '1', '', '', '', '1'),
(27, 'Sulawesi Barat', '', '1', '', '', '', '1'),
(28, 'Sulawesi Selatan', '', '1', '', '', '', '1'),
(29, 'Sulawesi Tengah', '', '1', '', '', '', '1'),
(30, 'Sulawesi Tenggara', '', '1', '', '', '', '1'),
(31, 'Sulawesi Utara', '', '1', '', '', '', '1'),
(32, 'Sumatera Barat', '', '1', '', '', '', '1'),
(33, 'Sumatera Selatan', '', '1', '', '', '', '1'),
(34, 'Sumatera Utara', '', '1', '', '', '', '1'); ";
	

$error=count($sqls);
foreach($sqls as $sql) {
   if($this->db->query($sql))  
   $error--;
   }

  if($error < 1)
    return true;
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
?>