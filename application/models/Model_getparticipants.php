<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_getparticipants extends CI_Model
{
    function getEmails()
    {
        $this->db->from('sections');
        $result = $this->db->get();
        $emails = array();


        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $emails[$row['id']] = $row['email'];
            }
        }

        return $emails;
    }
}