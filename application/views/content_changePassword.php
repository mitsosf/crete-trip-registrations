<div class="row">
    <div class="col-sm-3">

    </div>
    <div class="col-sm-3">
        <h1>Change password</h1>

        <?php

        echo form_open("");
        ?>

        <div class="form-group">
            <?php

            echo form_label('Password: ', 'password');
            echo "<h6>Use at least 5 characters</h6>";
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

            echo form_label('Password confirmation: ', 'passwordConfirmation');
            echo form_error('passwordConfirmation', '<div style="color:red;">', '</div>');
            $data = array(
                "name" => "passwordConfirmation",
                "id" => "passwordConfirmation",
                "type" => "password",
                "placeholder" => "Re-enter password",
                "class" => "form-control",
            );

            echo form_input($data);
            ?>
        </div>

        <div class="form-group">
            <?php

            $data = array(
                "name" => "submit",
                "id" => "submit",
                "value" => "Submit",
                "class" => "btn btn-info",
            );

            echo form_submit($data);
            ?>
        </div>


        <?php
        echo form_close();

        ?>

    </div>

</div>