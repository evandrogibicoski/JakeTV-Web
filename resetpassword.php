<?php
include('service.php');
include('secure/customjs.php');
$obj = new service_class();

$PageLimit = "6";
if(isset($_POST['load_value'])){
	echo $Page1 = $_POST['load_value'];
	$PageLimit = $Page1*$PageLimit;
	$_SESSION['pagedata'] = $PageLimit;
}

if(!empty($_SESSION['pagedata'])){
	$PageLimit =  $_SESSION['pagedata'];
}else{
	$PageLimit = "6";
	//$_SESSION['pagedata'] = $PageLimit;
}

$qry02 = $obj->qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");

if(!empty($qry02)){
	foreach($qry02 as $qry){
		$id = $qry['catidu'];
		$qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
		$dd[] = $qry021;
	}
	
	foreach($dd as $v1){
		if(is_array($v1)){
			foreach($v1 as $v2){
				@$newArray[] = $v2;
			}
		}
	}
	if(!empty($newArray)){	
		foreach($newArray as $newArray){
			$post_id[] = $newArray['postid'];
		}
	}else{
		$post_id[] = "";	
	}
}else{
	$post_id[] = "";
}

if(isset($_SESSION['sessionid'])){
	$sel = $obj->qry_fetchRow("select * from tbl_user where sessid='".$_SESSION['sessionid']."'");
	
	$userid = $sel['userid'];
	$first_rname = $sel['fname'];
	$last_name = $sel['lname'];
	$user_catid = explode(',',$sel['catid']);
	if($sel['catid'] != ""){
		for($i=0;$i<count($user_catid);$i++){
		$id = $user_catid[$i];
		$qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
		$user_cat_post[] = $qry021;
		}
		foreach($user_cat_post as $v1){
			if(is_array($v1)){
				foreach($v1 as $v2){
					@$user_post_array[] = $v2;
				}
			}
		}
		if(!empty($user_post_array)){
			foreach($user_post_array as $user_post_array){
				$user_post_id[] = $user_post_array['postid'];
			}
			$user_post_id1 = array_unique($user_post_id);
			foreach($user_post_id1 as $k => $v){
				$user_post_id2[] = $v;
			}
		}else{
			$user_post_id2[] = "";
		}
	}else{
			$user_post_id2[] = "";
	}
	
	
	
	$all_post_id = array_merge($user_post_id2, $post_id);
	
	$all_post_id2 = array_unique($all_post_id);
	
	foreach($all_post_id2 as $k=>$val){
		if($val != ""){
			$all_post_id1[] = $val;
		}
	}
	if(!empty($all_post_id1)){
		$d = implode(',',$all_post_id1);
		$fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc LIMIT $PageLimit");
		$total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc");
	}else{
		@$fetch_post == array();
		$total_post_rows = 0;
	}
	
}else{
	foreach($post_id as $k=>$val){
		if($val != ""){
			$post_id1[] = $val;
		}
	}
	if(!empty($post_id1)){
		$d = implode(',',$post_id);
		$fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc LIMIT $PageLimit");
		
		$total_post_rows = $obj->qry_numrows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc");
	}
	else{
		@$fetch_post == "";	
		$total_post_rows = 0;
	}
}
/* -------Category List------ */
if(isset($_SESSION['sessionid'])){
	$cat_list = $obj->qry_fetchRow("select catid from tbl_user where sessid='".$_SESSION['sessionid']."' and userid='".$userid."'");
	if($cat_list['catid'] != ""){
		$cat_list1 = $obj->qry_fetchRows("SELECT category,catidu FROM tbl_category WHERE catidu IN (".$cat_list['catid'].") AND selected='1'");	
		if(!empty($cat_list1)){
			$cat_list1 = $cat_list1;
		}else{
			$cat_list1 = array();	
		}
	}else{
		$cat_list1 = array();
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="images/JAKEtv_flav.png">
<title>Jake TV • Jewish Arts Knowledge Entertainment</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- materialize bootstrap -->
<link rel="stylesheet" href="css/bootstrap-material-design.css">
<link rel="stylesheet" href="css/ripples.min.css">
<!-- materialize bootstrap complete-->

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Zoo Planet Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
</head>
<body style="background:#fff;'">
<div class="header">
  <?php
include('header.php'); 
?>
</div>
<!--welcome-->
<div class="content">
  <div class="welcome">
  <!--<div class="container">
        <div class="card card-container center-block" style="margin-top:100px;" >
            <form class="form-signin">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form>
            <a href="#" class="forgot-password">
                Forgot the password?
            </a>
        </div>
    </div>-->
<div class="container">
    <div class="card card-container" id="reset_page" style="margin-top:120px;padding-top:50px;padding-bottom:50px;">
    <form name-"reserpassword" method="post">
        <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
            <div class="row">
            	<p class="change_pass">Change password</p>
            </div>
            <div class="row" style="margin-top:25px;">
            	<div id="errormsg"></div>
             </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                      <input type="email" id="re_email" name="email" value="" placeholder="Email" class="form-control input-lg " 
                      style="border:none;border-bottom:1px solid #009688;" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12col-xs-12">
                      <input type="password" id="re_pass" name="password" value="" placeholder="Password" class="form-control input-lg " 
                       style="border:none;border-bottom:1px solid #009688;" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                      <input type="password" id="re_c_pass" name="cn_password" value="" placeholder="Conform Paasword" class="form-control input-lg " 
                       style="border:none;border-bottom:1px solid #009688;" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12">
                  <button type="button" onClick="reset_password()" name="respass" id="reset_button" class="form-control input-lg btn btn-primary btn-raised"> Reset Password</button>
                </div>
            </div> 
         </div>      
    </form>
 </div>
</div>
</div>  

<div class="footer-section" id="footerhr">
  <div class="footer-top">
    <p>&copy; 2015 JAKE TV. All rights reserved</p>
  </div>
</div>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script> 
<script src="js/jquery-1.11.1.min.js"></script> 
<script src="js/bootstrap.js"></script> 
<script src="js/material.min.js"></script> 
<script src="js/ripples.min.js"></script> 
<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script> 
<script>
function description_length()
{
var yourString = $("#desc").text();
var stripped = yourString .substr(0, 10);
var abc = stripped.length;
}
</script> 
<script>
$('#login').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})

