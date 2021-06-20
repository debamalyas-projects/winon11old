<?php
class Faq_model extends CI_Model
{
    /**
     * This function is used to get the faq listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function faqListingCount($searchText = '')
    {
        $this->db->select('*');
        $this->db->from('faq');
        if(!empty($searchText)) {
            $likeCriteria="question  LIKE '%".$searchText."%'
                OR  answer  LIKE '%".$searchText."%'";
            $this->db->where($likeCriteria);
        }
        //$this->db->where('Status', '1');
        $query = $this->db->get();

        return count($query->result());
    }

    /**
     * This function is used to get the faq listing
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function faqListing($searchText = '', $page = '', $segment = '')
    {
        $this->db->select('*');
        $this->db->from('faq');
        if(!empty($searchText)){
            $likeCriteria="question  LIKE '%".$searchText."%'
                OR  answer  LIKE '%".$searchText."%'";
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
     * This function is used to add new faq to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewFaq($faqInfo)
    {
        $this->db->trans_start();
        $this->db->insert('faq', $faqInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }

    /**
     * This function is used to delete the faq information
     * @param number $id : This is faq id
     * @return boolean $result : TRUE / FALSE
     */
    function changeStatusFaq($id, $faqInfo)
    {
        $this->db->where('id', $id);
        $this->db->update('faq', $faqInfo);

        return $this->db->affected_rows();
    }

    /**
     * This function used to get faq information by id
     * @param number $id : This is faq id
     * @return array $result : This is faq information
     */
    function getFaqInfo($id)
    {
        $this->db->select('*');
        $this->db->from('faq ');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to update the faq information
     * @param array $faqInfo : This is faq updated information
     * @param number $id : This is faq id
     */
    function editFaq($faqInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('faq', $faqInfo);

        return true;
    }

    /**
     * This function is used to check whether  faq is already existing or not
     * @param {string} $question : This is Faq Question
     * @param {number} $id : This is faq id
     * @return {mixed} $result : This is searched result
     */
    function checkFaqExists($question, $id = 0)
    {
        $this->db->select('question');
        $this->db->from('faq');
        $this->db->where('question', $question);
        if ($id != 0) {
            $this->db->where('id !=', $id);
        }
        $query = $this->db->get();

        return $query->result();
    }
}
?>