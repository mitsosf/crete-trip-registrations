<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_getsections extends CI_Model
{
    function getData()
    {
        $this->db->from('sections');
        $result = $this->db->get();
        $sectionList = array();


        if ($result->num_rows() > 0) {
            $sectionList[0]=' ';
            foreach ($result->result_array() as $row) {
                $sectionList[$row['name']] = $row['name'];
            }
        }

        return $sectionList;
    }
}