$(document).ready(function(e) {	
	
});
</script> 
<script>
function searcheddata()
{
	var $data = $("#serachdata").val();	
	$.get('service.php',{data:$data,action:'search'}).done(function( data ) {
    	$("#content123").html(data);
  	});
}

function forgot_password()
{
 var email = $("#fr_email").val();
   if($("#fr_email").val()=="")
   {
    $("#errormsg").html("<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Please Enter Email.</div>");
    setTimeout(function() { 
    document.getElementById("errormsg").innerHTML = '';
    document.getElementById('email').focus(); 
    }, 5000);
   }
   else
   {
    $.ajax({
     url : 'service.php',
     type : 'post',
     data: 'forgotpassword=1&fr_email='+email,    
     success : function(data) 
     {
      if(data == '1'){
       document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Check Your mail to reset pasword.</div>";
      }else{
      document.getElementById('errormsg').innerHTML = "<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;'>Invalid Email id.</div>";
      }
     }
    });
   }
}
function reset_password()
{
	var re_email = document.getElementById('re_email').value;
	var re_pass = document.getElementById('re_pass').value;
	
	if($("#re_email").val() == '')
	{
		$("#errormsg").html("<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;text-align:center;'>Please Enter Email.</div>");
		document.getElementById('re_email').focus();
	}
	else if($("#re_pass").val() == "")
	{
		$("#errormsg").html("<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;text-align:center;'>Please Enter Password.</div>");
		document.getElementById('re_pass').focus();
	}
	else if($("#re_c_pass").val() == "")
	{
		$("#errormsg").html("<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;text-align:center;'>Please Enter confirm Password.</div>");
		document.getElementById('re_c_pass').focus();
	}
	else if($("#re_pass").val() != $("#re_c_pass").val())
	{
		$("#errormsg").html("<div class='alert alert-danger' role='alert' style='font-size:16px;letter-spacing:1px;text-align:center;'>Confirm Password is not match with Password.</div>");
		document.getElementById('re_c_pass').focus();
	}
	else
	{
		$.ajax({
			url:'service.php',
			type:'post',
			data:'resetpassword=1&re_email='+re_email+'&re_pass='+re_pass,
			success:function(data){
					if(data == 1)
					{
						alert("Your password change successfully!");
						setTimeout(function() { 
							window.location = "index.php";	
						}, 3000)
						return false;
					}
					else
					{
						document.getElementById("errormsg").innerHTML = "Sorry! Your old password is not match.";
						setTimeout(function() { 
							document.getElementById("errormsg").innerHTML = '';
							document.getElementById('re_c_pass').focus();	
						}, 5000)
						return false;
					}
				}
			});
	}
}

</script> 
<script>
  $(function () {
    $.material.init();
    $(".shor").noUiSlider({
      start: 40,
      connect: "lower",
      range: {
        min: 0,
        max: 100
      }
    });

    $(".svert").noUiSlider({
      orientation: "vertical",
      start: 40,
      connect: "lower",
      range: {
        min: 0,
        max: 100
      }
    });
  });
</script>
</body>
</html>
