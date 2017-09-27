<?php
if (!defined('BASEPATH')) exit('No direct script access allowed111');

class Model_event extends CI_Model
{

    function get_event_fee()
    {
        $this->db->where('attribute', 'fee');      //where "attribute" = "fee"
        $query = $this->db->get('event');   //get from table event

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->value;  //return the field "value" from the row
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function get_boat_fee()
    {
        $this->db->where('attribute', 'boatfee');      //where "attribute" = "fee"
        $query = $this->db->get('event');   //get from table event

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->value;  //return the field "value" from the row
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function getNumOfPaidHotelSpaces()
    {
        $this->db->where('feepayment', $this->get_event_fee());      //where feepayment is eventfee
        $this->db->from('participants');
        $result = $this->db->get();
        return $result->num_rows();
    }

    function getNumOfAvailableHotelSpaces()
    {
        $this->db->where('attribute', 'numberofhotelparticipants');      //where "attribute" = "numberofhotelparticipants"
        $query = $this->db->get('event');   //get from table event

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->value;  //return the field "value" from the row
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }
    }

    function getAllRoomCodes()
    {
        $codes = "";  //start codes

        $query = $this->db->get('rooming');
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {
                $codes = $codes . $row['code'] . ",";
            }
        }

        return substr($codes, 0, -1);
    }

    function generateRoomCode()  //generating a random 6-digit number
    {
        $code = '';

        for ($i = 0; $i < 6; $i++) {
            $code .= rand(0, 9);
        }
        return $code;
    }


