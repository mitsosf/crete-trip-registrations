<div class="container-fluid"
<div class="row" style="margin-bottom: 100px">
    <div class="col-sm-2">

    </div>
    <div class="col-sm-7">


        <p style="text-align: center"><h1><b>Register for The Crete Trip 2017!</b></h1></p>
    </div>
</div>

<div class="row">
    <div class="hidden-xs col-sm-2">


    </div>
    <?php echo form_open("");
    ?>
    <div class="container-fluid">
        <div class="col-sm-3 ">


            <div class="form-group">
                <?php

                echo form_label('Name: *', 'name');
                echo form_error('name', '<div style="color:red;">', '</div>');
                $data = array(
                    "name" => "name",
                    "id" => "name",
                    "placeholder" => "Name",
                    "class" => "form-control",
                    "value" => set_value("name"),
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Surname: *', 'surname');
                echo form_error('surname', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "surname",
                    "id" => "surname",
                    "placeholder" => "Surname",
                    "class" => "form-control",
                    "value" => set_value("surname"),
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Email: *', 'email');
                echo form_error('email', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "email",
                    "id" => "email",
                    "placeholder" => "Email",
                    "class" => "form-control",
                    "value" => set_value("email"),
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Password: *', 'password');
                echo "<h6>Use at least 5 characters. Will be used to access your account later</h6>";
                echo form_error('password', '<div style="color:red;">', '</div>');
                $data = array(
                    "name" => "password",
                    "id" => "password",
                    "type" => "password",
                    "placeholder" => "Password",
                    "class" => "form-control",
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Password confirmation: *', 'passconf');
                echo form_error('passwordconf', '<div style="color:red;">', '</div>');
                $data = array(
                    "name" => "passwordconf",
                    "id" => "passwordconf",
                    "type" => "password",
                    "placeholder" => "Password confirmation",
                    "class" => "form-control",
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('ID/Passport: *', 'idorpassport');
                echo "<h6>It is only going to be used during the check-in at the hotel</h6>";
                echo form_error('idorpassport', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "idorpassport",
                    "id" => "idorpassport",
                    "placeholder" => "ID / Passport",
                    "class" => "form-control",
                    "value" => set_value("idorpassport"),
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Date of birth: *', 'dateofbirth');
                echo "<h6>Please use the <b><i>dd/mm/yyyy</i></b> format</h6>";
                echo form_error('dateofbirth', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "dateofbirth",
                    "id" => "dateofbirth",
                    "placeholder" => "Date of birth",
                    "class" => "form-control",
                    "value" => set_value("dateofbirth"),
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Gender: *', 'gender');
                echo form_error('gender', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "gender",
                    "id" => "gender",
                    "placeholder" => "Gender",
                    "class" => "form-control",
                    "value" => set_value("gender"),
                );

                $genders = array(
                    "0" => " ",
                    "Male" => "Male",
                    "Female" => "Female",
                );

                echo form_dropdown($data, $genders);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Phone number: *', 'phone');
                echo "<h6>Please enter a <b>GREEK</b> phone number, if you have one. Your group leader in Crete may need a way to contact you</h6>";
                echo form_error('phone', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "phone",
                    "id" => "phone",
                    "placeholder" => "Phone Number",
                    "class" => "form-control",
                    "value" => set_value("phone"),
                );

                echo form_input($data);
                ?>
            </div>


            <div class="form-group">
                <?php

                echo form_label('Country: *', 'country');
                echo "<h6>What is your nationality?</h6>";
                echo form_error('country', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "country",
                    "id" => "country",
                    "placeholder" => "Country",
                    "class" => "form-control",
                    "value" => set_value("country"),
                );


                echo form_dropdown($data, $countries);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('City studying in Greece: *', 'city');
                echo "<h6>Please enter the city you currently study in, Greece or Cyprus. If you are an <b>International ESNer guest</b>, tell us your city of residence.</h6>";
                echo form_error('city', '<div style="color:red;">', '</div>');
                $data = array(
                    "name" => "city",
                    "id" => "city",
                    "placeholder" => "City studying in Greece or Cyprus",
                    "class" => "form-control",
                    "value" => set_value("city"),
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('ESN Section: *', 'esnsection');
                echo "<h6>Choose the ESN Section of the University you are studying in. Choose ESN Cyprus if you are an Erasmus student in Cyprus. Choose No ESN Section if you are studying in a city in Greece which does not have ESN Section. Choose International Guest ESNer if you are an ESNer from another country. Choose Erasmus Guest if you are Erasmus in another country (neither Greece nor Cyprus). If you are a friend of an Erasmus student studying in Greece or Cyprus, choose your friend's ESN Section.</h6>";
                echo form_error('esnsection', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "esnsection",
                    "id" => "esnsection",
                    "placeholder" => "ESN Section",
                    "class" => "form-control",
                    "value" => set_value("esnsection"),
                );


                echo form_dropdown($data, $sections);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Transportation TO/FROM Crete: *', 'trips');
                echo form_error('trips', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "trips",
                    "id" => "trips",
                    "placeholder" => "Transportation TO/FROM Crete",
                    "class" => "form-control",
                    "value" => set_value("trips"),
                );

                $trips = array(
                    "0" => " ",
                    "Travel BOTH WAYS with the group" => "Travel BOTH WAYS with the group",
                    "Travel WITH THE GROUP to Crete and return INDIVIDUALLY" => "Travel WITH THE GROUP to Crete and return INDIVIDUALLY",
                    "Travel INDIVIDUALLY to Crete and return WITH THE GROUP" => "Travel INDIVIDUALLY to Crete and return WITH THE GROUP",
                    "Travel BOTH WAYS INDIVIDUALLY" => "Travel BOTH WAYS INDIVIDUALLY",
                    "I study in Crete" => "I study in Crete",
                );

                echo form_dropdown($data, $trips);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('T-Shirt size: *', 'tshirtsize');
                echo form_error('tshirtsize', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "tshirtsize",
                    "id" => "tshirtsize",
                    "placeholder" => "T-Shirt Size",
                    "class" => "form-control",
                    "value" => set_value("tshirtsize"),

                );

                $sizes = array(     //array with t-shirt sizes
                    "0" => " ",
                    "XS" => "XS",
                    "S" => "S",
                    "M" => "M",
                    "L" => "L",
                    "XL" => "XL",
                    "XXL" => "XXL",
                );

                echo form_dropdown($data, $sizes);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Facebook profile URL:', 'facebook');
                echo "<h6>Enter your facebook profile URL so that you can be contacted by you group leaders</h6>";
                echo form_error('facebook', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "facebook",
                    "id" => "facebook",
                    "placeholder" => "Facebook Profile URL",
                    "class" => "form-control",
                    "value" => set_value("facebook"),
                );

                echo form_input($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Allergies/Food restrictions:', 'allergies');
                echo "<h6>If you have any known allergies or any food restrictions, please let us know</h6>";
                echo form_error('allergies', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "allergies",
                    "id" => "allergies",
                    "placeholder" => "Allergies",
                    "class" => "form-control",
                    "rows" => "2",
                    "value" => set_value("allergies"),
                );

                echo form_textarea($data);
                ?>
            </div>

            <div class="form-group">
                <?php

                echo form_label('Comments:', 'Comments');
                echo "<h6>Any additional comments for the Organising Committee or your Group Leader</h6>";
                echo form_error('comments', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "comments",
                    "id" => "comments",
                    "placeholder" => "Comments",
                    "class" => "form-control",
                    "rows" => "2",
                    "value" => set_value("comments"),
                );

                echo form_textarea($data);
                ?>
            </div>

            <?php echo form_label('reCAPTCHA verification:', 'g-recaptcha'); ?>
            <?php echo form_error('g-recaptcha-response', '<div style="color:red;">', '</div>'); ?>
            <div class="g-recaptcha" data-sitekey="6LfbXxYUAAAAAKuLEwDTx_AT4UqL9TdYeztWnc5K"></div>


            <h6>By submitting this form, I declare that I have read and agree to the <a target="_blank"
                                                                                        href="<?php echo base_url('terms'); ?>"><u>Terms
                        & Conditions</u></a></h6>
            <div class="form-group">
                <?php

                $data = array(
                    "name" => "submit",
                    "id" => "submit",
                    "value" => "Submit",
                    "class" => "btn btn-success",
                );

                echo form_submit($data);
                ?>
            </div>
        </div>
        <?php
        echo form_close();

        ?>
        <div class="col-sm-2">

        </div>
        <div class=" col-sm-4">

<!--            <h4 style="text-align: center">Registrations so far:</h4>-->
            <h2 style="text-align: center;margin-bottom: 5%;color:red"><?php /*echo $numOfRegistrations*/?></h2>

           <!-- <h4 style="text-align: center">Registrations end in:</h4>
            <h2 style="text-align: center;margin-bottom: 5%;color: red" id = "endOfReg"></h2>-->

            <h4 style="text-align: center" ">Our sponsors:</h4>
            <a href="https://esn.org/responsible-party" target="_blank"><img src="assets/images/logos/rp-logo.png"
                                                                             alt="Responsible Party" height="50%"
                                                                             width="50%"
                                                                             style="margin-left: 25%"></a>
            <a href="https://www.eurosender.com/" target="_blank"><img src="assets/images/logos/eurosender-logo.png"
                                                                       alt="Eurosender" height="50%" width="50%"
                                                                       style="margin-left: 25%"></a>
            <a href="http://www.vodafonecu.gr/en/" target="_blank"><img src="assets/images/logos/cu-logo.jpg"
                                                                        alt="Vodafone CU" height="50%" width="50%"
                                                                        style="margin-left: 25%"></a>

        </div>
    </div>

</div>
