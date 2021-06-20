<?php
class Product_model extends CI_Model
{
    /**
     * This function is used to get the product listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function productListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('product');
        if(!empty($searchText)) {
            $likeCriteria="name  LIKE '%".$searchText."%'
                OR  price  LIKE '%".$searchText."%'
                OR  discount  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the product listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function productListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('product');
        if(!empty($searchText)){
            $likeCriteria="name  LIKE '%".$searchText."%'
                OR  price  LIKE '%".$searchText."%'
                OR  discount  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        if ($page != '' && $segment != '') {
            $this->db->limit($page, $segment);
        } else {
            $this->db->limit($page, 0);
        }
        $query = $this->db->get();

        $result = $query->result();
        return $result;
    }

    /**
     * This function is used to add new product to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewProduct($productInfo)
    {
        $this->db->trans_start();
        $this->db->insert('product', $productInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the product information
     * @param number $id : This is product id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusProduct($id, $productInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('product', $productInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get product information by id
     * @param number $id : This is product id
     * @return array $result : This is product information
     */
    function getProductInfo($id)
    {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the product information
     * @param array $productInfo : This is product updated information
     * @param number $id : This is product id
     */
    function editProduct($productInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('product', $productInfo);

        return true;
    }

    /**
     * This function is used to check whether  product is already existing or not
     * @param {string} $name : This is Product Name
     * @param {number} $id : This is product id
     * @return {mixed} $result : This is searched result
     */
    function checkProductExists($name, $id = 0)
    {
        $this->db->select('name');
        $this->db->from('product');
        $this->db->where('name', $name);
        if ($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
	
	function getAllProduct()
	{
		$this->db->select('*');
        $this->db->from('product');
        $query = $this->db->get();
        
        return $query->result();
	}
}
?>