<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_admin extends CI_Model
{
    function validate()
    {

        $this->db->where('email', $this->input->post('email'));
        $this->db->where('password', md5(md5(md5($this->input->post('password')))));
        $query = $this->db->get('admins');


        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }

        return $insert;
    }

    function getRole($email)
    {

        $this->db->where('email', $email);      //where email = $email
        $query = $this->db->get('admins');   //get from table "admins"

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->role;  //return the field "role" from the row
        } else {

            return "nothing"; //prevents error at login, do not modify or do and suffer the consequences :)
        }

    }

    function getUnverifiedProofsOfPayment()
    {

        $this->db->where('approved', 'No');
        $this->db->where('individual', 'No');
        $result = $this->db->get('payments');   //get from table participants


        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

    function getIndividualUnverifiedProofsOfPayment()
    {

        $this->db->where('approved', 'No');
        $this->db->where('individual!=', 'No');
        $result = $this->db->get('payments');   //get from table participants


        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

    function validateProofOfPayment($id='')
    {

        $data = array(
            'approved' => 'Yes'
        );

        $this->db->where('id', $id);
        $this->db->update('payments', $data);


    }



    function changePassword()
    {
        $data = array(
            'password' => md5(md5(md5($this->input->post('password'))))
        );

        $this->db->where('email', $this->session->email);      //where email = mail stored in session
        if ($this->db->update('admins', $data)) {  //update password in table sections
            header('Location: ' . base_url('godmode'));
        } else {

            echo "Database error";
        }
    }

    function resetParticipantPassword($id='')
    {
        //TODO change hardcoded pass after event
        $randomString = substr(md5(rand()), 0, 7);
        $data = array(
            'password' => md5(md5(md5("89z7xw")))  //triple md5 for password
        );

        $this->db->where('id', $id);
        $this->db->update('participants', $data);

        return $randomString;

    }

}