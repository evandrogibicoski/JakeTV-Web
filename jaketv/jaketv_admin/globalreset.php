<?php
include("secure/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jake TV | ADMIN</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="shortcut icon" href="images/favjaketv.png" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/animate.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.block_innerdiv{background-image:url(images/loader.GIF);height:103px;width:100px;display:inline-block;z-index:1102;}
.block_outerdiv{width:100%;opacity:0.87;display:none;position:absolute;z-index:1102;
text-align:center;background-color:#E7E7E7;ackground-repeat:repeat;}
</style>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/jquery.form.js"></script>
<script language="javascript" type="text/javascript">
function loader_show()
{
	var v = jQuery(document).height();
	var wheight=jQuery(window).height();
	var wheight=parseInt(wheight)/parseInt(2);
	var scrolling = jQuery(window).scrollTop();
	var $marginTop = parseInt(wheight)+parseInt(scrolling)-parseInt(50);
	  
	var v2 = parseInt(v)-parseInt($marginTop);
	jQuery("#div_loader2").css({'margin-top': $marginTop});
	document.getElementById('div_loader').style.height=v+'px';
	jQuery('#div_loader').fadeIn();
}
  
function loader_hide()
{
	jQuery('#div_loader').fadeOut(1000);
}

function resetpassword()
{
	var new_pass = $("#new_pass").val();
	var cnf_pass = $("#cnf_pass").val();
	var adminid = $("#adminid").val();
	var email = $("#email").val();
	
	if(new_pass == "")
	{
		document.getElementById("error").innerHTML = "Please enter new password";
				setTimeout(function() { 
					document.getElementById("error").innerHTML = '';	
		}, 5000)
		return false;
	}
	else if(cnf_pass == "")
	{
		document.getElementById("error").innerHTML = "Please enter confirm password";
				setTimeout(function() { 
					document.getElementById("error").innerHTML = '';	
		}, 5000)
		return false;
	}
	else if(cnf_pass != new_pass)
	{
		document.getElementById("error").innerHTML = "Confirm password does not match";
				setTimeout(function() { 
					document.getElementById("error").innerHTML = '';	
		}, 5000)
		return false;
	}
	else
	{
		loader_show();
		$.ajax( {
			url : 'ajaxdata.php', 
			type : 'post',
			data: 'resetpass_admin=1&new_pass='+new_pass+'&adminid='+adminid+'&email='+email,				
			success : function(result) 
			{
				loader_hide();
				if(result==1)
				{
					$("#form-info").html("Your password reset successfully");
				}
				else
				{
					$("#error").html("Invalid authentication");
				}
			}
		});
	}
}
</script>
</head>
<body class="light_theme  fixed_header left_nav_fixed" style="background-color:#4b2121;">
	<!---AJAX LOADER--->
    <div class="block_outerdiv" id="div_loader">
    <div class="block_innerdiv" id="div_loader2"></div>
    </div>
    <!---AJAX LOADER--->
<div style="min-height: 657px; width: 100%; background: transparent url(images/admin_homepage_bg.png) no-repeat scroll center top / 100% auto;">
<div class="wrapper">
	<div class="panel-heading border" style="padding-left:8.1em;padding-top: 20px;">
        <div style="color:#a7dad3;font-size:40px;width:160px;float:left;"><img src="images/jakelogo.png" /></div>
        <div style="color:#FFFFFF;font-size:40px;width:160px;float:left;">ADMIN</div>
        
    </div>
    <div class="login_page">
    <div class="login_content">
    	<div class="panel-heading" style="background-color:transparent;color:#8E6464;">
        	<h3 class="panel-title">Reset Password</h3>
        </div>
    <div id="reloaddivdata">	
    <form action="" method="post" id="form-info" enctype="multipart/form-data" class="form-horizontal">
    	<div class="form-group" id="error" style="height:15px;color:#F00;font-size:16px;margin-top:-5px;"></div>
        <div class="form-group">
        <div class="col-sm-10">
        	<input type="password" id="new_pass" name="new_pass" placeholder="Enter New Password" class="form-control" autofocus>
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-10">
        	<input type="password" id="cnf_pass" name="cnf_pass" placeholder="Enter Confirm Password" class="form-control" autofocus>
        </div>
        </div>
        <div class="form-group">
        <div class=" col-sm-10">
            <input type="hidden" id="adminid" name="adminid" value="<?php if(isset($_GET["secure"])) echo $_GET["secure"]?>"/>
            <input type="hidden" id="email" name="email" value="<?php if(isset($_GET["personaladd"])) echo $_GET["personaladd"]?>"/>
            <input type="button" value="Submit" onClick="resetpassword()" class="btn btn-primary btn-lg btn-block bs">
        </div>
        </div>
    </form>
    </div>
    </div>
    </div>
</div>
</div>
</body>
</html>