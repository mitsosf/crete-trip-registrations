<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Controller to be used by LCs/GLs
class Godmode extends CI_Controller
{
    public function index()
    {
        $this->home();
    }

    public function home()
    {
        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'god') {     //if user is already logged in
            $this->load->model('model_admin');
            $data['role'] = $this->model_admin->getRole($this->input->post('email'));

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_event');
            $data['model_event'] = $this->model_event;


            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_adminPanel', $data);
            $this->load->view('footer');
        } else {
            //TODO fix captcha
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
                $this->load->model('model_admin');
                $query = $this->model_admin->validate();  //check for user in the database

                if ($query) {                                   //if user exists

                    $this->load->model('model_admin');
                    $role = $this->model_admin->getRole($this->input->post('email'));

                    $data = array(                              //prepare session data
                        'email' => $this->input->post('email'),
                        'type' => 'god',
                        'section' => $role,              //make sure there's no confusion with manager private area
                        'timestamp' => time(),
                        'is_logged_in' => TRUE
                    );
                    $this->session->set_userdata($data);         //create a session

                    /*Load models into data table*/
                    $this->load->model('model_participant');
                    $data['model_participant'] = $this->model_participant;
                    $this->load->model('model_event');
                    $data['model_event'] = $this->model_event;

                    $this->load->model('model_admin');
                    $data['role'] = $this->model_admin->getRole($this->input->post('email')); //get Section name, pass it on table data and load it in the view

                    $this->load->view('header');
                    $this->load->view('adminnav');
                    $this->load->view('content_adminPanel', $data);
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

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('godmode');
    }

    public function sectionStats()
    {
        if ($this->session->type == "god") {     //check if user is logged in as god

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_getsections');
            $data['model_getsections'] = $this->model_getsections;
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;

            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_sectionStats', $data);
            $this->load->view('footer');


        } else {
            redirect('godmode');
        }
    }

    public function seeAsSection($section = '')
    {
        if ($this->session->type == "god") {     //check if user is logged in as god

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_getsections');
            $data['model_getsections'] = $this->model_getsections;
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;

            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_seeAsSection', $data);
            $this->load->view('footer');


        } else {
            redirect('godmode');
        }
    }

    public function cashflow()
    {
        if ($this->session->type == "god") {     //check if user is logged in as god

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_getsections');
            $data['model_getsections'] = $this->model_getsections;
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;

            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_cashflow', $data);
            $this->load->view('footer');


        } else {
            redirect('godmode');
        }
    }

    public function proofsOfPayment()
    {
        if ($this->session->type == "god") {

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_getsections');
            $data['model_getsections'] = $this->model_getsections;
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;
            $this->load->model('model_admin');
            $data['model_admin'] = $this->model_admin;

            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_approveProofsOfPayment', $data);
            $this->load->view('footer');


        } else {
            redirect('godmode');
        }

    }

    public function validateProofOfPayment($id = "")
    {
        if ($this->session->type == "god") {
            $this->load->model('model_admin');
            $this->model_admin->validateProofOfPayment($id);
            redirect('godmode/proofsOfPayment');
        } else {
            redirect('godmode');
        }
    }

    public function resetPasswords()
    {
        if ($this->session->type == "god") {

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_getsections');
            $data['model_getsections'] = $this->model_getsections;
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;
            $this->load->model('model_admin');
            $data['model_admin'] = $this->model_admin;

            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_resetPasswords', $data);
            $this->load->view('footer');


        } else {
            redirect('godmode');
        }

    }

    public function resetParticipantPassword($participant = "")
    {
        if ($this->session->type == "god") {

            $data = array(
                'participant' => $participant
            );

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_getsections');
            $data['model_getsections'] = $this->model_getsections;
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;
            $this->load->model('model_admin');
            $data['model_admin'] = $this->model_admin;

            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_resetParticipantPassword', $data);
            $this->load->view('footer');


        } else {
            redirect('godmode');
        }

    }

    public function newParticipantPassword($participant = "")
    {
        if ($this->session->type == "god") {

            $data = array(
                'participant' => $participant
            );

            /*Load models into data table*/
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_getsections');
            $data['model_getsections'] = $this->model_getsections;
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;
            $this->load->model('model_admin');
            $data['model_admin'] = $this->model_admin;

            $this->load->view('header');
            $this->load->view('adminnav');
            $this->load->view('content_newParticipantPassword', $data);
            $this->load->view('footer');


        } else {
            redirect('godmode');
        }

    }


    public function changePassword()
    {
        if ($this->session->type == "god") {

            $this->form_validation->set_rules("password", "Password", "required|min_length[5]|max_length[200]|xss_clean");
            $this->form_validation->set_rules("passwordConfirmation", "Password confirmation", "required|matches[password]|max_length[200]|xss_clean");

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('header');
                $this->load->view('adminnav');
                $this->load->view('content_changePassword');
                $this->load->view('footer');
            } else {

                //update password in the database
                $this->load->model('model_admin');
                $this->model_admin->changePassword();
            }
        } else {
            redirect('godmode');
        }

    }
}