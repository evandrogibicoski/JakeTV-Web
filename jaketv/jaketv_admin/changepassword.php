<?php
include("secure/config.php");
include("checksession.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jake TV | CHANGE PASSWORD</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="shortcut icon" href="images/favjaketv.png" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/animate.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="plugins/data-tables/DT_bootstrap.css" rel="stylesheet">
<link href="plugins/advanced-datatable/css/demo_table.css" rel="stylesheet">
<link href="plugins/advanced-datatable/css/demo_page.css" rel="stylesheet">
<style type="text/css">
.block_innerdiv{background-image:url(images/loader.GIF);height:103px;width:100px;display:inline-block;z-index:1102;}
.block_outerdiv{width:100%;opacity:0.87;display:none;position:absolute;z-index:1102;
text-align:center;background-color:#E7E7E7;ackground-repeat:repeat;}
</style>
</head>
<body class="light_theme  fixed_header left_nav_fixed">
	<!---AJAX LOADER--->
    <div class="block_outerdiv" id="div_loader">
    <div class="block_innerdiv" id="div_loader2"></div>
    </div>
    <!---AJAX LOADER--->
<div class="wrapper">
<?php include("header.php")?>
<div class="inner">
<?php include("header_left.php")?>
<div class="contentpanel"> 
            <div class="pull-left breadcrumb_admin clear_both">
            <div class="pull-left page_title theme_color">
            <h1>CHANGE PASSWORD</h1>
            <!--<h2 class="">Subtitle goes here...</h2>-->
            </div>
            </div>
        <div class="container clear_both padding_fix"> 
        <div id="main-content">
        <div class="page-content">
        <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-4">
        <div class="block-web">
        	<div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
        <div class="porlets-content">
        	    <form id="pass_change" name="pass_change" method="post" action="">
                <div class="form-group">
                  <label>Old Password</label>
                  <input name="oldpass" id="oldpass" type="password" placeholder="Enter Old Password" parsley-trigger="change" class="form-control" style="width:220px !important;">
                </div><!--/form-group-->
                <div class="form-group">
                  <label>New PAssword</label>
                  <input name="password" id="password" type="password" placeholder="Enter New Password" parsley-trigger="change" class="form-control" style="width:220px !important;">
                </div><!--/form-group-->
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input name="password_confirm" id="password_confirm" type="password" placeholder="Enter Confirm Password" parsley-trigger="change" class="form-control" style="width:220px !important;">
                </div><!--/form-group-->
                <!--<button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-default">Cancel</button>-->
                <input type="button" class="btn btn-primary btn-lg btn-block bs" style="width:108px;"  value="Save" onclick="change_password('<?=$_SESSION['admin_user_id']?>','<?=$_SESSION['admin_email']?>')">
				<input type="button" class="btn btn-default btn-lg bs" style="width:108px;"  value="Cancel" onclick="cancel()">
              	</form>
        </div><!--/porlets-content-->
        </div><!--/block-web--> 
        </div><!--/col-md-12--> 
        </div><!--/row-->
        </div><!--/page-content end-->
        </div><!--/main-content end--> 
        </div><!--/container end-->
</div>
</div>
</div>
 
<?php //include("popup_chat.php"); ?>

<script src="js/jquery-2.1.0.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/common-script.js"></script> 
<script src="js/jquery.slimscroll.min.js"></script> 
<script src="plugins/data-tables/jquery.dataTables.js"></script> 
<script src="plugins/data-tables/DT_bootstrap.js"></script> 
<script src="plugins/data-tables/dynamic_table_init.js"></script> 
<script src="plugins/edit-table/edit-table.js"></script> 
<script>
jQuery(document).ready(function() {
  EditableTable.init();
});
</script> 
<script src="js/jPushMenu.js"></script> 
<script src="js/side-chats.js"></script>
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

function logout()
{
	var siteurl = '<?=$_SESSION["ADMINPATH"]?>';
	$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'logoutdata=1',				
		success : function(data) 
		{
			if(data=='1')
			{
				window.location.href = siteurl;
			}
		}
	});
}

function cancel()
{
	window.location = "dashboard.php";
}

function change_password(id,emaildata)
{
		var passexpression = /^.{5,20}$/;
		var oldpass = $("#oldpass").val();
		var password = $("#password").val();
		var password_confirm = $("#password_confirm").val();
		
		if($("#oldpass").val()=="")
		{
			document.getElementById("error").innerHTML = "Please enter your old password.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';
				document.getElementById('oldpass').focus();	
			}, 5000)
			return false;
		}
		else if($("#password").val()=="")
		{
			document.getElementById("error").innerHTML = "Please enter your password.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';
				document.getElementById('password').focus();	
			}, 5000)
			return false;
		}
		else if(!$("#password").val().match(passexpression))
		{
			document.getElementById("error").innerHTML = "Please enter password atleast 5 charecters long.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';
				document.getElementById('password').focus();	
			}, 5000)
			return false;
		}
		else if($("#password_confirm").val()=="")
		{
			document.getElementById("error").innerHTML = "Please enter your confirm password.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';
				document.getElementById('password_confirm').focus();	
			}, 5000)
			return false;
		}
		else if($("#password").val()!=$("#password_confirm").val())
		{
			document.getElementById("error").innerHTML = "Confirm password is not match with password.";
			setTimeout(function() { 
				document.getElementById("error").innerHTML = '';
				document.getElementById('password_confirm').focus();	
			}, 5000)
			return false;
		}
		else
		{
			loader_show();
			$.ajax( {
				url : 'ajaxdata.php', 
				type : 'post',
				data: 'changepassword=1&userid='+id+'&email='+emaildata+'&oldpass='+oldpass+'&password='+password,				
				success : function(data) 
				{
					loader_hide();
					if(data=='1')
					{
						alert("Your password change successfully!");
						setTimeout(function() { 
							window.location = "dashboard.php";	
						}, 3000)
						return false;
					}
					else
					{
						document.getElementById("error").innerHTML = "Sorry! Your old password is not match.";
						setTimeout(function() { 
							document.getElementById("error").innerHTML = '';
							document.getElementById('password_confirm').focus();	
						}, 5000)
						return false;
					}
				}
			});
		}
}
</script>
<?php //include("header_right.php"); ?>
<?php //include("footer.php"); ?>
</body>
</html>

