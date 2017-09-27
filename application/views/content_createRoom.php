<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-4">
            <h1>Rooming Platform</h1>
        </div>

    </div>
    <div class="row" style="margin-bottom: 50px">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h3>Create Room</h3>
            <p>Here you can create a new room. Please fill in all the fields below.</p>
            <p><b style="color: red">You are reminded that your room WILL ONLY BE FINAL WHEN IT'S FULL OF OCCUPANTS. If by the end of the rooming process the room is not full, you will be randomly
                    assigned to a room.</b></p>
            <p>e.g. If you create a room for 3 participants, the process will only be finished when the third participant joins the room.</p>
            <p>If you have any questions or encounter any problems, don't hesitate to contact the Sections Coordinator
                by email here: <br><a href="mailto:section-c@thecretetrip.org">section-c@thecretetrip.org</a>
            </p>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-2">
            <?php echo form_open("rooming/createroomconfirmation");
            ?>

            <div class="form-group">
                <?php

                echo form_label('No of beds: *', 'beds');
                echo "<h6>Choose between the available room types:</h6>";
                echo form_error('beds', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "beds",
                    "id" => "beds",
                    "placeholder" => "Beds",
                    "class" => "form-control",
                    "value" => set_value("beds"),

                );


                //TODO make dynamic
                $pid = $model_participant->get_participant_id_by_mail($this->session->userdata('email'));
                $section = $model_participant->get_participant_section($pid);
                $beds = array();
                $beds[0] = " ";
                if ($section == "ESN HARO") {
                    $hotel = "Marilena";
                    if ($model_event->getRoomAvailability($hotel, "2")) {
                        $beds[2] = 2;
                    }
                    if ($model_event->getRoomAvailability($hotel, "3")) {
                        $beds[3] = 3;
                    }
                    if ($model_event->getRoomAvailability($hotel, "4")) {
                        $beds[4] = 4;
                    }
                } elseif ($section == "ESN AEGEAN") {
                    $hotel = "Vanisko";
                    if ($model_event->getRoomAvailability($hotel, "2")) {
                        $beds[2] = 2;
                    }
                    if ($model_event->getRoomAvailability($hotel, "3")) {
                        $beds[3] = 3;
                    }
                    if ($model_event->getRoomAvailability($hotel, "4")) {
                        $beds[4] = 4;
                    }
                }

                echo form_dropdown($data, $beds);
                ?>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <?php

                echo form_label('Comments:', 'Comments');
                echo "<h6>Any additional comments:</h6>";
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
        </div>
        <div class="col-sm-2" style="margin-top: 3%;">
            <div class="form-group">
                <?php

                $data = array(
                    "name" => "submit",
                    "id" => "submit",
                    "value" => "Create Room",
                    "class" => "btn btn-success",
                );

                echo form_submit($data);
                ?>
            </div>

            <?php
            echo form_close();

            ?>

        </div>
    </div>
    <div class="row" style="margin-top: 3%">
        <div class="col-sm-3"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3" style="text-align: center">
            <a href="<?php echo base_url('rooming') ?>" style="text-align: center" class="btn btn-danger" role="button">Back</a>
        </div>
    </div>
</div>
