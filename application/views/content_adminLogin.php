<div id="content">
    <h1>Login</h1>

    <?php

    echo form_open("manage");
    ?>

    <div class="form-group">
        <?php

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

    <?php echo form_error('g-recaptcha-response', '<div style="color:red;">', '</div>'); ?>
    <div class="g-recaptcha" data-sitekey="6LfbXxYUAAAAAKuLEwDTx_AT4UqL9TdYeztWnc5K"></div>

    <div class="form-group">
        <?php

        $data = array(
            "name" => "submit",
            "id" => "submit",
            "value" => "Login",
            "class" => "btn btn-info",
        );

        echo form_submit($data);
        ?>
    </div>



    <?php
    echo form_close();

    ?>



</div>
