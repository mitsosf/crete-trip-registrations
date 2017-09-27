<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iamlate extends CI_Controller
{
    public function index()
    {

        $this->home();

    }

    public function home()
    {
        #Getting sections list
        //load the model_sections & model_countries
        $this->load->model("model_getsections");
        $this->load->model("model_getcountries");
        $this->load->model("model_participant");

        //call the model function to get the sections & countries data
        $sections = $this->model_getsections->getData();
        $countries = $this->model_getcountries->getData();
        $numOfRegistrations = $this->model_participant->get_number_of_registrations();


        $genderValidation = "Male,Female"; //string with Gender elements
        $tripsValidation = "Travel BOTH WAYS with the group,Travel WITH THE GROUP to Crete and return INDIVIDUALLY,Travel INDIVIDUALLY to Crete and return WITH THE GROUP,Travel BOTH WAYS INDIVIDUALLY,I study in Crete"; //string with Trips elements
        $tshirtValidation = "XS,S,M,L,XL,XXL"; //string with tshirt sizes
        $sectionsValidation = substr(implode(",", $sections), 2); //makes sense if you see how the Model_getsections is implemented :)
        $countriesValidation = trim(substr(implode(",", $countries), 2)); // same as above


        $this->form_validation->set_rules("name", "Name", "required|trim|max_length[200]|xss_clean");
        $this->form_validation->set_rules("surname", "Surname", "required|trim|max_length[200]|xss_clean");
        $this->form_validation->set_rules("email", "Email", "required|trim|strtolower|max_length[200]|valid_email|is_unique[participants.email]|xss_clean");
        $this->form_validation->set_rules("password", "Password", "required|min_length[5]|max_length[200]|xss_clean");
        $this->form_validation->set_rules("passwordconf", "Password confirmation", "required|matches[password]|max_length[200]|xss_clean");
        $this->form_validation->set_rules("idorpassport", "ID/Passport", "required|max_length[200]|xss_clean");
        $this->form_validation->set_rules("dateofbirth", "Date of Birth", "required|max_length[200]|xss_clean");
        $this->form_validation->set_rules("gender", "Gender", "required|in_list[$genderValidation]|xss_clean");
        $this->form_validation->set_rules("phone", "Phone number", "required|max_length[200]|xss_clean");
        $this->form_validation->set_rules("country", "Country", "required|trim|in_list[$countriesValidation]|xss_clean");
        $this->form_validation->set_rules("city", "City", "required|max_length[200]|xss_clean");
        $this->form_validation->set_rules("esnsection", "ESN Section", "required|trim|in_list[$sectionsValidation]|xss_clean");
        $this->form_validation->set_rules("trips", "Boat Trips to/from Crete", "required|in_list[$tripsValidation]|xss_clean");
        $this->form_validation->set_rules("tshirtsize", "T-Shirt size", "required|in_list[$tshirtValidation]|xss_clean");
        $this->form_validation->set_rules("dateofbirth", "Date of Birth", "max_length[200]|xss_clean");
        $this->form_validation->set_rules("facebook", "Facebook", "max_length[200]|xss_clean");
        $this->form_validation->set_rules("allergies", "Allergies", "xss_clean");
        $this->form_validation->set_rules("comments", "Comments", "xss_clean");
        //TODO fix captcha
        //$this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha'); //check for captcha


        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header');
            $this->load->view('nav');
            $this->load->view('content_register', ['sections' => $sections, 'countries' => $countries, 'numOfRegistrations' => $numOfRegistrations]);
            $this->load->view('footer');
        } else {

            $this->load->model('model_participant');
            if ($query = $this->model_participant->create_participant()) {
                //Send confirmation email

                //get Local Coordinator's email address
                $this->load->model('model_localadmin');
                $localcoordinator = $this->model_localadmin->getEmail($this->input->post('esnsection'));

                $this->email->set_mailtype("html");
                $this->email->from('oc@thecretetrip.org', 'The Crete Trip 2017 Organising Committee');
                $this->email->to($this->input->post('email'));  //send mail to participant
                $this->email->bcc($localcoordinator); //bcc local_coordinator
                $this->email->subject('Welcome to the Crete Trip!');
                $this->email->message('
                <p>Dear ' . $this->input->post('name') . ',</p>

<p>Thank you for registering for the Crete Trip 2017!!</p>

<p>Get ready to live the Peak-Moment of your Erasmus!</p>

<p><b><a href="http://m.me/TheCreteTrip?ref=Registered">Make sure to subscribe to the Official The Crete Trip Messenger bot for news and updates by clicking here!</a></b></p>

<p>Your form submission is:</p>

<p>Name: ' . $this->input->post('name') . '<br>
Surname: ' . $this->input->post('surname') . '<br>
Email: ' . $this->input->post('email') . '<br>
ID/Passport: ' . $this->input->post('idorpassport') . '<br>
Date of Birth: ' . $this->input->post('dateofbirth') . '<br>
Gender: ' . $this->input->post('gender') . '<br>
Phone Number: ' . $this->input->post('phone') . '<br>
Country: ' . $this->input->post('country') . '<br>
City: ' . $this->input->post('city') . '<br>
ESN Section: ' . $this->input->post('esnsection') . '<br>
Transportation to/from Crete: ' . $this->input->post('trips') . '<br>
T-shirt size: ' . $this->input->post('tshirtsize') . '<br>
Facebook profile URL: ' . $this->input->post('facebook') . '<br>
Allergies/Food restrictions: ' . $this->input->post('allergies') . '<br>
Comments: ' . $this->input->post('comments') . '
</p>

<p>If you submitted anything wrong send an e-mail to: it@esngreece.gr </p>

<p>If you have further questions, contact us here choosing the Registration category: http://thecretetrip.org/contact </p>

<p>Best wishes,</p>

<p>The Organising Committee of The Crete Trip 2017</p>
                ');

                $this->email->send();

                $this->load->view('header');
                $this->load->view('nav');
                $this->load->view('content_registrationSuccess');
                $this->load->view('footer');
            } else {

                echo "Database error";
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

}