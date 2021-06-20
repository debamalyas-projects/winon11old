<?php
class Rating_model extends CI_Model
{
    /**
     * This function is used to get the rating listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function ratingListingCount($searchText = '')
    {
        $this->db->select('`rating`.`status` AS `status`,`rating`.`id` AS `id`,`rating`.`name` AS `name`,`rating`.`email` AS `email`,`rating`.`contact` AS `contact`,`rating`.`rating_value` AS `rating_value`,`product.name` AS `product_name`');
        $this->db->from('rating');
		$this->db->join('product', 'product.id = rating.product_id'); 
        if(!empty($searchText)) {
            $likeCriteria="rating.name  LIKE '%".$searchText."%'
                OR  rating.email  LIKE '%".$searchText."%'
				OR  rating.rating_value  LIKE '%".$searchText."%'
                OR  rating.contact  LIKE '%".$searchText."%'
				OR  product.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the rating listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function ratingListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('`rating`.`status` AS `status`,`rating`.`id` AS `id`,`rating`.`name` AS `name`,`rating`.`email` AS `email`,`rating`.`contact` AS `contact`,`rating`.`rating_value` AS `rating_value`,`product.name` AS `product_name`');
        $this->db->from('rating');
		$this->db->join('product', 'product.id = rating.product_id'); 
        if(!empty($searchText)) {
            $likeCriteria="rating.name  LIKE '%".$searchText."%'
                OR  rating.email  LIKE '%".$searchText."%'
				OR  rating.rating_value  LIKE '%".$searchText."%'
                OR  rating.contact  LIKE '%".$searchText."%'
				OR  product.name  LIKE '%".$searchText."%'";
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
     * This function is used to add new rating to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewRating($ratingInfo)
    {
        $this->db->trans_start();
        $this->db->insert('rating', $ratingInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the rating information
     * @param number $id : This is rating id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusRating($id, $ratingInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('rating', $ratingInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get rating information by id
     * @param number $id : This is rating id
     * @return array $result : This is rating information
     */
    function getRatingInfo($id)
    {
        $this->db->select('`rating`.`status` AS `status`,`rating`.`product_id` AS `product_id`,`rating`.`created_by` AS `created_by`,`rating`.`updated_by` AS `updated_by`,`rating`.`created_on` AS `created_on`,`rating`.`updated_on` AS `updated_on`,`rating`.`id` AS `id`,`rating`.`name` AS `name`,`rating`.`email` AS `email`,`rating`.`contact` AS `contact`,`rating`.`rating_value` AS `rating_value`,`product.name` AS `product_name`');
        $this->db->from('rating');
        $this->db->join('product', 'product.id = rating.product_id'); 
		$this->db->where('rating.id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the rating information
     * @param array $ratingInfo : This is rating updated information
     * @param number $id : This is rating id
     */
    function editRating($ratingInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('rating', $ratingInfo);

        return true;
    }

    /**
     * This function is used to check whether  rating is already existing or not
     * @param {string} $name : This is Rating Name
     * @param {number} $id : This is rating id
     * @return {mixed} $result : This is searched result
     */
    function checkAttributeExists($name, $id = 0)
    {
        $this->db->select('name');
        $this->db->from('attribute');
        $this->db->where('name', $name);
        if ($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>