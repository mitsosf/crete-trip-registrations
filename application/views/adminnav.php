<body>
<div id="container">


    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">The Crete Trip Registrations</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo base_url('terms'); ?>">Terms & Conditions</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i><b id="user"></b><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="godmode/changePassword">Change password</a></li>
                        </ul>
                    </li>
                    <li><a href=""><i class="glyphicon glyphicon-time"></i><b id="countdown"></b>
                    <li><a href="<?php echo base_url('godmode') . "/logout"; ?>" "><i
                                class="glyphicon glyphicon-off"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

    <script>    //script for session countdown
        // Set the date we're counting down to


        var countDownDate = new Date().getTime() + parseInt(<?php echo $this->config->item('sess_expiration') . '000';?>);


        // Update the count down every 1 second
        var x = setInterval(function () {

            // Get todays date and time
            var now = new Date().getTime();


            // Find the distance between now an the count down date
            var distance = countDownDate - now;

            // Time calculations for minutes and seconds
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            // Output the result in the element with id="countdown"
            if (minutes < 10 && seconds < 10) {
                document.getElementById("countdown").innerHTML = " 0" + minutes + ":0" + seconds;
            }
            else if (minutes >= 10 && seconds < 10) {
                document.getElementById("countdown").innerHTML = " " + minutes + ":0" + seconds;
            }
            else if (minutes < 10 && seconds >= 10) {
                document.getElementById("countdown").innerHTML = " 0" + minutes + ":" + seconds;
            }
            else if (minutes >= 10 && seconds >= 10) {
                document.getElementById("countdown").innerHTML = " " + minutes + ":" + seconds;
            }
            else {
                document.getElementById("countdown").innerHTML = " " + minutes + ":" + seconds;
            }

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "Session expired";
            }
        }, 500);
    </script>

