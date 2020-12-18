<?php

include('service.php');

?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="images/JAKEtv_flav.png">
<title>Jake TV</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
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
					<!--<div class="container">-->
						<div class="row" id="login_page">
							<form name="login_form" method="post">
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><input type="email" id="login_email" name="email" value="" placeholder="Email" class="form-control input-lg" /></div>
                                <div class="col-sm-4"></div><br>
							</div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><input type="password" id="login_pass" name="password" value="" placeholder="Password" class="form-control input-lg" /></div>
                                <div class="col-sm-4"></div><br>
							</div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><button type="submib" name="login" id="login_button" class="form-control input-lg btn btn-default">SIGN IN</button></div>
                                <div class="col-sm-4"></div><br>
							</div>
                            <br>
                             <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><center>Or</center></div>
                                <div class="col-sm-4"></div><br>
							</div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><button type="submit" id="login_google_button" class="form-control input-lg btn btn-default">Sign In With Google+</button></div>
                                <div class="col-sm-4"></div><br>
							</div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><a href="" id="login_forgot">Forgot Password ?</a></div>
                                <div class="col-sm-4"></div><br>
							</div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><a href="register.php" id="login_register">Don't Have an Account? Register</a></div>
                                <div class="col-sm-4"></div><br>
							</div>
                            </form>
                            <br><br>
                        </div>
                        
					<!--</div>-->
				</div>
			<!--welcome-->
			</div>
			<!--footer-->
            
   <div class="footer-section" id="footerhr">
    <div class="footer-top">
    <p>&copy; 2015 JAKE TV. All rights reserved</p>
    </div>
    </div>
			<!--<div class="footer-section">
				<div class="container">
					<div class="footer-top">
						<p>&copy; 2015 JAKE TV. All rights reserved</p>
					</div>
				</div>
			</div>-->
</body>
</html>
