<?php
include("secure/config.php");
include("checksession.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jake TV | USER</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="shortcut icon" href="images/favjaketv.png" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/animate.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="plugins/data-tables/DT_bootstrap.css" rel="stylesheet">
<link href="plugins/advanced-datatable/css/demo_table.css" rel="stylesheet">
<link href="plugins/advanced-datatable/css/demo_page.css" rel="stylesheet">
</head>
<body class="light_theme  fixed_header left_nav_fixed">
<div class="wrapper">
<?php include("header.php")?>
<div class="inner">
<?php include("header_left.php")?>
<div class="contentpanel"> 
            <div class="pull-left breadcrumb_admin clear_both">
            <div class="pull-left page_title theme_color">
            <h1>USER RECORDS</h1>
            <!--<h2 class="">Subtitle goes here...</h2>-->
            </div>
            </div>
        <div class="container clear_both padding_fix"> 
        <div id="main-content">
        <div class="page-content">
        
        
        <div class="row">
        <div class="col-md-12">
        <div class="block-web">
            <div class="header">
            	<h3 class="content-header">User Records</h3>
            </div>
            <div class="porlets-content">
            <div class="table-responsive">
            <table  class="display table table-bordered table-striped" id="dynamic-table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
					$qry1 = qry_numRows("SELECT * FROM `tbl_user` WHERE `status`='1'");
					if($qry1 > 0)
					{
						$i = 1;
						$qry2 = qry_fetchRows("SELECT * FROM `tbl_user` WHERE `status`='1' ORDER BY `userid` DESC");
						foreach($qry2 as $user_data)
						{
					?>
                    <tr class="gradeX">
                        <td><?=$i++?></td>
                        <td><?=$user_data["fname"].' '.$user_data["lname"]?></td>
                        <td><?=$user_data["email"]?></td>
                        <td></td>
                        <td class="center"><a href="javascript:void(0)" onclick="deleteuser(<?=$user_data["userid"]?>)" title="Delete User"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                    <?php
						}
					}
					?>
                </tbody>
            </table>
            </div>
            </div>
        </div>
        </div>
        </div>
</div>
</div>
</div>
 
<!--\\\\\\\ wrapper end\\\\\\-->
 
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
function deleteuser(userid)
{
	if(confirm("Are you sure want to delete this user?"))
	{
		$.ajax( {
			url : 'ajaxdata.php', 
			type : 'post',
			data: 'deleteuser=1&userid='+userid,				
			success : function(data) 
			{
				if(data=='1')
				{
					location.reload();
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
