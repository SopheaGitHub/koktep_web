<!DOCTYPE html>
<html>
<title>KOKTEP</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="<?php echo asset('/javascript/jquery/jquery-2.1.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo asset('/javascript/jquery/timer/jquery.countdownTimer.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo asset('/javascript/jquery/timer/jquery.countdownTimer.css'); ?>">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
body,h1 {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
    background-image: url('images/background_coming_soon.jpg');
    min-height: 100%;
    background-position: center;
    background-size: cover;
}
.size_lg {
    font-size: 20px;
    border-width: 5px;
    border-radius: 5px;
    padding: 5px;
    opacity: 0.5;
}
</style>
<body>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
  <div class="w3-display-topleft w3-padding-large w3-xlarge">
    <img src="<?php echo url('images/logo_koktep_v2.png'); ?>" width="50%">
  </div>
  <div class="w3-display-middle">
    <h1 class="w3-jumbo w3-animate-top">COMING SOON</h1>
    <hr class="w3-border-grey" style="margin:auto;width:40%">
    <p class="w3-large w3-center" style="text-align:center;">
      <?php
        // $date = strtotime("September 17, 2017 00:00:00");
        // $remaining = $date - time();
        // $days_remaining = floor($remaining / 86400);
        // $hours_remaining = floor(($remaining % 86400) / 3600);
        // echo "There are $days_remaining days and $hours_remaining hours left";
      ?>
    </p>
    <div style="text-align:center;">
      <div>
                            <p id="future_date"></p>


                            <script>
                                $(function(){
                                    $('#future_date').countdowntimer({
                                        dateAndTime : "2017/09/18 00:00:00",
                                        size : "lg",
                                        regexpMatchFormat: "([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})",
                regexpReplaceWith: "$1<sup class='displayformat'>days</sup> / $2<sup class='displayformat'>hours</sup> / $3<sup class='displayformat'>minutes</sup> / $4<sup class='displayformat'>seconds</sup>"
                                    });
                                });
                            </script>
                        </div>
    </div>
  </div>
  <div class="w3-display-middle"><h3>Need a place to show case your work! </h3></div>
  <div class="w3-display-bottomleft w3-padding-large">
    Powered by www.koktep.com
  </div>
</div>

</body>
</html>