    function createRoom($beds, $comments, $code, $pid, $hotel)
    {
        //check if participant has a room
        $this->db->where('id', $pid);      //where "attribute" = "numberofhotelparticipants"
        $query = $this->db->get('participants');   //get from table event

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            if ($row->rooming == "") {  //if participant doesn't have a room
                $room = array(
                    'code' => $code,
                    'hotel' => $hotel,
                    'beds' => $beds,
                    'comments' => $comments,
                    'participant1' => $pid
                );

                $insert = $this->db->insert('rooming', $room);
                return $insert;

            } else {
                return 0;
            }
        } else {

            return "ERROR"; //print error if someone is messing with something :)
        }


    }

    function joinRoom($roomid, $code, $pid)   //returns 1 when successful, 2 when room is full, 3 when code is wrong, 4 when wrong hotel, 0 if room doesn't exist or dropped or error
    {
        $this->db->where('id', $roomid);
        $query = $this->db->get('rooming');
        $row = $query->row(1);
        if ($query->num_rows() == 1) { //check if room with given id exists
            if ($row->code == $code) {   //check if id and code match
                if ($row->final != "1") {   //check if room is full

                    $beds = $row->beds;
                    $participant1 = $row->participant1;
                    $participant2 = $row->participant2;
                    $participant3 = $row->participant3;
                    $participant4 = $row->participant4;
                    $hotel = $row->hotel;
                    if ($beds == 2) {   //TODO change after event
                        if ($row->participant2 == "") {
                            //TODO register participant and close room -- DONE
                            //copy from here
                            $this->db->where('id', $pid);
                            $query = $this->db->get('participants');
                            $row = $query->row(1);
                            $section = $row->esnsection;
                            if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                                || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                                $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
                            ) {
                                $correctHotel = "Marilena";
                            } else {
                                $correctHotel = "Vanisko";
                            }

                            if ($hotel != $correctHotel) {
                                return 4;
                            }
                            //to here
                            $this->db->where('id', $roomid);

                            $data = array(
                                'participant2' => $pid,
                                'final' => "1"
                            );

                            if ($this->db->update('rooming', $data)) {
                                $this->db->where('id', $pid);

                                $data = array(
                                    'rooming' => $roomid
                                );

                                if ($this->db->update('participants', $data)) {
                                    //update 1st participant in participants table
                                    $this->db->where('id', $participant1);
                                    $data = array(
                                        'rooming' => $roomid
                                    );
                                    $this->db->update('participants', $data);


                                    //drop rooms and send email to participants //TODO FIX after event

                                    //Get finalised rooms with x number of beds from y hotel
                                    $this->db->where('hotel', $hotel);
                                    $this->db->where('final', "1");
                                    $this->db->where('beds', $beds);

                                    $query = $this->db->get('rooming');
                                    $finalisedRooms = $query->num_rows(); //number of fin rooms with x beds from y hotel

                                    //Get amount of given rooms with x number of beds from y hotel
                                    $this->db->where('name', $hotel);
                                    $query = $this->db->get('hotels');
                                    $row = $query->row(1);

                                    if ($beds == "2") {
                                        $givenRooms = $row->twobeds;
                                    } elseif ($beds == "3") {
                                        $givenRooms = $row->threebeds;
                                    } elseif ($beds == "4") {
                                        $givenRooms = $row->fourbeds;
                                    }

                                    //deduce the available rooms
                                    $availableRooms = $givenRooms - $finalisedRooms;

                                    if ($availableRooms == 0)   //if there are no more available rooms with x beds on y hotel
                                    {
                                        $this->db->where('final!=', "1");
                                        $this->db->where('hotel', $hotel);
                                        $this->db->where('beds', $beds);

                                        $result = $this->db->get('rooming');
                                        foreach ($result->result_array() as $row) {

                                            //send mail to participants
                                            $participantIDs = array(
                                                $row->participant1,
                                                $row->participant2,
                                                $row->participant3,
                                                $row->participant4

                                            );
                                            foreach ($participantIDs as $pid) {
                                                //get participant email and name by id
                                                if ($pid != "") {
                                                    $this->db->where('id', $pid);
                                                    $query = $this->db->get('participants');
                                                    $row = $query->row(1);
                                                    $pemail = $row->email;
                                                    $pname = $row->name;

                                                    $this->email->set_mailtype("html");
                                                    $this->email->from('oc@thecretetrip.org', 'The Crete Trip 2017 Organising Committee');
                                                    $this->email->to($pemail);  //send mail to participant
                                                    $this->email->bcc('it@esngreece.gr'); //bcc moi
                                                    $this->email->subject('Your room has been deleted, please repeat the rooming process');
                                                    $this->email->message('
                                                        <p>Dear ' . $pname . ',</p>
                                                        <p>We have to regretfully inform you that you didn\'t complete your room in time and now all ' . $beds . '-bed rooms have been fully occupied. As we announced before, the room assignment is a first come first served process and the rest of your group wasn\'t fast enough.</p>
                                                        <p>What you can do now is perform the rooming process again, by accessing the link below:</p>
                                                        <p><strong><a href="https://registrations.thecretetrip.org/rooming">https://registrations.thecretetrip.org/rooming</a></strong></p>
                                                        <p>(If the link doesn\'t work, copy-paste it in your browser.)</p>
                                                        <p>The same goes for your roommates, if you had any in the temporary room that has been deleted, they have to join you again. Please notify them as well, in case they didn\'t see or get this email.</p>
                                                        <p style="color : red">If you can\'t perfectly fit in a room anymore, select the "Random Room" option, leaving your desired roommates\' name(s) in the comment box. We\'ll do our best to try to match you, but we can\'t promise anything.</p>
                                                        <p>If you have further questions, please contact <a href="mailto:it@esngreece.gr">it@esngreece.gr</a>.</p>
                                                        <p>See you in a few days,</p>
                                                        <p>The Organising Committee of The Crete Trip 2017</p>
                                                    ');

                                                    $this->email->send();
                                                } else {
                                                    continue;
                                                }
                                            }
                                        }

                                        //TODO drop rooms
                                        $this->db->where('final!=', "1");
                                        $this->db->where('hotel', $hotel);
                                        $this->db->where('beds', $beds);

                                        $this->db->delete('rooming');


                                    }


                                    return 1;
                                } else {
                                    echo "Database error";
                                    return 0;
                                }
                            } else {

                                echo "Database error";
                                return 0;
                            }
                        }
                    } elseif ($beds == 3) {
                        if ($row->participant2 == "") {
                            //TODO register participant
                            //copy from here
                            $this->db->where('id', $pid);
                            $query = $this->db->get('participants');
                            $row = $query->row(1);
                            $section = $row->esnsection;
                            if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                                || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                                $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
                            ) {
                                $correctHotel = "Marilena";
                            } else {
                                $correctHotel = "Vanisko";
                            }

                            if ($hotel != $correctHotel) {
                                return 4;
                            }
                            //to here
                            $this->db->where('id', $roomid);

                            $data = array(
                                'participant2' => $pid,
                            );

                            if ($this->db->update('rooming', $data)) {
                                return 1;
                            } else {

                                echo "Database error";
                                return 0;
                            }
                        } elseif ($row->participant3 == "") {
                            //TODO register participant and close room -- DONE
                            //copy from here
                            $this->db->where('id', $pid);
                            $query = $this->db->get('participants');
                            $row = $query->row(1);
                            $section = $row->esnsection;
                            if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                                || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                                $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
                            ) {
                                $correctHotel = "Marilena";
                            } else {
                                $correctHotel = "Vanisko";
                            }

                            if ($hotel != $correctHotel) {
                                return 4;
                            }
                            //to here
                            $this->db->where('id', $roomid);

                            $data = array(
                                'participant3' => $pid,
                                'final' => "1"
                            );

                            if ($this->db->update('rooming', $data)) {
                                $this->db->where('id', $pid);

                                $data = array(
                                    'rooming' => $roomid
                                );

                                if ($this->db->update('participants', $data)) {
                                    //update 1st participant in participants table
                                    $this->db->where('id', $participant1);
                                    $data = array(
                                        'rooming' => $roomid
                                    );
                                    $this->db->update('participants', $data);

                                    //update 2nd participant in participants table
                                    $this->db->where('id', $participant2);
                                    $data = array(
                                        'rooming' => $roomid
                                    );
                                    $this->db->update('participants', $data);

                                    //drop rooms and send email to participants //TODO FIX after event

                                    //Get finalised rooms with x number of beds from y hotel
                                    $this->db->where('hotel', $hotel);
                                    $this->db->where('final', "1");
                                    $this->db->where('beds', $beds);

                                    $query = $this->db->get('rooming');
                                    $finalisedRooms = $query->num_rows(); //number of fin rooms with x beds from y hotel

                                    //Get amount of given rooms with x number of beds from y hotel
                                    $this->db->where('name', $hotel);
                                    $query = $this->db->get('hotels');
                                    $row = $query->row(1);

                                    if ($beds == "2") {
                                        $givenRooms = $row->twobeds;
                                    } elseif ($beds == "3") {
                                        $givenRooms = $row->threebeds;
                                    } elseif ($beds == "4") {
                                        $givenRooms = $row->fourbeds;
                                    }

                                    //deduce the available rooms
                                    $availableRooms = $givenRooms - $finalisedRooms;

                                    if ($availableRooms == 0)   //if there are no more available rooms with x beds on y hotel
                                    {
                                        $this->db->where('final!=', "1");
                                        $this->db->where('hotel', $hotel);
                                        $this->db->where('beds', $beds);

                                        $result = $this->db->get('rooming');
                                        foreach ($result->result_array() as $row) {

                                            //send mail to participants
                                            $participantIDs = array(
                                                $row->participant1,
                                                $row->participant2,
                                                $row->participant3,
                                                $row->participant4

                                            );
                                            foreach ($participantIDs as $pid) {
                                                //get participant email and name by id
                                                if ($pid != "") {
                                                    $this->db->where('id', $pid);
                                                    $query = $this->db->get('participants');
                                                    $row = $query->row(1);
                                                    $pemail = $row->email;
                                                    $pname = $row->name;

                                                    $this->email->set_mailtype("html");
                                                    $this->email->from('oc@thecretetrip.org', 'The Crete Trip 2017 Organising Committee');
                                                    $this->email->to($pemail);  //send mail to participant
                                                    $this->email->bcc('it@esngreece.gr'); //bcc moi
                                                    $this->email->subject('Your room has been deleted, please repeat the rooming process');
                                                    $this->email->message('
                                                        <p>Dear ' . $pname . ',</p>
                                                        <p>We have to regretfully inform you that you didn\'t complete your room in time and now all ' . $beds . '-bed rooms have been fully occupied. As we announced before, the room assignment is a first come first served process and the rest of your group wasn\'t fast enough.</p>
                                                        <p>What you can do now is perform the rooming process again, by accessing the link below:</p>
                                                        <p><strong><a href="https://registrations.thecretetrip.org/rooming">https://registrations.thecretetrip.org/rooming</a></strong></p>
                                                        <p>(If the link doesn\'t work, copy-paste it in your browser.)</p>
                                                        <p>The same goes for your roommates, if you had any in the temporary room that has been deleted, they have to join you again. Please notify them as well, in case they didn\'t see or get this email.</p>
                                                        <p style="color : red">If you can\'t perfectly fit in a room anymore, select the "Random Room" option, leaving your desired roommates\' name(s) in the comment box. We\'ll do our best to try to match you, but we can\'t promise anything.</p>
                                                        <p>If you have further questions, please contact <a href="mailto:it@esngreece.gr">it@esngreece.gr</a>.</p>
                                                        <p>See you in a few days,</p>
                                                        <p>The Organising Committee of The Crete Trip 2017</p>
                                                    ');

                                                    $this->email->send();
                                                } else {
                                                    continue;
                                                }
                                            }
                                        }

                                        //TODO drop rooms
                                        $this->db->where('final!=', "1");
                                        $this->db->where('hotel', $hotel);
                                        $this->db->where('beds', $beds);

                                        $this->db->delete('rooming');


                                    }

                                    return 1;
                                } else {
                                    echo "Database error";
                                    return 0;
                                }
                            } else {

                                echo "Database error";
                                return 0;
                            }
                        }
                    } elseif ($beds == 4) {
                        if ($row->participant2 == "") {
                            //TODO register participant
                            //copy from here
                            $this->db->where('id', $pid);
                            $query = $this->db->get('participants');
                            $row = $query->row(1);
                            $section = $row->esnsection;
                            if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                                || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                                $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
                            ) {
                                $correctHotel = "Marilena";
                            } else {
                                $correctHotel = "Vanisko";
                            }

                            if ($hotel != $correctHotel) {
                                return 4;
                            }
                            //to here
                            $this->db->where('id', $roomid);

                            $data = array(
                                'participant2' => $pid,
                            );

                            if ($this->db->update('rooming', $data)) {
                                return 1;
                            } else {

                                echo "Database error";
                                return 0;
                            }
                        } elseif ($row->participant3 == "") {
                            //TODO register participant
                            //copy from here
                            $this->db->where('id', $pid);
                            $query = $this->db->get('participants');
                            $row = $query->row(1);
                            $section = $row->esnsection;
                            if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                                || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                                $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
                            ) {
                                $correctHotel = "Marilena";
                            } else {
                                $correctHotel = "Vanisko";
                            }

                            if ($hotel != $correctHotel) {
                                return 4;
                            }
                            //to here
                            $this->db->where('id', $roomid);

                            $data = array(
                                'participant3' => $pid,
                            );

                            if ($this->db->update('rooming', $data)) {
                                return 1;
                            } else {

                                echo "Database error";
                                return 0;
                            }
                        } elseif ($row->participant4 == "") {
                            //TODO register participant and close room -- DONE
                            //copy from here
                            $this->db->where('id', $pid);
                            $query = $this->db->get('participants');
                            $row = $query->row(1);
                            $section = $row->esnsection;
                            if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                                || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                                $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
                            ) {
                                $correctHotel = "Marilena";
                            } else {
                                $correctHotel = "Vanisko";
                            }

                            if ($hotel != $correctHotel) {
                                return 4;
                            }
                            //to here
                            $this->db->where('id', $roomid);

                            $data = array(
                                'participant4' => $pid,
                                'final' => "1"
                            );

                            if ($this->db->update('rooming', $data)) {
                                $this->db->where('id', $pid);

                                $data = array(
                                    'rooming' => $roomid
                                );

                                if ($this->db->update('participants', $data)) {
                                    //update 1st participant in participants table
                                    $this->db->where('id', $participant1);
                                    $data = array(
                                        'rooming' => $roomid
                                    );
                                    $this->db->update('participants', $data);

                                    //update 2nd participant in participants table
                                    $this->db->where('id', $participant2);
                                    $data = array(
                                        'rooming' => $roomid
                                    );
                                    $this->db->update('participants', $data);

                                    //update 3rd participant in participants table
                                    $this->db->where('id', $participant3);
                                    $data = array(
                                        'rooming' => $roomid
                                    );
                                    $this->db->update('participants', $data);

                                    //drop rooms and send email to participants //TODO FIX after event

                                    //Get finalised rooms with x number of beds from y hotel
                                    $this->db->where('hotel', $hotel);
                                    $this->db->where('final', "1");
                                    $this->db->where('beds', $beds);

                                    $query = $this->db->get('rooming');
                                    $finalisedRooms = $query->num_rows(); //number of fin rooms with x beds from y hotel

                                    //Get amount of given rooms with x number of beds from y hotel
                                    $this->db->where('name', $hotel);
                                    $query = $this->db->get('hotels');
                                    $row = $query->row(1);

                                    if ($beds == "2") {
                                        $givenRooms = $row->twobeds;
                                    } elseif ($beds == "3") {
                                        $givenRooms = $row->threebeds;
                                    } elseif ($beds == "4") {
                                        $givenRooms = $row->fourbeds;
                                    }

                                    //deduce the available rooms
                                    $availableRooms = $givenRooms - $finalisedRooms;

                                    if ($availableRooms == 0)   //if there are no more available rooms with x beds on y hotel
                                    {
                                        $this->db->where('final!=', "1");
                                        $this->db->where('hotel', $hotel);
                                        $this->db->where('beds', $beds);

                                        $result = $this->db->get('rooming');
                                        foreach ($result->result_array() as $row) {

                                            //send mail to participants
                                            $participantIDs = array(
                                                $row->participant1,
                                                $row->participant2,
                                                $row->participant3,
                                                $row->participant4

                                            );
                                            foreach ($participantIDs as $pid) {
                                                //get participant email and name by id
                                                if ($pid != "") {
                                                    $this->db->where('id', $pid);
                                                    $query = $this->db->get('participants');
                                                    $row = $query->row(1);
                                                    $pemail = $row->email;
                                                    $pname = $row->name;

                                                    $this->email->set_mailtype("html");
                                                    $this->email->from('oc@thecretetrip.org', 'The Crete Trip 2017 Organising Committee');
                                                    $this->email->to($pemail);  //send mail to participant
                                                    $this->email->bcc('it@esngreece.gr'); //bcc moi
                                                    $this->email->subject('Your room has been deleted, please repeat the rooming process');
                                                    $this->email->message('
                                                        <p>Dear ' . $pname . ',</p>
                                                        <p>We have to regretfully inform you that you didn\'t complete your room in time and now all ' . $beds . '-bed rooms have been fully occupied. As we announced before, the room assignment is a first come first served process and the rest of your group wasn\'t fast enough.</p>
                                                        <p>What you can do now is perform the rooming process again, by accessing the link below:</p>
                                                        <p><strong><a href="https://registrations.thecretetrip.org/rooming">https://registrations.thecretetrip.org/rooming</a></strong></p>
                                                        <p>(If the link doesn\'t work, copy-paste it in your browser.)</p>
                                                        <p>The same goes for your roommates, if you had any in the temporary room that has been deleted, they have to join you again. Please notify them as well, in case they didn\'t see or get this email.</p>
                                                        <p style="color : red">If you can\'t perfectly fit in a room anymore, select the "Random Room" option, leaving your desired roommates\' name(s) in the comment box. We\'ll do our best to try to match you, but we can\'t promise anything.</p>
                                                        <p>If you have further questions, please contact <a href="mailto:it@esngreece.gr">it@esngreece.gr</a>.</p>
                                                        <p>See you in a few days,</p>
                                                        <p>The Organising Committee of The Crete Trip 2017</p>
                                                    ');

                                                    $this->email->send();
                                                } else {
                                                    continue;
                                                }
                                            }
                                        }

                                        //TODO drop rooms
                                        $this->db->where('final!=', "1");
                                        $this->db->where('hotel', $hotel);
                                        $this->db->where('beds', $beds);

                                        $this->db->delete('rooming');


                                    }

                                    return 1;
                                } else {
                                    echo "Database error";
                                    return 0;
                                }
                            } else {

                                echo "Database error";
                                return 0;
                            }
                        }
                    }
                } else {
                    return 2;   //room is full
                }
            } else {
                return 3;  //wrong code
            }
        } else {
            echo "Room not found";
            return 0;
        }
    }

    function createRandomRoom($comments, $pid)
    {
        $this->db->where('id', $pid);

        $data = array(
            'roomingcomments' => $comments,
            'rooming' => "random"
        );

        if ($this->db->update('participants', $data)) {  //update password in table sections
            return 1;
        } else {

            echo "Database error";
            return 0;
        }

    }

    function getRoomCode($rid = "")
    {
        $this->db->where('id', $rid);
        $query = $this->db->get('rooming');

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {

            return $row->code;
        } else {

            return 0; //return FALSE
        }
    }

    function getRoomAvailability($hotel, $beds)  //TODO take a look after event
    {
        $this->db->where('hotel', $hotel);
        $this->db->where('final', '1');
        $this->db->where('beds', $beds);
        $query = $this->db->get('rooming');

        $reserved = $query->num_rows();      //get the number of rooms that are reserved

        $this->db->where('name', $hotel);
        $query = $this->db->get('hotels');

        $row = $query->row(1);      //get the first (and only) row of results
        $total = '';
        if ($query->num_rows() == 1) {
            if ($beds == '2') {
                $total = $row->twobeds;
            } elseif ($beds == '3') {
                $total = $row->threebeds;
            } elseif ($beds == '4') {
                $total = $row->fourbeds;
            }
            $available = $total - $reserved;
            if ($available >= 0) {
                return $available; //get number of available rooms
            } else {
                return 0;
            }
        } else {

            return 0; //return FALSE
        }

    }

    function getParticipantRoom($pid)
    {
        $this->db->where('participant1', $pid);
        $this->db->or_where('participant2', $pid);
        $this->db->or_where('participant3', $pid);
        $this->db->or_where('participant4', $pid);
        $query = $this->db->get('rooming');

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {


            $array = array(
                'rid' => $row->id,
                'code' => $row->code
            );

            return $array;
        } else {

            return 0; //return FALSE
        }
    }

    function checkIfParticipantHasRoom($pid)
    {
        $this->db->where('participant1', $pid);
        $this->db->or_where('participant2', $pid);
        $this->db->or_where('participant3', $pid);
        $this->db->or_where('participant4', $pid);
        $query = $this->db->get('rooming');

        if ($query->num_rows() == 1) { //if there is a result

            return 1;
        } else {

            return 0; //return FALSE
        }
    }

    function getNumberOfFinalisedRooms($hotel, $beds)
    {
        $this->db->where('hotel', $hotel);
        $this->db->where('final', "1");
        $this->db->where('beds', $beds);

        $query = $this->db->get('rooming');
        $finalisedRooms = $query->num_rows();

        return $finalisedRooms;
    }

    function getGivenRooms($hotel, $beds)
    {
        $this->db->where('name', $hotel);
        $query = $this->db->get('hotels');

        $row = $query->row(1);      //get the first (and only) row of results

        if ($query->num_rows() == 1) {
            if ($beds == '2') {
                return $row->twobeds;
            } elseif ($beds == '3') {
                return $row->threebeds;
            } elseif ($beds == '4') {
                return $row->fourbeds;
            }

        } else {

            return 0; //return FALSE
        }
    }
}