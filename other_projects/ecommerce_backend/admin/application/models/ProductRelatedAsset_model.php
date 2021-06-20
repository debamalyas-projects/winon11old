<?php
class ProductRelatedAsset_model extends CI_Model
{	
	/**
     * This function is used to get the product product listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function productRelatedAssetListingCount($searchText = '',$product_id,$type)
    {
		if($type == 'asset'){
			
			$this->db->select('`product_related_asset`.`status` AS `status`,`product_related_asset`.`id` AS `id`,`product`.`name` AS `product_name`,`asset`.`name` AS `asset_name`');
			$this->db->from('product_related_asset');
			$this->db->join('product', 'product.id = product_related_asset.product_id'); 
			$this->db->join('asset', 'asset.id = product_related_asset.asset_id');
			$likeCriteria = "product_related_asset.product_id='".$product_id."' AND product_related_asset.type = '".$type."'";
			if(!empty($searchText)) {
				$likeCriteria .= " AND asset.name  LIKE '%".$searchText."%' AND product_related_asset.type = '".$type."'";
			}
		}else{
			$this->db->select('`product_related_asset`.`status` AS `status`,`product_related_asset`.`id` AS `id`,`product`.`name` AS `product_name`,`asset_link`.`name` AS `assetLink_name`');
			$this->db->from('product_related_asset');
			$this->db->join('product', 'product.id = product_related_asset.product_id'); 
			$this->db->join('asset_link', 'asset_link.id = product_related_asset.asset_id');
			$likeCriteria = "product_related_asset.product_id='".$product_id."' AND product_related_asset.type = '".$type."'";
			if(!empty($searchText)) {
				$likeCriteria .= " AND asset_link.name  LIKE '%".$searchText."%' AND product_related_asset.type = '".$type."'";
			}
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
    function productRelatedAssetListing($searchText = '', $page = '', $segment = '', $product_id,$type)
    {
      if($type == 'asset'){
		$this->db->select('`product_related_asset`.`status` AS `status`,`product_related_asset`.`id` AS `id`,`product`.`name` AS `product_name`,`asset`.`name` AS `asset_name`');
		$this->db->from('product_related_asset');
		$this->db->join('product', 'product.id = product_related_asset.product_id'); 
		$this->db->join('asset', 'asset.id = product_related_asset.asset_id');
		$likeCriteria = "product_related_asset.product_id='".$product_id."' AND product_related_asset.type = '".$type."'";
		if(!empty($searchText)) {
			$likeCriteria .= " AND asset.name  LIKE '%".$searchText."%' AND product_related_asset.type = '".$type."'";
		}
	}else{
		$this->db->select('`product_related_asset`.`status` AS `status`,`product_related_asset`.`id` AS `id`,`product`.`name` AS `product_name`,`asset_link`.`name` AS `assetLink_name`');
		$this->db->from('product_related_asset');
		$this->db->join('product', 'product.id = product_related_asset.product_id'); 
		$this->db->join('asset_link', 'asset_link.id = product_related_asset.asset_id');
		$likeCriteria = "product_related_asset.product_id='".$product_id."' AND product_related_asset.type = '".$type."'";
		if(!empty($searchText)) {
			$likeCriteria .= " AND asset_link.name  LIKE '%".$searchText."%' AND product_related_asset.type = '".$type."'";
		}
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
    function addNewProductRelatedAsset($productRelatedAssetInfo)
    {
        $this->db->trans_start();
        $this->db->insert('product_related_asset', $productRelatedAssetInfo);
        
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
    function changeStatusProductRelatedAsset($id, $productRelatedAssetInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('product_related_category', $productRelatedAssetInfo);
        
        return $this->db->affected_rows();
    }
	
	/**
     * This function used to get service information by id
     * @param number $id : This is service id
     * @return array $result : This is service information
     */
    function getProductRelatedAssetInfo($id)
    {
        $this->db->select('*');
        $this->db->from('product_related_asset');
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
    function editProductRelatedAsset($productRelatedAssetInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('product_related_asset', $productRelatedAssetInfo);
        
        return true;
    }
	
	/**
     * This function is used to check whether  vendor product is already existing or not
     * @param {string} $name : This is vendor product name
     * @param {number} $id : This is vendor product id
     * @return {mixed} $result : This is searched result
     */
    function checkProductRelatedAssetExists($category_id, $product_id, $id = 0)
    {
        $this->db->select("*");
        $this->db->from("`product_related_asset`");
        $this->db->where("`product_id`='".$product_id."'");
        if($id != 0){
            $this->db->where("`id` !='".$id."'");
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getViewDetails($id,$type){
		if($type == 'asset'){
			$this->db->select('`product_related_asset`.`id` AS `id`,`product_related_asset`.`product_id` AS `product_id`,`product_related_asset`.`asset_id` AS `asset_id`,`product_related_asset`.`created_by` AS `created_by`,`product_related_asset`.`updated_by` AS `updated_by`,`product_related_asset`.`created_on` AS `created_on`,`product_related_asset`.`updated_on` AS `updated_on`,`product`.`name` AS `product_name`,`asset`.`name` AS `asset_name`');
			$this->db->from('product_related_asset');
			$this->db->join('product', 'product.id = product_related_asset.product_id'); 
			$this->db->join('asset', 'asset.id = product_related_asset.asset_id');
		}else{
			$this->db->select('`product_related_asset`.`id` AS `id`,`product_related_asset`.`product_id` AS `product_id`,`product_related_asset`.`asset_id` AS `asset_id`,`product_related_asset`.`created_by` AS `created_by`,`product_related_asset`.`updated_by` AS `updated_by`,`product_related_asset`.`created_on` AS `created_on`,`product_related_asset`.`updated_on` AS `updated_on`,`product`.`name` AS `product_name`,`asset_link`.`name` AS `asset_name`');
			$this->db->from('product_related_asset');
			$this->db->join('product', 'product.id = product_related_asset.product_id'); 
			$this->db->join('asset_link', 'asset_link.id = product_related_asset.asset_id');
		}
		
		$this->db->where('product_related_asset.id', $id);
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>