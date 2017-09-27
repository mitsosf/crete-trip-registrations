<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_getcountries extends CI_Model
{
    function getData()
    {
        $this->db->from('countries');
        $result = $this->db->get();
        $countryList = array();


        if ($result->num_rows() > 0) {
            $countryList[0]=' ';
            foreach ($result->result_array() as $row) {
                $countryList[$row['name']] = $row['name'];
            }
        }

        return $countryList;
    }
}