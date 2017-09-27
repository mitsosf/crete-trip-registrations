</body>
<footer class="footer">
    <script>
        document.getElementById("user").innerHTML = ' <?php echo $this->session->userdata("section"); ?>';
    </script>
    <script src="assets/scripts/countdownTimer.js"></script>

    <div align="middle" id="footer">
        <p>Copyright © 2017 The Crete Trip. Implemented by <a
                    href="https://www.linkedin.com/in/frangiadakisdimitris">Dimitris
                Frangiadakis</a> of <a href="https://www.facebook.com/esnharo">ESN Haro.</a></p>
    </div>
</footer>

</html>