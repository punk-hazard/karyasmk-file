<?php
class Cache {
	private $adaptor;

	public function __construct($adaptor, $expire = 3600) {
		$class = 'Cache\\' . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($expire);
		} else {
			throw new \Exception('Error: Could not load cache adaptor ' . $adaptor . ' cache!');
		}
	}
	
	/**
	 * Register a binding with the container.
	 *
	 * @param  string               $abstract
	 * @param  Closure|string|null  $concrete
	 * @param  bool                 $shared
	 * @return mixed
	*/
	public function get($key) {
		return $this->adaptor->get($key);
	}

	public function set($key, $value) {
		return $this->adaptor->set($key, $value);
	}

		
public function getCosts($origin_id, $dest_id, $weight, $type, $courrier) {
$costs_data = array();
      if($origin_id && $dest_id && $weight && $type && $courrier) {
            $costs_data = $this->get('hpwd.'.$courrier.'.'.$origin_id.'.'.$dest_id.'.'.$weight);
        }
if(!$costs_data) {
  $curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "origin=".$origin_id."&originType=city&destination=".$dest_id."&destinationType=subdistrict&weight=".$weight."&courier=".strtolower($courrier)."",  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "key: 503a8f186660898c990c11e562435849"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  return false;
} else {
    $costs_data = $response;
    $this->set('hpwd.'.$courrier.'.'.$origin_id.'.'.$dest_id.'.'.$weight, $costs_data);     
    } // end of else
} 
  $costs = array(); 

  $json = json_decode($costs_data);
    
$ar_type=array($type);   
if($courrier == "JNE") {
    if($type == "REG")  { 
    array_push($ar_type,"CTC");    
    } else {
     array_push($ar_type,"CTC".$type); 
    } 
} else if($courrier == "POS") {
    if($type == "KILAT")  { 
    array_push($ar_type,"Surat Kilat Khusus");  
    array_push($ar_type,"Paket Kilat Khusus");    
    }  else if($type == "EXPRESS") {
    array_push($ar_type,"Express Next Day");    
    } else if($type == "BIASA") {
    array_push($ar_type,"Paketpos Biasa");    
        }
}
 
if(!empty($json)) {
   foreach($json->rajaongkir->results[0]->costs as $cost => $val) {     
    if(in_array($val->service,$ar_type)) {
                    $costs = array(
                    'cost' => $val->cost[0]->value,
                    'etd' => $val->cost[0]->etd
                    );
                }
            }
        }
    
    if(!empty($costs)) {
        return $costs;
        } else {
        return array();
        }
    }  
			
	public function delete($key) {
		return $this->adaptor->delete($key);
	}
}
