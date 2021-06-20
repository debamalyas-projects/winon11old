<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Api extends BaseController
{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('api_model');
	}
	
	public function select_query(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$query = $post_data['query'];
		
		$result = $this->api_model->select_query($query);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function dml_query(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$query = $post_data['query'];
		
		$this->api_model->dml_query($query);
		
		$response_arr = array();
		$response_arr['data'] = array();
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function get_rating(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$product_id = $post_data['product_id'];
		
		$result = $this->api_model->get_rating($product_id);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function get_average_rating(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$product_id = $post_data['product_id'];
		
		$result = $this->api_model->get_average_rating($product_id);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	
	public function get_product_more_details(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$post_data = json_decode(file_get_contents('php://input'),true);
		
		$product_id = $post_data['product_id'];
		//$product_id = '3';
		
		$lowest_unit_price_str = $this->api_model->get_lowest_unit_price($product_id);
		$lowest_unit_price_arr = explode('|||',$lowest_unit_price_str);
		
		$result['vendor_id'] = $lowest_unit_price_arr[0];
		$result['unit_price'] = $lowest_unit_price_arr[1];
		
		$result_arr = $this->api_model->select_query("SELECT * FROM `product` WHERE `id`='".$product_id."'");
		
		$club_discount = $result_arr[0]['club_discount'];
		$result['club_discount_price'] = $result['unit_price']-(($club_discount/100)*$result['unit_price']);
		
		$result['product_attributes'] = $this->api_model->get_product_attributes($product_id);
		
		$result['product_pack_options'] = $this->api_model->get_product_packs($product_id);
		
		$response_arr = array();
		$response_arr['data'] = $result;
		
		$response_json = json_encode($response_arr);
		echo $response_json;
	}
	//AJAX REQUESTS
	public function check_pincode_exist(){
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
		$product_id = $_POST['product_id'];
		$pincode = $_POST['pincode'];
		
		$result_arr = $this->api_model->select_query("SELECT * FROM `product_pincode` WHERE `product_id`='".$product_id."' AND `pincode`='".$pincode."' AND `status`='1'");
		
		echo count($result_arr);
	}
	
}
?>