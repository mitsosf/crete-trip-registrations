<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_section extends CI_Model
{
    function getNumOfRegistrations($section = "")
    {
        $this->db->where('esnsection', $section);
        $this->db->from('participants');
        $result = $this->db->get();
        return $result->num_rows();

    }

    function getNumOfPaidEventFee($section = "")
    {
        $this->db->where('feepayment !=', "No");      //where feepayment is NOT "No"
        $this->db->where('esnsection', $section);
        $this->db->from('participants');
        $result = $this->db->get();
        return $result->num_rows();

    }

    function getNumOfPaidBoatFee($section = "")
    {
        $this->db->where('ticketspayment !=', "No");      //where ticketspayment is NOT "No"
        $this->db->where('esnsection', $section);
        $this->db->from('participants');
        $result = $this->db->get();
        return $result->num_rows();

    }

    function retrieveSectionFromURL($numOfArgument = 0)
    {
        $wrong = $this->uri->segment($numOfArgument);
        $pieces = explode("%20", $wrong);
        $section = '';
        foreach ($pieces as $value) {
            $section = $section . $value . ' ';
        }
        $section = substr($section, 0, -1);
        return $section;

    }

    function getSumOfEventFees($section = "")
    {
        $this->db->where('esnsection',$section);
        $this->db->from('participants');
        $result = $this->db->get();
        $sum = 0;

        if ($result->num_rows() > 0) {

            foreach ($result->result_array() as $row) {
                $emails[$row['id']] = $row['email'];
                if($row['feepayment'] != 'No'){
                    $sum = $sum + $row['feepayment'];
                }
            }
        }
        return $sum;
    }

    function getSumOfBoatFees($section = "")
    {
        $this->db->where('esnsection',$section);
        $this->db->from('participants');
        $result = $this->db->get();
        $sum = 0;

        if ($result->num_rows() > 0) {

            foreach ($result->result_array() as $row) {
                $emails[$row['id']] = $row['email'];
                if($row['ticketspayment'] != 'No'){
                    $sum = $sum + $row['ticketspayment'];
                }
            }
        }
        return $sum;
    }


    function getDepositReference($section = "")       //return each section bank deposit reference
    {
        $this->db->where('name', $section);
        $query = $this->db->get('sections');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->reference;
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function enterProofOfPaymentIntoDatabase($new_proof_of_payment = array())
    {

        $insert = $this->db->insert('payments', $new_proof_of_payment);

        return $insert;
    }
}