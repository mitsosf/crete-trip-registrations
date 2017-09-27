<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Controller to be used by LCs/GLs
class Manage extends CI_Controller
{
    public function index()
    {

        if ($this->session->userdata('is_logged_in') && $this->session->userdata('type') == 'demigod') { //if user is already logged in
            $this->load->model('model_localadmin');
            $data['sectionName'] = $this->model_localadmin->getSection($this->input->post('email'));
            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->model('model_event');
            $data['model_event'] = $this->model_event;

            $this->load->view('header');
            $this->load->view('controlnav');
            $this->load->view('content_controlPanel', $data);
            $this->load->view('footer');
        } else {  //if user is not logged in
            //TODO fix captcha
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha'); //check for captcha
            $this->form_validation->set_rules("email", "Email", "required|trim|strtolower|valid_email|xss_clean");

            if ($this->form_validation->run() == FALSE) {       //if captcha fails, load login again
                $data = array(
                    "message" => ""
                );

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('content_login', $data);
                $this->load->view('footer');
            } else {                                            //if captcha succeeds
                $this->load->model('model_localadmin');
                $query = $this->model_localadmin->validate();  //check for user in the database

                if ($query) {                                   //if user exists

                    $this->load->model('model_localadmin');
                    $sectionName = $this->model_localadmin->getSection($this->input->post('email'));

                    $data = array(                                  //prepare session data
                        'email' => $this->input->post('email'),
                        'type' => 'demigod', //make sure they cannot access godmode private area
                        'section' => $sectionName,
                        'timestamp' => time(),
                        'is_logged_in' => TRUE
                    );
                    $this->session->set_userdata($data);            //create a session

                    $this->load->model('model_localadmin');
                    $data['sectionName'] = $this->model_localadmin->getSection($this->input->post('email')); //get Section name, pass it on table data and load it in the view
                    $this->load->model('model_participant');
                    $data['model_participant'] = $this->model_participant;
                    $this->load->model('model_event');
                    $data['model_event'] = $this->model_event;

                    $this->load->view('header');
                    $this->load->view('controlnav');
                    $this->load->view('content_controlPanel', $data);
                    $this->load->view('footer');
                } else {                                     //if user doesn't exist
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
        //redirect('manage');
        header("Refresh:0,url=/manage");
    }


    /* Function to confirm payment
     *
     *
     * */

    public function feePaymentConfirmation($participant = "")
    {
        $this->load->model('model_event');

        if ($this->model_event->getNumOfPaidHotelSpaces() < $this->model_event->getNumOfAvailableHotelSpaces()) {

            /*$this->load->model('model_participant');
            if($this->model_participant->get_number_of_participants())*/
            $data = array(
                'participant' => $participant
            );

            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->view('header');
            $this->load->view('controlnav');
            $this->load->view('content_feePaymentConfirmation', $data);
            $this->load->view('footer');
        } else {
            redirect('https://goo.gl/forms/PNK8AxWBtvfMUatB3');
        }
    }

    public function insertFeePaymentToDB()
    {
        $this->load->model('model_event');
        if ($this->model_event->getNumOfPaidHotelSpaces() < $this->model_event->getNumOfAvailableHotelSpaces()) {

            $participant = $this->session->participant;

            $this->load->model('model_participant');

            $participantSection = $this->model_participant->get_participant_section($participant);   //to check if participant is LCs participant
            $lcSection = $this->session->section;


            if ($participantSection != $lcSection) {   //if you're being naughty, go to control panel
                redirect(base_url('manage'));
            } else {                                  //if everything is ok


                if ($this->input->post('fee') == "") {   //if no special case, such as ESN UOC
                    $this->load->model('model_event');
                    $fee = $this->model_event->get_event_fee();

                    /* Enter payment to database*/
                    $data = array(
                        'feepayment' => $fee
                    );

                    $this->db->where('id', $participant);
                    $this->db->update('participants', $data);


                } else {   //if special case
                    if ($lcSection == "ESN TEI OF CRETE") {  //if TEI of Crete
                        $fee = 70;

                        /* Enter payment to database*/
                        $data = array(
                            'feepayment' => $fee
                        );

                        $this->db->where('id', $participant);
                        $this->db->update('participants', $data);

                    } else {     //if UOC
                        $fee = $this->input->post('fee');

                        /* Enter payment to database*/
                        $data = array(
                            'feepayment' => $fee
                        );

                        $this->db->where('id', $participant);
                        $this->db->update('participants', $data);
                    }
                }

                /*unset participant ID from session*/
                $this->session->unset_userdata('participant');
                redirect(base_url('manage'));

            }
        } else {
            redirect('https://goo.gl/forms/PNK8AxWBtvfMUatB3');
        }
    }

    public function boatPaymentConfirmation($participant = "")
    {

        $data = array(
            'participant' => $participant
        );

        $this->load->model('model_participant');
        $data['model_participant'] = $this->model_participant;
        $this->load->view('header');
        $this->load->view('controlnav');
        $this->load->view('content_boatPaymentConfirmation', $data);
        $this->load->view('footer');
    }

    public function insertBoatPaymentToDB()
    {
        $participant = $this->session->participant;

        $this->load->model('model_participant');

        $participantSection = $this->model_participant->get_participant_section($participant);   //to check if participant is LCs participant
        $lcSection = $this->session->section;


        if ($participantSection != $lcSection) {   //if you're being naughty, go to control panel
            redirect(base_url('manage'));
        } else {                                  //if everything is ok

            $boatfee = $this->input->post('boatfee');
            if ($boatfee == '40') {

                $data = array(
                    'trips' => 'Travel BOTH WAYS with the group'
                );

                $this->db->where('id', $participant);
                $this->db->update('participants', $data);
            } elseif ($boatfee == '20') {
                $data = array(
                    'trips' => 'Travel WITH THE GROUP to Crete and return INDIVIDUALLY'
                );

                $this->db->where('id', $participant);
                $this->db->update('participants', $data);

            } elseif ($boatfee == '21') {
                $data = array(
                    'trips' => 'Travel INDIVIDUALLY to Crete and return WITH THE GROUP'
                );

                $this->db->where('id', $participant);
                $this->db->update('participants', $data);
            }
            if ($boatfee == '21') {
                $boatfee = '20';
            }
            $this->load->model('model_event');


            /* Enter payment to database*/
            $data = array(
                'ticketspayment' => $boatfee
            );

            $this->db->where('id', $participant);
            $this->db->update('participants', $data);


            /*unset participant ID from session*/
            $this->session->unset_userdata('participant');
            redirect(base_url('manage'));

        }
    }

    public function commentOnParticipant($participant = "")
    {

        $data = array(
            'participant' => $participant
        );

        $this->load->model('model_participant');
        $data['model_participant'] = $this->model_participant;
        $this->load->view('header');
        $this->load->view('controlnav');
        $this->load->view('content_addComment', $data);
        $this->load->view('footer');
    }

    public function insertCommentToDB()
    {
        $participant = $this->session->participant;

        $this->load->model('model_participant');

        $participantSection = $this->model_participant->get_participant_section($participant);   //to check if participant is LCs participant
        $lcSection = $this->session->section;


        if ($participantSection != $lcSection) {   //if you're being naughty, go to control panel
            redirect(base_url('manage'));
        } else {                                  //if everything is ok


            /* Enter comment to database*/
            $data = array(
                'glcomments' => $this->input->post('comments')
            );

            $this->db->where('id', $participant);
            $this->db->update('participants', $data);


            /*unset participant ID from session*/
            $this->session->unset_userdata('participant');
            redirect(base_url('manage'));

        }
    }

    public function participant($participant = "")
    {

        $data = array(
            'participant' => $participant
        );
        $this->load->model('model_participant');
        $participantSection = $this->model_participant->get_participant_section($participant);
        $lcSection = $this->session->section;
        if ($participantSection != $lcSection) {
            header("Refresh:0,url=/manage");
        } else {

            $this->load->model('model_participant');
            $data['model_participant'] = $this->model_participant;
            $this->load->view('header');
            $this->load->view('controlnav');
            $this->load->view('content_participant', $data);
            $this->load->view('footer');
        }
    }

    public function resetParticipantPassword($participant = "")
    {
        if ($this->session->type == "demigod") {

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
            redirect('manage');
        }

    }

    public function newParticipantPassword($participant = "")
    {
        if ($this->session->type == "demigod") {

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
            redirect('manage');
        }
    }

    public function bankAndUpload()
    {
        /*$this->load->view('upload_form', array('error' => ' ' ));*/
        if ($this->session->is_logged_in == TRUE && $this->session->type == 'demigod') {

            $data['error'] = ' ';
            $this->load->model('model_section');
            $data['model_section'] = $this->model_section;

            $this->load->view('header');
            $this->load->view('controlnav');
            $this->load->view('content_uploadProofOfPayment', $data);
            $this->load->view('footer');

        } else {
            redirect(base_url('manage'));
        }
    }

    public function do_upload()
    {
        if ($this->session->is_logged_in == TRUE && $this->session->type == 'demigod') {
            $config['upload_path'] = './proofs_of_payment/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 0;
            $config['max_width'] = 10240;

            $this->load->library('upload', $config);

            $this->form_validation->set_rules("amount", "Amount", "required|trim|max_length[200]|numeric|xss_clean");
            $this->form_validation->set_rules("participants", "Paying for participants", "required|trim|max_length[200]|xss_clean");
            $this->form_validation->set_rules("comments", "Comments", "xss_clean");

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = ' ';
                $this->load->model('model_section');
                $data['model_section'] = $this->model_section;

                $this->load->view('header');
                $this->load->view('controlnav');
                $this->load->view('content_uploadProofOfPayment', $data);
                $this->load->view('footer');
            } else {
                if (!$this->upload->do_upload()) {

                    $data['error'] = $this->upload->display_errors();
                    $this->load->model('model_section');
                    $data['model_section'] = $this->model_section;

                    $this->load->view('header');
                    $this->load->view('controlnav');
                    $this->load->view('content_uploadProofOfPayment', $data);
                    $this->load->view('footer');


                } else {

                    $database_entry = array(
                        'path' => '/proofs_of_payment/' . $this->upload->data('file_name'),
                        'amount' => $this->input->post('amount'),
                        'participants' => $this->input->post('participants'),
                        'comments' => $this->input->post('comments'),
                        'esnsection' => $this->session->section

                    );

                    $this->load->model('model_section');

                    if ($query = $this->model_section->enterProofOfPaymentIntoDatabase($database_entry)) {

                        //Send confirmation email

                        $this->email->set_mailtype("html");
                        $this->email->from('do-not-reply@thecretetrip.org', 'The Crete Trip 2017 System');
                        $this->email->to('finance@thecretetrip.org');  //send mail to treasurer
                        $this->email->cc('section-c@thecretetrip.org'); //cc sections coordinator
                        $this->email->bcc('it@esngreece.gr'); //bcc IT Systems Manager
                        $this->email->subject('New proof of payment uploaded by ' . $this->session->section);
                        $this->email->message('
                <p>Dear Treasurer,</p>

<p>There is a new proof of payment uploaded by ' . $this->session->section . '.</p>

<p>Please review it in the <b><a href="https://registrations.thecretetrip.org/godmode">Godmode Panel</a></b></p>

<p>The form submission is:</p>

<p>Section: ' . $this->session->section . '<br>
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
                        $data['error'] = '<h3 style="color: green;">Your file was uploaded successfully</h3>';


                        $this->load->view('header');
                        $this->load->view('controlnav');
                        $this->load->view('content_uploadProofOfPayment', $data);
                        $this->load->view('footer');
                    } else {
                        echo "Database error";
                    }
                }
            }
        } else {
            redirect(base_url('manage'));
        }
    }


    public function changePassword()
    {


        $this->form_validation->set_rules("password", "Password", "required|min_length[5]|max_length[200]|xss_clean");
        $this->form_validation->set_rules("passwordConfirmation", "Password confirmation", "required|matches[password]|max_length[200]|xss_clean");

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('controlnav');
            $this->load->view('content_changePassword');
            $this->load->view('footer');
        } else {

            //update password in the database
            $this->load->model('model_localadmin');
            $this->model_localadmin->changePassword();
        }

    }


}