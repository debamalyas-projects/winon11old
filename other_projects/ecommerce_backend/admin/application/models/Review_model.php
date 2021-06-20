<?php
class Review_model extends CI_Model
{
    /**
     * This function is used to get the review listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function reviewListingCount($searchText = '')
    {
        $this->db->select('`review`.`status` AS `status`,`review`.`id` AS `id`,`review`.`name` AS `name`,`review`.`email` AS `email`,`review`.`contact` AS `contact`,`review`.`message` AS `message`,`product.name` AS `product_name`');
        $this->db->from('review');
		$this->db->join('product', 'product.id = review.product_id'); 
        if(!empty($searchText)) {
            $likeCriteria="name  LIKE '%".$searchText."%'
                OR  email  LIKE '%".$searchText."%'
                OR  contact  LIKE '%".$searchText."%'
				OR  product.name  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the review listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function reviewListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('`review`.`status` AS `status`,`review`.`id` AS `id`,`review`.`name` AS `name`,`review`.`email` AS `email`,`review`.`contact` AS `contact`,`review`.`message` AS `message`,`product.name` AS `product_name`');
        $this->db->from('review');
		$this->db->join('product', 'product.id = review.product_id'); 
        if(!empty($searchText)) {
            $likeCriteria="name  LIKE '%".$searchText."%'
                OR  email  LIKE '%".$searchText."%'
                OR  contact  LIKE '%".$searchText."%'
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
     * This function is used to add new review to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewReview($reviewInfo)
    {
        $this->db->trans_start();
        $this->db->insert('review', $reviewInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the review information
     * @param number $id : This is review id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusReview($id, $reviewInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('review', $reviewInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get review information by id
     * @param number $id : This is review id
     * @return array $result : This is review information
     */
    function getReviewInfo($id)
    {
        $this->db->select('`review`.`status` AS `status`,`review`.`product_id` AS `product_id`,`review`.`created_by` AS `created_by`,`review`.`updated_by` AS `updated_by`,`review`.`created_on` AS `created_on`,`review`.`updated_on` AS `updated_on`,`review`.`id` AS `id`,`review`.`name` AS `name`,`review`.`email` AS `email`,`review`.`contact` AS `contact`,`review`.`message` AS `message`,`product.name` AS `product_name`');
        $this->db->from('review');
        $this->db->join('product', 'product.id = review.product_id'); 
		$this->db->where('review.id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the review information
     * @param array $reviewInfo : This is review updated information
     * @param number $id : This is review id
     */
    function editReview($reviewInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('review', $reviewInfo);

        return true;
    }

    /**
     * This function is used to check whether  review is already existing or not
     * @param {string} $name : This is Review Name
     * @param {number} $id : This is review id
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