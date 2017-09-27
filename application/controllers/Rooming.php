<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rooming extends CI_Controller
{
    public function index()
    {

        $this->home();

    }

    public function home()
    {
        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {     //if user is already logged in

            /*Load models into data table*/
            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
            $data['role'] = $this->model_participant->get_participant_name($pid);
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_event');
            $data['model_event'] = $this->model_event;
            $data['pid']=$pid;
            $this->load->view('header');
            $this->load->view('participantnav');
            $this->load->view('content_rooming', $data);
            $this->load->view('footer');
        } else {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha');   //check for captcha
            $this->form_validation->set_rules("email", "Email", "required|trim|strtolower|valid_email|xss_clean");

            if ($this->form_validation->run() == FALSE) {  //if captcha fails, load login again

                $data = array(
                    "message" => ""
                );

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('content_login', $data);
                $this->load->view('footer');
            } else {                                        //if captcha succeeds
                $this->load->model('model_participant');
                $query = $this->model_participant->validate();  //check for user in the database

                if ($query) {                                   //if user exists

                    $this->load->model('model_participant');
                    $participantId = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $name = $this->model_participant->get_participant_name($participantId);

                    $data = array(                              //prepare session data
                        'email' => $this->input->post('email'),
                        'type' => 'mortal',          //make sure there's no confusion with manager or admin private area
                        'section' => $name,
                        'timestamp' => time(),
                        'is_logged_in' => TRUE
                    );
                    $this->session->set_userdata($data);         //create a session

                    /*Load models into data table*/
                    $this->load->model('model_participant');
                    $data['model_participant'] = $this->model_participant;
                    $this->load->model('model_event');
                    $data['model_event'] = $this->model_event;

                    $this->load->model('model_participant');
                    $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $data['role'] = $this->model_participant->get_participant_name($pid);
                    $data['pid']=$pid;

                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_rooming', $data);
                    $this->load->view('footer');
                } else {                                 //if user doesn't exist

                    $data = array(
                        "message" => "Wrong username or password"
                    );

                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('content_login', $data);
                    $this->load->view('footer');
                    $data['message'] = '';
                }


            }

        }
    }

    public function recaptcha($str = '')
    {
        $google_url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = '6LfbXxYUAAAAAHpWtJsSyY4UpnyC1cywGGALn1oG';
        $ip = $_SERVER['REMOTE_ADDR'];
        $url = $google_url . "?secret=" . $secret . "&response=" . $str . "&remoteip=" . $ip;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $res = curl_exec($curl);
        curl_close($curl);
        $res = json_decode($res, true);
        //reCaptcha success check
        if ($res['success']) {
            return TRUE;
        } else {
            $this->form_validation->set_message('recaptcha', 'The reCAPTCHA field is telling me that you are a robot. Shall we give it another try?');
            return FALSE;
        }

    }

    function createroom()
    {
        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {     //if user is already logged in


            /*Load models into data table*/
            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID


            $data['role'] = $this->model_participant->get_participant_name($pid);
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_event');
            $data['model_event'] = $this->model_event;
            $hasRoom = $this->model_event->checkIfParticipantHasRoom($pid);
            if ($hasRoom == 0) { //if participant doesn't have a room
                $this->load->view('header');
                $this->load->view('participantnav');
                $this->load->view('content_createRoom', $data);
                $this->load->view('footer');
            } else {
                redirect('rooming');
            }
        } else {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha');   //check for captcha
            $this->form_validation->set_rules("email", "Email", "required|trim|strtolower|valid_email|xss_clean");

            if ($this->form_validation->run() == FALSE) {  //if captcha fails, load login again

                $data = array(
                    "message" => ""
                );

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('content_login', $data);
                $this->load->view('footer');
            } else {                                        //if captcha succeeds
                $this->load->model('model_participant');
                $query = $this->model_participant->validate();  //check for user in the database

                if ($query) {                                   //if user exists

                    $this->load->model('model_participant');
                    $participantId = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $name = $this->model_participant->get_participant_name($participantId);

                    $data = array(                              //prepare session data
                        'email' => $this->input->post('email'),
                        'type' => 'mortal',          //make sure there's no confusion with manager or admin private area
                        'section' => $name,
                        'timestamp' => time(),
                        'is_logged_in' => TRUE
                    );
                    $this->session->set_userdata($data);         //create a session

                    /*Load models into data table*/
                    $this->load->model('model_participant');
                    $data['model_participant'] = $this->model_participant;
                    $this->load->model('model_event');
                    $data['model_event'] = $this->model_event;

                    $this->load->model('model_participant');
                    $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $data['role'] = $this->model_participant->get_participant_name($pid);

                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_createRoom', $data);
                    $this->load->view('footer');
                } else {                                 //if user doesn't exist

                    $data = array(
                        "message" => "Wrong username or password"
                    );

                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('content_login', $data);
                    $this->load->view('footer');
                    $data['message'] = '';
                }
            }
        }
    }

    function createroomconfirmation()
    {

        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {
            //load the model_sections & model_countries
            $this->load->model("model_getsections");
            $this->load->model("model_getcountries");
            $this->load->model("model_participant");
            $this->load->model("model_event");

            $bedsValidation = "2,3,4"; //TODO make dynamic

            //Dynamic beds validation start

            $bedsValidation = '';
            $section = $this->model_participant->get_participant_section($this->model_participant->get_participant_id_by_mail($this->session->userdata("email"))); //get participant section
            if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
            ) {
                $hotel = "Marilena";
            } elseif ($section == "ESN IOANINNA" || $section == "ESN CYPRUS" || $section == "ESN DUTH" || $section == "ESN AEGEAN" || $section == "ESN UOPA" || $section == "ESN TUC" ||
                $section == "No ESN Section" || $section == "International Guest ESNer" || $section == "Erasmus Guest (not Erasmus in Greece OR Cyprus)"
            ) {
                $hotel = "Vanisko";
            }


            if ($this->model_event->getRoomAvailability($hotel, "2")) {
                $bedsValidation = $bedsValidation . "2,";
            }
            if ($this->model_event->getRoomAvailability($hotel, "3")) {
                $bedsValidation = $bedsValidation . "3,";
            }
            if ($this->model_event->getRoomAvailability($hotel, "4")) {
                $bedsValidation = $bedsValidation . "4,";
            }
            //Dynamic beds validation end
            $this->form_validation->set_rules("beds", "No of beds", "required|in_list[$bedsValidation]|xss_clean");
            $this->form_validation->set_rules("comments", "Comments", "xss_clean");


            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
            $data['role'] = $this->model_participant->get_participant_name($pid);
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_event');
            $data['model_event'] = $this->model_event;

            if ($this->form_validation->run() === FALSE) {
                $this->load->view('header');
                $this->load->view('participantnav');
                $this->load->view('content_createRoom', $data);
                $this->load->view('footer');
            } else {

                $this->load->model('model_event');
                $this->load->model('model_participant');
                $code = $this->model_event->generateRoomCode();
                $beds = $this->input->post('beds');
                $comments = $this->input->post('comments');
                $pid = $this->model_participant->get_participant_id_by_mail($this->session->userdata('email'));
                $section = $this->model_participant->get_participant_section($pid);
                if ($section == "ESN ATEITH" || $section == "ESN AUA ATHENS" || $section == "ESN AUTH" || $section == "ESN ATHENS AUEB" || $section == "ESN HARO" || $section == "ESN KAPA ATHENS"
                    || $section == "ESN LARISSA" || $section == "ESN NTUA ATHENS" || $section == "ESN PANTEION" || $section == "ESN TEI ATHENS" || $section == "ESN TEI OF PIRAEUS" ||
                    $section == "ESN TEI OF WESTERN MACEDONIA" || $section == "ESN TEISTE" || $section == "ESN UOM THESSALONIKI" || $section == "ESN UNIPI"
                ) {  //TODO make dynamic after event
                    $hotel = "Marilena";
                } elseif ($section == "ESN IOANINNA" || $section == "ESN CYPRUS" || $section == "ESN DUTH" || $section == "ESN AEGEAN" || $section == "ESN UOPA" || $section == "ESN TUC" ||
                    $section == "No ESN Section" || $section == "International Guest ESNer" || $section == "Erasmus Guest (not Erasmus in Greece OR Cyprus)"
                ) {
                    $hotel = "Vanisko";
                }


                if ($query = $this->model_event->createRoom($beds, $comments, $code, $pid, $hotel)) {
                    redirect('rooming');
                } else {

                    echo "Database ERROR. Contact an administrator";
                }
            }
        } else {
            redirect('rooming');
        }
    }

    function joinroom()
    {
        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {     //if user is already logged in

            /*Load models into data table*/
            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
            $data['role'] = $this->model_participant->get_participant_name($pid);
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_event');
            if ($this->model_event->checkIfParticipantHasRoom($pid) == 0) { //if participant doesn't have a room //TODO EXPLAIN

                //Check form validation for room submission
                $this->form_validation->set_rules("code", "Code", "required|trim|numeric|xss_clean");

                if ($this->form_validation->run() == FALSE) {
                    $data = array(
                        "message" => ""
                    );

                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_joinRoom', $data);
                    $this->load->view('footer');
                } else {
                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_joinRoom', $data);
                    $this->load->view('footer');

                }
            } else {
                redirect('rooming');
            }
        } else {
            $this->form_validation->set_rules("code", "Code", "required|trim|numeric|xss_clean");

            if ($this->form_validation->run() == FALSE) {  //if captcha fails, load login again

                $data = array(
                    "message" => ""
                );

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('content_login', $data);
                $this->load->view('footer');
            } else {                                        //if captcha succeeds
                $this->load->model('model_participant');
                $query = $this->model_participant->validate();  //check for user in the database

                if ($query) {                                   //if user exists

                    $this->load->model('model_participant');
                    $participantId = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $name = $this->model_participant->get_participant_name($participantId);

                    $data = array(                              //prepare session data
                        'email' => $this->input->post('email'),
                        'type' => 'mortal',          //make sure there's no confusion with manager or admin private area
                        'section' => $name,
                        'timestamp' => time(),
                        'is_logged_in' => TRUE
                    );
                    $this->session->set_userdata($data);         //create a session

                    /*Load models into data table*/
                    $this->load->model('model_participant');
                    $data['model_participant'] = $this->model_participant;

                    $this->load->model('model_participant');
                    $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $data['role'] = $this->model_participant->get_participant_name($pid);
                    $this->load->model('model_event');
                    if ($this->model_event->checkIfParticipantHasRoom($pid) == 0) { //if participant doesn't have a room //TODO EXPLAIN
                        $this->load->view('header');
                        $this->load->view('participantnav');
                        $this->load->view('content_joinRoom', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('rooming');
                    }
                } else {                                 //if user doesn't exist

                    $data = array(
                        "message" => "Wrong username or password"
                    );

                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('content_login', $data);
                    $this->load->view('footer');
                    $data['message'] = '';
                }


            }

        }
    }

    function joinroomconfirmation()
    {
        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {

            //load the model_sections & model_countries
            $this->load->model("model_getsections");
            $this->load->model("model_getcountries");
            $this->load->model("model_participant");
            $this->load->model("model_event");
            $this->load->model('model_event');

            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
            if ($this->model_event->checkIfParticipantHasRoom($pid) == 0) { //if participant doesn't have a room //TODO EXPLAIN

                $this->form_validation->set_rules("comments", "Comments", "xss_clean");
                $this->form_validation->set_rules("id", "Room ID", "required|trim|numeric|xss_clean");
                $this->form_validation->set_rules("code", "Code", "required|trim|numeric|max_length[6]|xss_clean");


                $this->load->model('model_participant');
                $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                $data['role'] = $this->model_participant->get_participant_name($pid);
                $this->load->model('model_participant');
                $data['model_participant'] = $this->model_participant;
                $this->load->model('model_event');
                $data['model_event'] = $this->model_event;

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_joinRoom', $data);
                    $this->load->view('footer');
                } else {

                    $this->load->model('model_event');
                    $this->load->model('model_participant');
                    $code = $this->input->post('code');
                    $roomid = $this->input->post('id');
                    $pid = $this->model_participant->get_participant_id_by_mail($this->session->userdata('email'));

                    $query = $this->model_event->joinRoom($roomid, $code, $pid);
                    if ($query == 1) {  //room joined successfully
                        redirect('rooming');
                    } elseif ($query == 2) { //room is full
                        $data = array(
                            "message" => "The room is full. Please join a different or a random room"
                        );

                        $this->load->model('model_participant');
                        $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                        $data['role'] = $this->model_participant->get_participant_name($pid);
                        $this->load->model('model_participant');
                        $data['model_participant'] = $this->model_participant;
                        $this->load->model('model_event');
                        $data['model_event'] = $this->model_event;


                        $this->load->view('header');
                        $this->load->view('nav');
                        $this->load->view('content_joinRoom', $data);
                        $this->load->view('footer');
                        $data['message'] = '';
                    } elseif ($query == 3) { //wrong code
                        $data = array(
                            "message" => "Wrong room id - code combination"
                        );

                        $this->load->model('model_participant');
                        $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                        $data['role'] = $this->model_participant->get_participant_name($pid);
                        $this->load->model('model_participant');
                        $data['model_participant'] = $this->model_participant;
                        $this->load->model('model_event');
                        $data['model_event'] = $this->model_event;


                        $this->load->view('header');
                        $this->load->view('nav');
                        $this->load->view('content_joinRoom', $data);
                        $this->load->view('footer');
                        $data['message'] = '';

                    } elseif ($query == 4){
                        $data = array(
                            "message" => "You can't enter this room because it belongs to a different hotel group. Please contact your Local Coordinator for more info"
                        );;

                        $this->load->model('model_participant');
                        $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                        $data['role'] = $this->model_participant->get_participant_name($pid);
                        $this->load->model('model_participant');
                        $data['model_participant'] = $this->model_participant;
                        $this->load->model('model_event');
                        $data['model_event'] = $this->model_event;


                        $this->load->view('header');
                        $this->load->view('nav');
                        $this->load->view('content_joinRoom', $data);
                        $this->load->view('footer');
                        $data['message'] = '';

                    }else {


                        $data = array(
                            "message" => "The room doesn't exist, has been deleted or there is an error in your input"
                        );

                        $this->load->model('model_participant');
                        $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                        $data['role'] = $this->model_participant->get_participant_name($pid);
                        $this->load->model('model_participant');
                        $data['model_participant'] = $this->model_participant;
                        $this->load->model('model_event');
                        $data['model_event'] = $this->model_event;


                        $this->load->view('header');
                        $this->load->view('nav');
                        $this->load->view('content_joinRoom', $data);
                        $this->load->view('footer');
                        $data['message'] = '';
                    }
                }
            }
        } else {
            redirect('rooming');
        }
    }

    function randomroom()
    {
        //TODO set participant state as random

        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {     //if user is already logged in

            /*Load models into data table*/
            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
            $data['role'] = $this->model_participant->get_participant_name($pid);
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_event');
            if ($this->model_event->checkIfParticipantHasRoom($pid) == 0) { //if participant doesn't have a room //TODO EXPLAIN
                $this->load->view('header');
                $this->load->view('participantnav');
                $this->load->view('content_randomRoom', $data);
                $this->load->view('footer');
            } else {
                redirect('rooming');
            }
        } else {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha');   //check for captcha
            $this->form_validation->set_rules("email", "Email", "required|trim|strtolower|valid_email|xss_clean");

            if ($this->form_validation->run() == FALSE) {  //if captcha fails, load login again

                $data = array(
                    "message" => ""
                );

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('content_login', $data);
                $this->load->view('footer');
            } else {                                        //if captcha succeeds
                $this->load->model('model_participant');
                $query = $this->model_participant->validate();  //check for user in the database

                if ($query) {                                   //if user exists

                    $this->load->model('model_participant');
                    $participantId = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $name = $this->model_participant->get_participant_name($participantId);

                    $data = array(                              //prepare session data
                        'email' => $this->input->post('email'),
                        'type' => 'mortal',          //make sure there's no confusion with manager or admin private area
                        'section' => $name,
                        'timestamp' => time(),
                        'is_logged_in' => TRUE
                    );
                    $this->session->set_userdata($data);         //create a session

                    /*Load models into data table*/
                    $this->load->model('model_participant');
                    $data['model_participant'] = $this->model_participant;

                    $this->load->model('model_participant');
                    $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                    $data['role'] = $this->model_participant->get_participant_name($pid);
                    $this->load->model('model_event');
                    if ($this->model_event->checkIfParticipantHasRoom($pid) == 0) { //if participant doesn't have a room //TODO EXPLAIN
                        $this->load->view('header');
                        $this->load->view('participantnav');
                        $this->load->view('content_randomRoom', $data);
                        $this->load->view('footer');
                    } else {
                        redirect('rooming');
                    }
                } else {                                 //if user doesn't exist

                    $data = array(
                        "message" => "Wrong username or password"
                    );

                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('content_login', $data);
                    $this->load->view('footer');
                    $data['message'] = '';
                }


            }

        }
    }

    function randomroomconfirmation()
    {
        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {
            //load the model_sections & model_countries
            $this->load->model("model_getsections");
            $this->load->model("model_getcountries");
            $this->load->model("model_participant");
            $this->load->model("model_event");
            $this->load->model('model_event');

            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
            if ($this->model_event->checkIfParticipantHasRoom($pid) == 0) { //if participant doesn't have a room //TODO EXPLAIN

                $this->form_validation->set_rules("comments", "Comments", "xss_clean");


                $this->load->model('model_participant');
                $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
                $data['role'] = $this->model_participant->get_participant_name($pid);
                $this->load->model('model_participant');
                $data['model_participant'] = $this->model_participant;
                $this->load->model('model_event');
                $data['model_event'] = $this->model_event;

                if ($this->form_validation->run() === FALSE) {
                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_randomRoom', $data);
                    $this->load->view('footer');
                } else {

                    $this->load->model('model_event');
                    $this->load->model('model_participant');
                    $comments = $this->input->post('comments');
                    $pid = $this->model_participant->get_participant_id_by_mail($this->session->userdata('email'));


                    if ($query = $this->model_event->createRandomRoom($comments, $pid)) {
                        redirect('rooming');
                    } else {

                        echo "Database error. Contact an administrator";
                    }
                }
            }
        } else {
            redirect('rooming');
        }
    }
}