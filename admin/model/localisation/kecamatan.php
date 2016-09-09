<?php
class ModelLocalisationKecamatan extends Model {
	public function getKecamatan($kecamatan_id) {
		$query = $this->db->query("SELECT * FROM ochpwd_kecamatan WHERE kecamatan_id = '" . (int)$kecamatan_id . "' AND status = '1'");
		return $query->row;
	}		
	
		public function getKecamatansByKabupatenId($kabupaten_id) {
		//$kecamatan_data= $this->cache->get('kecamatan.' . (int)$kabupaten_id);
		$kecamatan_data=0;
		if (!$kecamatan_data) {
			$query = $this->db->query("SELECT * FROM ochpwd_kecamatan WHERE kabupaten_id = '" . (int)$kabupaten_id . "' AND status = '1' ORDER BY name");
	
			$kecamatan_data= $query->rows;
			
			//$this->cache->set('kecamatan.' . (int)$kabupaten_id, $kecamatan_data);
		}
	
		return $kecamatan_data;
	}
//SELECT ok.kecamatan_id,oz.zone_id, oz.name as zone, ok.name FROM `oc_kecamatan` as ok, oc_zone as oz WHERE oz.zone_id=ok.kabupaten_id and ok.status=oz.status and ok.status='1' AND ok.name like '%gabus%'

public function getKecamatanByName($data = array()) {
		if ($data) {
			$sql = "SELECT ok.kecamatan_id,oz.zone_id, oz.name as zone, ok.name, oc.country_id, oc.name as country FROM ochpwd_kecamatan as ok, " . DB_PREFIX . "zone as oz, " . DB_PREFIX . "country as oc WHERE oz.zone_id=ok.kabupaten_id and ok.status=oz.status and oz.country_id=oc.country_id";
			
		$sort_data = array(
				'ok.name',
				'oz.zone_id'
			);	
			
			if (isset($data['filter_zone_id']) && !empty($data['filter_zone_id'])) {
				$sql .= " AND oz.zone_id='".$data['filter_zone_id']."'";	
			} 
			
			if (isset($data['filter_name'])) {
				$sql .= " AND ok.name like '%" . $data['filter_name']."%'";	
			} 
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY ok.name";	
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			if (isset($data['limit'])) {
				$sql .= " LIMIT 0,".$data['limit']."";
			} 
		
			$query = $this->db->query($sql);

			return $query->rows;
		}		
		 else {
			$query = $this->db->query("SELECT ok.kecamatan_id,oz.zone_id, oz.name as zone, ok.name, oc.country_id, oc.name as country FROM ochpwd_kecamatan as ok, " . DB_PREFIX . "zone as oz, " . DB_PREFIX . "country as oc WHERE oz.zone_id=ok.kabupaten_id and ok.status=oz.status and oz.country_id=oc.country_id");
			
			return $query->rows;

			}
	}	

}
?>