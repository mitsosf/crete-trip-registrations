<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_participant extends CI_Model
{
    function create_participant()
    {

        $new_participant_insert_data = array(
            'name' => $this->input->post('name'),
            'surname' => $this->input->post('surname'),
            'email' => $this->input->post('email'),
            'password' => md5(md5(md5($this->input->post('password')))),
            'idorpassport' => $this->input->post('idorpassport'),
            'dateofbirth' => $this->input->post('dateofbirth'),
            'gender' => $this->input->post('gender'),
            'phone' => $this->input->post('phone'),
            'country' => $this->input->post('country'),
            'esnsection' => $this->input->post('esnsection'),
            'trips' => $this->input->post('trips'),
            'tshirtsize' => $this->input->post('tshirtsize'),
            'city' => $this->input->post('city'),
            'facebook' => $this->input->post('facebook'),
            'allergies' => $this->input->post('allergies'),
            'comments' => $this->input->post('comments'),
        );


        $insert = $this->db->insert('participants', $new_participant_insert_data);

        return $insert;
    }

    function create_waitinglist_participant()
    {

        $new_participant_insert_data = array(
            'name' => $this->input->post('name'),
            'surname' => $this->input->post('surname'),
            'email' => $this->input->post('email'),
            'password' => md5(md5(md5($this->input->post('password')))),
            'idorpassport' => $this->input->post('idorpassport'),
            'dateofbirth' => $this->input->post('dateofbirth'),
            'gender' => $this->input->post('gender'),
            'phone' => $this->input->post('phone'),
            'country' => $this->input->post('country'),
            'esnsection' => $this->input->post('esnsection'),
            'trips' => $this->input->post('trips'),
            'tshirtsize' => $this->input->post('tshirtsize'),
            'city' => $this->input->post('city'),
            'facebook' => $this->input->post('facebook'),
            'allergies' => $this->input->post('allergies'),
            'comments' => $this->input->post('comments'),
        );


        $insert = $this->db->insert('waitinglist', $new_participant_insert_data);

        return $insert;
    }

    function get_participant_name($id = "")
    {
        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table sections

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->name . " " . $row->surname;  //return the fields "name" and "surname" from the row
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function get_participant_id_by_mail($email = "")
    {
        $this->db->where('email', $email);      //where email=$email
        $query = $this->db->get('participants');   //get from table sections

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->id;  //return the fieldid from the row
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function get_participant_section($id = "")
    {
        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->esnsection;  //return the field "esnsection" from the row
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function get_participant_glComments($id = "")
    {
        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->glcomments;  //return the field "glcomments" from the row
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function get_participant_details($id = "")
    {
        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {
            $data = array(
                "id" => $row->id,
                "name" => $row->name,
                "surname" => $row->surname,
                "email" => $row->email,
                "idorpassport" => $row->idorpassport,
                "dateofbirth" => $row->dateofbirth,
                "gender" => $row->gender,
                "phone" => $row->phone,
                "country" => $row->country,
                "esnsection" => $row->esnsection,
                "trips" => $row->trips,
                "city" => $row->city,
                "tshirtsize" => $row->tshirtsize,
                "facebook" => $row->facebook,
                "allergies" => $row->allergies,
                "comments" => $row->comments,
                "registrationdate" => $row->registrationdate,
            );
            return $data;  //return the array "data"
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function get_number_of_registrations($section="")
    {
        if($section!=""){
            $this->db->where('esnsection',$section);
        }
        $query = $this->db->get('participants');   //get all the rows from table participants
        return $query->num_rows();  //return number of participants
    }

    function get_number_of_participants($section="")
    {
        if($section!=""){
            $this->db->where('esnsection',$section);
        }
        $this->db->where('feepayment !=', "No");      //where feepayment is NOT "No"
        $query = $this->db->get('participants');   //get all the rows from table participants
        return $query->num_rows();  //return number of participants
    }

    function changePassword()
    {
        $data = array(
            'password' => md5(md5(md5($this->input->post('password'))))
        );

        $this->db->where('email', $this->session->email);      //where email = mail stored in session
        if ($this->db->update('participants', $data)) {  //update password in table sections
            header('Location: ' . base_url('account'));
        } else {

            echo "Database error";
        }
    }

    function validate() //check if user is in the system
    {

        $this->db->where('email', $this->input->post('email'));
        $this->db->where('password', md5(md5(md5($this->input->post('password')))));
        $this->db->where('feepayment!=' , "No");
        $query = $this->db->get('participants');


        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function has_payed_fee($id = "")
    {

        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            if ($row->feepayment != "No") {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function has_not_payed_fee($id = "")
    {

        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            if ($row->feepayment == "No") {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function has_payed_boat($id = "")
    {

        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            if ($row->ticketspayment != "No") {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function has_completed_rooming($id = "")
    {

        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            if ($row->rooming != "") {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function getDepositReference($email = "")       //return each section bank deposit reference
    {
        $this->db->where('email', $email);
        $query = $this->db->get('participants');   //get from table participants

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return strtoupper(str_replace(' ', '', "TCT17".$row->surname));
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function enterProofOfPaymentIntoDatabase($new_proof_of_payment = array())
    {

        $insert = $this->db->insert('payments', $new_proof_of_payment);

        return $insert;
    }

    function getNumberOfHotelParticipants()
    {
        $this->db->where('feepayment !=', "70");
        $this->db->where('feepayment !=', "No");      //where feepayment is NOT "No"
        $query = $this->db->get('participants');   //get all the rows from table participants
        return $query->num_rows();  //return number of participants
    }

    function getParticipantBoatPreference($id = "")
    {
        $this->db->where('id', $id);      //where id =$id
        $query = $this->db->get('participants');   //get from table sections

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->trips;
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function getNumberOfTickets($id = "")
    {
        $this->db->where('ticketspayment !=', "No");
        $this->db->where('trips', $id);       // where id = "type of trip"
        $query = $this->db->get('participants');   //get all the rows from table participants
        return $query->num_rows();  //return number of participants
    }

    function hasRoom($id = ""){    //returns the room number for participant if roomed, else returns FALSE
        $this->db->where('id', $id);
        $query = $this->db->get('participants');

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->rooming;
        } else {

            return 0; //return FALSE
        }
    }

    function assignRoom($pid = "", $room = ""){
        $data = array(
            'rooming' => $room
        );

        $this->db->where('id', $pid);      //where email = mail stored in session
        if ($this->db->update('participants', $data)) {  //update password in table sections
           return 1;
        } else {

            echo "Database error";
            return 0;
        }
    }

}