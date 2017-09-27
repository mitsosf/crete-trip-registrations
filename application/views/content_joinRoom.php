<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-4">
            <h1>Join room</h1>
        </div>

    </div>
    <div class="row" style="margin-bottom: 50px">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h3>Join existing room</h3>
            <p>Here you can join a room that has already been created by another participant. Please ask them to log in to their account and give you the <b style="color: red">room's id</b> AND
                <b style="color: red"> 6-digit code</b></p>
            <p>If you have the room's id and 6-digit code, please enter them in the fields below.</p>
            <p>If you have any questions or encounter any problems, don't hesitate to contact the Sections Coordinator by email here: <br><a href="mailto:section-c@thecretetrip.org">section-c@thecretetrip.org</a>
            </p>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6" style="color: red"><b><?php echo $message;?></b></div></div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-1">
            <?php echo form_open("rooming/joinroomconfirmation");
            ?>
            <div class="form-group">
                <?php

                echo form_label('Room ID: *', 'id');
                echo form_error('id', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "id",
                    "id" => "id",
                    "maxlength" => "4",
                    "placeholder" => "eg. 34",
                    "class" => "form-control",
                    "value" => set_value("id"),
                );

                echo form_input($data);
                ?>
            </div>
        </div>
        <div class="col-sm-1">
            <div class="form-group">
                <?php

                echo form_label('Code: *', 'code');
                echo form_error('code', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "code",
                    "id" => "code",
                    "maxlength" => "6",
                    "placeholder" => "eg. 123456",
                    "class" => "form-control",
                    "value" => set_value("code"),
                );

                echo form_input($data);
                ?>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group" style="margin-top: 8%">
                <?php

                $data = array(
                    "name" => "submit",
                    "id" => "submit",
                    "value" => "Join Room",
                    "class" => "btn btn-success",
                );

                echo form_submit($data);
                ?>
            </div>
        </div>
        <?php
        echo form_close();

        ?>
    </div>
    <div class="row" style="margin-top: 5%;">
        <div class="col-sm-5"></div>
        <div class="col-sm-2"><a href="<?php echo base_url('rooming')?>" class="btn btn-danger" role="button">Back</a></div>
    </div>
</div>
