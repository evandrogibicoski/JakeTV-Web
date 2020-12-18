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
.login_content {
{
	 
}
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
	
function forgotpassword()
{
	loader_show();
	$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'forgotpassword=1',				
		success : function(data) 
		{
			loader_hide();
			$("#reloaddivdata").html(data);
		}
	});
}
	
function login()
{
		var emailchk = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;
		var num=/^[0-9]+$/;
		var max_file_size = 4000000;
		var email = $("#email").val();
		var password = $("#password").val();
		var accept = document.getElementById('accept');
		
		if(email=="")
		{
			//requiredAlert('Please enter your email id.');
			document.getElementById("error").innerHTML = "Please enter your email id.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';	
			}, 5000)
			return false;
		}
		else if(emailchk.test(email)==false)
		{
			//requiredAlert('Please enter valid email id.');
			document.getElementById("error").innerHTML = "Please enter valid email id.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';	
			}, 5000)
			return false;
		}
		else if(password=="")
		{
			//requiredAlert('Please enter your password.');
			document.getElementById("error").innerHTML = "Please enter your password.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';	
			}, 5000)
			return false;
		}
		else
		{
			loader_show();
			var options = {
			beforeSubmit:  showRequest,
			success:       showResponse,
			url:       'ajaxdata.php', 
			type: "POST"
			};
			$('#userform').submit(function(){ 
				$(this).ajaxSubmit(options);
				return false;
			});
		}
}
function showRequest(formData, jqForm, options) 
{
	return true;
}
function showResponse(data, statusText)  
{
	loader_hide();
	if(statusText == 'success')
	{
		if(data=='1')
		{
			//alert('Please wait while loading page.....');
			window.location.href='dashboard.php?';
		}
		else if(data=='0')
		{
			//invalidAlert('Invalid emailid or password.');
			document.getElementById("error").innerHTML = "Invalid emailid or password.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';	
			}, 5000)
			return false;
		}
	}
	//$('#userform').unbind();
	//$('#userform').bind();
	$('#userform').unbind('submit').bind('submit',function(){});
}
	
function backtologin()
{
	location.reload(); 
}
	
function forgotpasssendmail()
{
	var emailchk = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;
	var num=/^[0-9]+$/;
	var max_file_size = 4000000;
	var email = $("#forgot_email").val();
	
	if(email=="")
	{
		document.getElementById("error").innerHTML = "Please enter your email id.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';	
		}, 5000)
		return false;
	}
	else if(emailchk.test(email)==false)
	{
		document.getElementById("error").innerHTML = "Please enter valid email id.";
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
			data: 'forgotpasssendmail=1&email='+email,				
			success : function(data) 
			{
				loader_hide();
				if(data=='1')
				{
					window.location.href='index.php?';
				}
				else if(data=='0')
				{
					alert('Email is invalid.');
					document.getElementById("error").innerHTML = "Email not exist";
					return false;
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
    <div class="login_content" style="background:rgba(255,255,255, 0.6) !important;">
    <div id="reloaddivdata">	
    <form role="form" id="userform" name="userform" method="post" action="" class="form-horizontal" style="padding:40px 25px 0 20px;">
    	<div class="form-group" id="error" style="height:15px;color:#F00;font-size:16px;margin-top:-5px;"></div>
        <div class="form-group">
        <div class="col-sm-10">
        	<input type="text" id="email" name="email" placeholder="Email" class="form-control" value="<?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != '') echo $_COOKIE['username'] ?>" autofocus>
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-10">
        	<input type="password" id="password" name="password" placeholder="Password" class="form-control" value="<?php if(isset($_COOKIE['userpassword']) && $_COOKIE['userpassword'] != '') echo $_COOKIE['userpassword'] ?>">
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-10">
        	<input type="hidden" value="logindata" name="logindata"/>
            <input class="btn btn-primary btn-lg btn-block bs" type="submit" value="Login" id="submit" onClick="return login()">
        </div>
        </div>
        <div class="form-group">
        <div class=" col-sm-10">
        <div class="checkbox checkbox_margin">
            <label class="lable_margin" for="login-check">
            <input name="login-check" id="login-check" type="checkbox" value="1" <?php if(isset($_COOKIE['userpassword']) && $_COOKIE['userpassword'] != '') echo "checked='checked'" ?>><p class="pull-left" style="font-size:18px;"> Remember me</p>
            </label>
        </div>
        </div>
        </div>
    </form>
    </div>
    </div>
    <div class="form-group" style="text-align:center;margin-top:100px;font-size:18px;">
        <a href="javascript:void(0)" onClick="forgotpassword()" style="color:#fff !important;cursor:pointer;text-decoration:underline;">Forgot Password?</a>
    </div>
    </div>
</div>
</div>
</body>
</html>
