<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-2">
            <h1>My Account</h1>
        </div>
    </div>

    <?php if ($this->session->is_logged_in == TRUE && $this->session->type == 'mortal') { //if user is logged in?>
        <div class="row">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-6">
                <?php
                echo "<h2>Banking details and proof of payment</h2>";
                echo "<p><b>Here you can see the bank account details and you can upload your proof of payment</b></p>"; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
            </div>
            <div class="col-sm-3">
                <h3>Upload a proof of payment:</h3>
                <?php echo $error; ?>

                <?php echo form_open_multipart('account/do_upload'); ?>

                <div class="form-group">

                    <?php

                    echo form_label('Upload your file: *', 'upload');
                    echo '<h6>Formats accepted: <b>jpg,jpeg,png,pdf</b></h6>';
                    echo form_error('upload', '<div style="color:red;">', '</div>');
                    ?>
                    <input type="file" id = "upload" name="userfile" size="20"/>
                </div>

                <div class="form-group">
                    <?php

                    echo form_label('Amount: *', 'amount');
                    echo '<h6>Enter the amount that is written on your proof of payment in <b>NUMBERS</b></h6>';
                    echo form_error('amount', '<div style="color:red;">', '</div>');

                    $data = array(
                        "name" => "amount",
                        "id" => "amount",
                        "placeholder" => "eg. 135",
                        "class" => "form-control",
                        "value" => set_value("amount"),
                    );

                    echo form_input($data);
                    ?>
                </div>

                <div class="form-group">
                    <?php

                    echo form_label('Comments:', 'Comments');
                    echo "<h6>Any comments?</h6>";
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

                <input class="btn btn-success" type="submit" value="Submit proof of payment"/>
                <a href="<?php echo base_url('account'); ?>" class="btn btn-danger"
                   role="button">Back</a>
                </form>

            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-3">
                <h3>Bank Details:</h3>
                <h5>Account No: <b>GR10 0140 7880 7880 0200 2012 700</b></h5>
                <h5>Bank Name: <b>ALPHA BANK</b></h5>
                <h5>SWIFT: <b>CRBAGRAA</b></h5>
                <h5>Beneficiary Name: <b>AFOI STEFANAKI O.E. - BACCARA HOLIDAY SERVICES</b></h5>
                <h4>Reference: <b style="color: red"><?php echo $model_participant->getDepositReference($this->session->email); ?></b></h4>
            </div>
        </div>
        <?php
    } else { //if user is not logged in
        echo redirect(base_url('account'));
    } ?>
</div>
