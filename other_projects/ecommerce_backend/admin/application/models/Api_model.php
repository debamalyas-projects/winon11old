<?php
class Api_model extends CI_Model
{	
	public function select_query($query){
		$query = $this->db->query($query);
		
		$result = $query->result_array();
		
		return $result;
	}
	
	public function dml_query($query){
		$this->db->query($query);
	}
	
	public function get_rating($product_id){
		$query = $this->db->query('SELECT * FROM `rating` WHERE `product_id`="'.$product_id.'" AND `status`="1"');
		
		$result = $query->result_array();
		
		$rating_arr = array();
		$rating_arr['5'] = 0;
		$rating_arr['4'] = 0;
		$rating_arr['3'] = 0;
		$rating_arr['2'] = 0;
		$rating_arr['1'] = 0;
		$count=0;
		for($i=0;$i<count($result);$i++){
			$rating_arr[$result[$i]['rating_value']]=$rating_arr[$result[$i]['rating_value']]+1;
			$count++;
		}
		
		for($i=1;$i<=5;$i++){
			$rating_arr[$i] = floor(($rating_arr[$i]/$count)*100);
		}
		
		return $rating_arr;
	}
	
	public function get_average_rating($product_id){
		$query = $this->db->query('SELECT * FROM `rating` WHERE `product_id`="'.$product_id.'" AND `status`="1"');
		
		$result = $query->result_array();
		
		$rating_arr = array();
		$rating_arr['5'] = 0;
		$rating_arr['4'] = 0;
		$rating_arr['3'] = 0;
		$rating_arr['2'] = 0;
		$rating_arr['1'] = 0;
		$count=0;
		for($i=0;$i<count($result);$i++){
			$rating_arr[$result[$i]['rating_value']]=$rating_arr[$result[$i]['rating_value']]+1;
			$count++;
		}
		
		$average_rating = (5*$rating_arr['5']+4*$rating_arr['4']+3*$rating_arr['3']+2*$rating_arr['2']+1*$rating_arr['1'])/$count;
		
		return floor($average_rating).'|||'.$count;
	}
	
	public function get_lowest_unit_price($product_id){
		$query = $this->db->query('SELECT * FROM `product_vendor` WHERE `product_id`="'.$product_id.'" AND `status`="1" AND `stock`>"0"');
		
		$result = $query->result_array();

		$vendor_id='';
		$unit_price='';
		for($i=0;$i<count($result);$i++){
			if($i==0){
				$unit_price = $result[$i]['unit_price'];
				$vendor_id = $result[$i]['vendor_id'];
			}else{
				if($result[$i]['unit_price']<$unit_price){
					$unit_price = $result[$i]['unit_price'];
					$vendor_id = $result[$i]['vendor_id'];
				}
			}
		}
		
		return $vendor_id.'|||'.$unit_price;
	}
	
	public function get_product_attributes($product_id){
		$query = $this->db->query('SELECT DISTINCT `attribute_id` FROM `product_vendor_attributes` WHERE `product_id`="'.$product_id.'"');
		
		$result = $query->result_array();
		
		$product_attributes = array();
		for($i=0;$i<count($result);$i++){
			$query_attribute = $this->db->query('SELECT * FROM `attribute` WHERE `id`="'.$result[$i]['attribute_id'].'"');
		
			$result_attribute = $query_attribute->result_array();
			
			$attribute_name = $result_attribute[0]['name'];
			
			$product_attributes['attribute_id'] = $result[$i]['attribute_id'];
			
			$query_attribute_value = $this->db->query('SELECT * FROM `attribute_value` WHERE `attribute_id`="'.$result[$i]['attribute_id'].'" AND `status`="1"');
		
			$result_attribute_value = $query_attribute_value->result_array();
			
			for($j=0;$j<count($result_attribute_value);$j++){
				$product_attributes['options'][$attribute_name][] = $result_attribute_value[$j]['value'];
			}
			
			
		}
		return $product_attributes;
	}
	
	public function get_product_packs($product_id){
		$query = $this->db->query('SELECT DISTINCT `quantity` FROM `product_vendor` WHERE `product_id`="'.$product_id.'" AND `status`="1"');
		
		$result = $query->result_array();

		return $result;
	}
}
?>