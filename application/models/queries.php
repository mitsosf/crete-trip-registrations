<?php
class Queries extends CI_Model{

    public function getSections(){
        $query = $this->db->get('sections');
        if($query->num_rows() > 0){
            return $query->result();
        }

    }
}