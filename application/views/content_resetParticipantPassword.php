<div id="content">
    <?php if ($this->session->type == "god") { //if user is logged in as god

        /*check if participant is member of the section*/

        $this->session->set_userdata('participant', $participant);     //set userID to session, to use for database inserting

        echo "<h1> Reset Pass Confirmation</h1>";
        echo "<p>Are you sure you want to reset the pass of the participant <b>" . $model_participant->get_participant_Name($participant) . "</b> ?</p>"; ?>
        <?php
        echo form_open("godmode/newParticipantPassword/" . $participant); ?>
        <div class="row">
            <div class="col-sm-1">
                <div class="form-group">
                    <?php

                    $data = array(
                        "name" => "submit",
                        "id" => "submit",
                        "value" => "Validate",
                        "class" => "btn btn-success",
                    );

                    echo form_submit($data);
                    ?>
                </div>
            </div>


            <?php
            echo form_close();

            ?>
            <div class="col-sm-1">
                <a href="<?php echo base_url('godmode/resetPasswords'); ?>" class="btn btn-danger"
                   role="button">Cancel</a>
            </div>
        </div>
        <?php

    }
    if (($this->session->type == "demigod")) {  //load for local coordinators
        /*check if participant is member of the section*/


        $participantRealSection = $model_participant->get_participant_Section($participant);
        $lcsection = $this->session->section;

        if ($participantRealSection != $lcsection) {    //if someone was being naughty
            redirect(base_url('manage'));           //redirect to control panel
        } else {
            $this->session->set_userdata('participant', $participant);     //set userID to session, to use for database inserting
            echo "<h1> Reset Pass Confirmation</h1>";
            echo "<p>Are you sure you want to reset the pass of the participant <b>" . $model_participant->get_participant_Name($participant) . "</b> ?</p>"; ?>
            <?php
            echo form_open("manage/newParticipantPassword/" . $participant); ?>
            <div class="row">
                <div class="col-sm-1">
                    <div class="form-group">
                        <?php

                        $data = array(
                            "name" => "submit",
                            "id" => "submit",
                            "value" => "Validate",
                            "class" => "btn btn-success",
                        );

                        echo form_submit($data);
                        ?>
                    </div>
                </div>


                <?php
                echo form_close();

                ?>
                <div class="col-sm-1">
                    <a href="<?php echo base_url('manage'); ?>" class="btn btn-danger" role="button">Cancel</a>
                </div>
            </div>
            <?php
        }
    } else { //if user is not logged in
            echo redirect(base_url('manage'));
    } ?>
</div>
