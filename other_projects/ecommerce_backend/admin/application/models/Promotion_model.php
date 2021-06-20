<?php
class Promotion_model extends CI_Model
{
    /**
     * This function is used to get the promotion listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function promotionListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('promotion');
        if(!empty($searchText)) {
            $likeCriteria="subject  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the promotion listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function promotionListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('promotion');
        if(!empty($searchText)){
            $likeCriteria="subject  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
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
     * This function is used to add new promotion to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewPromotion($promotionInfo)
    {
        $this->db->trans_start();
        $this->db->insert('promotion', $promotionInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the promotion information
     * @param number $id : This is promotion id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusPromotion($id, $promotionInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('promotion', $promotionInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get promotion information by id
     * @param number $id : This is promotion id
     * @return array $result : This is promotion information
     */
    function getPromotionInfo($id)
    {
        $this->db->select('*');
        $this->db->from('promotion');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the promotion information
     * @param array $promotionInfo : This is promotion updated information
     * @param number $id : This is promotion id
     */
    function editPromotion($promotionInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('promotion', $promotionInfo);

        return true;
    }

    /**
     * This function is used to check whether  promotion is already existing or not
     * @param {string} $name : This is Promotion Name
     * @param {number} $id : This is promotion id
     * @return {mixed} $result : This is searched result
     */
    function checkPromotionExists($subject, $id = 0)
    {
        $this->db->select('subject');
        $this->db->from('promotion');
        $this->db->where('subject', $subject);
        if ($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>