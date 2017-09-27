<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-4">
            <h1>Random room</h1>
        </div>

    </div>
    <div class="row" style="margin-bottom: 50px">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h3>Join random room</h3>
            <p>Don't know anyone, all your friends are taken or your desired room-type is unavailable? Here you can join a random room. If you have any preferences, regarding being matched with
                other participants that have also selected the random room option, please say so in the comments field below!</p>
            <p>We will try our best to match you with the most suitable people, but even if you ask for specific roommates, we cannot guarantee that you will be assigned a room with them.</p>
            <p>If you have any questions or encounter any problems, don't hesitate to contact the Sections Coordinator by email here: <br><a href="mailto:section-c@thecretetrip
            .org">section-c@thecretetrip.org</a></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-2">
            <?php echo form_open("rooming/randomroomconfirmation");
            ?>
            <div class="form-group">
                <?php

                echo form_label('Comments:', 'Comments');
                echo "<h6>Please give us the full names of your desired roommates and tell them to do the same!</h6>";
                echo form_error('comments', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "comments",
                    "id" => "comments",
                    "placeholder" => "e.g Jon Snow, Tyrion Lannister",
                    "class" => "form-control",
                    "rows" => "2",
                    "value" => set_value("comments"),
                );

                echo form_textarea($data);
                ?>
            </div>
        </div>
        <div class="col-sm-2" style="margin-top: 4%">
            <div class="form-group">
                <?php

                $data = array(
                    "name" => "submit",
                    "id" => "submit",
                    "value" => "Join Random Room",
                    "class" => "btn btn-warning",
                );

                echo form_submit($data);
                ?>
            </div>
            <?php
            echo form_close();

            ?>
        </div>
    </div>
    <div class="row" style="margin-top: 5%;">
        <div class="col-sm-5"></div>
        <div class="col-sm-2"><a href="<?php echo base_url('rooming') ?>" class="btn btn-danger" role="button">Back</a></div>
    </div>
</div>
