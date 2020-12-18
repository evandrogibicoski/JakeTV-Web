<?php

include('service.php');
include('secure/customjs.php');

?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="images/JAKEtv_flav.png">
<title>Jake TV</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,800' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Zoo Planet Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</head>
<body>
<div class="header">
  <?php
include('header.php'); 
?>
</div>

<!--welcome-->
<div class="content">
  <div class="welcome"> 
		<div class="row" id="register_page">
        	<form name="register_form" method="post">
        	<div class="row">
            	<div class="col-md-3"></div>
                <div class="col-md-2"><center><a href="login.php" id="reg_cancel">Cancel</a></center></div>
                <div class="col-md-2" id="reg_register"><center>Register</center></div>
                <div class="col-md-2"><center><span id="reg_join" onClick="register_join()">Join</span></center></div>
                <div class="col-md-3"></div>
            </div>
            <br>
            <div id="reg_validation"></div>
            <br>
            <div class="row">
            	<div class="col-md-3"></div>
                <div class="col-md-6"><input type="text" id="reg_f_name" name="f_name" value="" placeholder="First Name" class="form-control input-lg" /></div>
                <div class="col-md-3"></div>
            </div>
            <br>
            <div class="row">
            	<div class="col-md-3"></div>
                <div class="col-md-6"><input type="text" id="reg_l_name" name="l_name" value="" placeholder="Last Name" class="form-control input-lg" /></div>
                <div class="col-md-3"></div>
            </div>
            <br>
            <div class="row">
            	<div class="col-md-3"></div>
                <div class="col-md-6"><input type="email" id="reg_email" name="email" value="" placeholder="Email" class="form-control input-lg" /></div>
                <div class="col-md-3"></div>
            </div>
            <br>
            <div class="row">
            	<div class="col-md-3"></div>
                <div class="col-md-6"><input type="password" id="reg_password" name="password" value="" placeholder="Password" class="form-control input-lg" /></div>
                <div class="col-md-3"></div>
            </div>
            <br>
            <div class="row">
            	<div class="col-md-3"></div>
                <div class="col-md-6"><input type="password" id="reg_c_password" name="c_password" value="" placeholder="Confirm Password" class="form-control input-lg" /></div>
                <div class="col-md-3"></div>
            </div>
            </form>
        </div>
    	<br><br><br>
  </div>
</div>
<div class="footer-section" id="footerhr">
<div class="footer-top">
<p>&copy; 2015 JAKE TV. All rights reserved</p>
</div>
</div>
</body>
</html>
