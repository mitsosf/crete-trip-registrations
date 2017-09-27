<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Controller to be used by LCs/GLs
class Account extends CI_Controller
{
    public function index(){
        $accountEnabled =FALSE;     //deactivate account functions
        if($accountEnabled){        //if account functions are enabled
            echo "Participant account area - Under development";
        }else{
           $this->home();
            //copy home in here

        }

    }

    public function home(){
        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'mortal') {     //if user is already logged in

            /*Load models into data table*/
            $this->load->model('model_participant');
            $pid = $this->model_participant->get_participant_id_by_mail($this->input->post('email'));  //participantID
            $data['role'] = $this->model_participant->get_participant_name($pid);
            $data['model_participant'] = $this->model_participant;

            $this->load->view('header');
            $this->load->view('participantnav');
            $this->load->view('content_participantPanel', $data);
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
                $this->load->view('content_login',$data);
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

                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_participantPanel', $data);
                    $this->load->view('footer');
                } else {                                 //if user doesn't exist

                    $data = array(
                        "message" => "Wrong username or password"
                    );

                    $this->load->view('header');
                    $this->load->view('nav');
                    $this->load->view('content_login',$data);
                    $this->load->view('footer');
                    $data['message']='';
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

    public function changePassword()
    {


        $this->form_validation->set_rules("password", "Password", "required|min_length[5]|max_length[200]|xss_clean");
        $this->form_validation->set_rules("passwordConfirmation", "Password confirmation", "required|matches[password]|max_length[200]|xss_clean");

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('header');
            $this->load->view('participantnav');
            $this->load->view('content_changePassword');
            $this->load->view('footer');
        } else {

            //update password in the database
            $this->load->model('model_participant');
            $this->model_participant->changePassword();
        }

    }

    public function bankAndUpload()
    {
        /*$this->load->view('upload_form', array('error' => ' ' ));*/
        if ($this->session->is_logged_in == TRUE && $this->session->type == 'mortal') {

            $data['error'] = ' ';
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;

            $this->load->view('header');
            $this->load->view('participantnav');
            $this->load->view('content_uploadProofOfPaymentParticipant', $data);
            $this->load->view('footer');

        } else {
            redirect(base_url('account'));
        }
    }

    public function do_upload()
    {
        if ($this->session->is_logged_in == TRUE && $this->session->type == 'mortal') {
            $config['upload_path'] = './proofs_of_payment/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 0;
            $config['max_width'] = 10240;

            $this->load->library('upload', $config);

            $this->form_validation->set_rules("amount", "Amount", "required|trim|max_length[200]|numeric|xss_clean");
            $this->form_validation->set_rules("comments", "Comments", "xss_clean");

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = ' ';
                $this->load->model('model_section');
                $data['model_section'] = $this->model_section;
                $this->load->model('model_participant');
                $data['model_participant'] = $this->model_participant;

                $this->load->view('header');
                $this->load->view('participantnav');
                $this->load->view('content_uploadProofOfPaymentParticipant', $data);
                $this->load->view('footer');
            } else {
                if (!$this->upload->do_upload()) {

                    $data['error'] = $this->upload->display_errors();
                    $this->load->model('model_section');
                    $data['model_section'] = $this->model_section;
                    $this->load->model('model_participant');
                    $data['model_participant'] = $this->model_participant;

                    $this->load->view('header');
                    $this->load->view('participantnav');
                    $this->load->view('content_uploadProofOfPaymentParticipant', $data);
                    $this->load->view('footer');


                } else {
                    $this->load->model('model_participant');

                    $database_entry = array(
                        'path' => '/proofs_of_payment/'.$this->upload->data('file_name'),
                        'amount' => $this->input->post('amount'),
                        'participants' => '0',
                        'individual' => $this->model_participant->getDepositReference($this->session->email),
                        'comments' => $this->input->post('comments'),
                        'esnsection' => $this->session->section

                    );

                    $this->load->model('model_participant');

                    if ($query = $this->model_participant->enterProofOfPaymentIntoDatabase($database_entry)) {

                        //Send confirmation email

                        $this->email->set_mailtype("html");
                        $this->email->from('do-not-reply@thecretetrip.org', 'The Crete Trip 2017 System');
                        $this->email->to('finance@thecretetrip.org');  //send mail to treasurer
                        $this->email->cc('section-c@thecretetrip.org'); //cc sections coordinator
                        $this->email->bcc('it@esngreece.gr'); //bcc IT Systems Manager
                        $this->email->subject('New proof of payment uploaded by '.$this->session->section);
                        $this->email->message('
                <p>Dear Treasurer,</p>

<p>There is a new proof of payment uploaded by '.$this->session->section.'.</p>

<p>Please review it in the <b><a href="https://registrations.thecretetrip.org/godmode">Godmode Panel</a></b></p>

<p>The form submission is:</p>

<p>Section: ' . $this->session->section. '<br>
Amount: ' . $this->input->post('amount') . '<br>
Comments: ' . $this->input->post('comments') . '<br>
</p>

<p>Have a nice day,</p>

<p>The Matrix</p>
                ');

                        $this->email->send();


                        $data['upload_data'] = $this->upload->data();
                        $this->load->model('model_section');
                        $data['model_section'] = $this->model_section;
                        $this->load->model('model_participant');
                        $data['model_participant'] = $this->model_participant;
                        $data['error'] = '<h3 style="color: green;">Your file was uploaded successfully</h3>';


                        $this->load->view('header');
                        $this->load->view('participantnav');
                        $this->load->view('content_uploadProofOfPaymentParticipant', $data);
                        $this->load->view('footer');
                    }else{
                        echo "Database error";
                    }
                }
            }
        } else {
            redirect(base_url('manage'));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('account');
    }


}