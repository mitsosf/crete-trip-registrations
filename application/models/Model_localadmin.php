<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_localadmin extends CI_Model
{
    function validate() //check if user is in the system
    {

        $this->db->where('email', $this->input->post('email'));
        $this->db->where('password', md5(md5(md5($this->input->post('password')))));
        $query = $this->db->get('sections');


        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getSection($email)
    {

        $this->db->where('email', $email);      //where email = $email
        $query = $this->db->get('sections');   //get from table sections

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->name;  //return the field "name" from the row
        } else {

            return "nothing"; //prevents error at login, do not modify or do and suffer the consequences :)
        }

    }

    function getEmail($section)
    {

        $this->db->where('name', $section);      //where section = $section
        $query = $this->db->get('sections');   //get from table sections

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->email;  //return the field "email" from the row
        } else {

            return "nothing"; //prevents error at login, do not modify or do and suffer the consequences :)
        }

    }

    function changePassword(){
        $data=array(
            'password' => md5(md5(md5($this->input->post('password'))))
        );

        $this->db->where('email', $this->session->email);      //where email = mail stored in session
        if($this->db->update('sections',$data)){  //update password in table sections
            header('Location: '.base_url('manage'));
        } else {

            echo "Database error";
        }
    }
}