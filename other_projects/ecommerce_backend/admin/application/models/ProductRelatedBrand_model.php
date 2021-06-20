<?php
class ProductRelatedBrand_model extends CI_Model
{	
	/**
     * This function is used to get the product product listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function productRelatedBrandListingCount($searchText = '',$product_id)
    {
        $this->db->select('`product_related_brand`.`status` AS `status`,`product_related_brand`.`id` AS `id`,`product`.`name` AS `product_name`,`brand`.`name` AS `brand_name`');
        $this->db->from('product_related_brand');
		$this->db->join('product', 'product.id = product_related_brand.product_id'); 
		$this->db->join('brand', 'brand.id = product_related_brand.brand_id');
		$likeCriteria = "product_related_brand.product_id='".$product_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND brand.name  LIKE '%".$searchText."%'";
        }
		$this->db->where($likeCriteria);
        //$this->db->where('Status', '1');
        $query = $this->db->get();
		//echo $this->db->last_query(); die();
        
        return count($query->result());
    }
	
	/**
     * This function is used to get the vendor product listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function productRelatedBrandListing($searchText = '', $page = '', $segment = '', $product_id)
    {
       $this->db->select('`product_related_brand`.`status` AS `status`,`product_related_brand`.`id` AS `id`,`product`.`name` AS `product_name`,`brand`.`name` AS `brand_name`');
        $this->db->from('product_related_brand');
		$this->db->join('product', 'product.id = product_related_brand.product_id'); 
		$this->db->join('brand', 'brand.id = product_related_brand.brand_id');
		$likeCriteria = "product_related_brand.product_id='".$product_id."'";
        if(!empty($searchText)) {
            $likeCriteria .= " AND brand.name  LIKE '%".$searchText."%'";
        }
		$this->db->where($likeCriteria);
		if($page!='' && $segment!=''){
			$this->db->limit($page, $segment);
		}else{
			$this->db->limit($page, 0);
		}
        $query = $this->db->get();
        
        $result = $query->result(); 
		
        return $result;
    }
	
	/**
     * This function is used to add new vendor product to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewProductRelatedBrand($productRelatedBrandInfo)
    {
        $this->db->trans_start();
        $this->db->insert('product_related_brand', $productRelatedBrandInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
	
	/**
     * This function is used to delete the service information
     * @param number $id : This is service id
     * @return boolean $result : TRUE / FALSE
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProductRelatedBrand($id, $productRelatedBrandInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('product_related_brand', $productRelatedBrandInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get service information by id
     * @param number $id : This is service id
     * @return array $result : This is service information
     */
    function getProductRelatedBrandInfo($id)
    {
        $this->db->select('*');
        $this->db->from('product_related_brand');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	function getProductInfo($id)
    {
        $this->db->select('*');
        $this->db->from('product');
		$this->db->where('id', $id);
        $query = $this->db->get();
        
        return $query->result();
    }
	
	/**
     * This function is used to update the vendor product information
     * @param array $id : This is vendor product updated information
     * @param number $id : This is vendor product id
     */
    function editProductRelatedBrand($productRelatedBrandInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('product_related_brand', $productRelatedBrandInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  vendor product is already existing or not
     * @param {string} $name : This is vendor product name
     * @param {number} $id : This is vendor product id
     * @return {mixed} $result : This is searched result
     */
    function checkProductRelatedBrandExists($brand_id, $product_id, $id = 0)
    {
        $this->db->select("*");
        $this->db->from("`product_related_brand`");
        $this->db->where("`product_id`='".$product_id."'");
        if($id != 0){
            $this->db->where("`id` !='".$id."'");
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getViewDetails($id){
		$this->db->select('`product_related_brand`.`id` AS `id`,`product_related_brand`.`product_id` AS `product_id`,`product_related_brand`.`brand_id` AS `brand_id`,`product_related_brand`.`created_by` AS `created_by`,`product_related_brand`.`updated_by` AS `updated_by`,`product_related_brand`.`created_on` AS `created_on`,`product_related_brand`.`updated_on` AS `updated_on`,`product`.`name` AS `product_name`,`brand`.`name` AS `brand_name`');
        $this->db->from('product_related_brand');
		$this->db->join('product', 'product.id = product_related_brand.product_id'); 
		$this->db->join('brand', 'brand.id = product_related_brand.brand_id');
		$this->db->where('product_related_brand.id', $id);
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>