<?php
include("secure/config.php");
include("checksession.php");
/*SELECTED UNSELECTED CATEGORY START*/
if(isset($_POST["submit"]))
{
	$qry0 = qry_runQuery("UPDATE `tbl_category` SET `selected`='0' WHERE `status`='1'");
	$qry0 = qry_runQuery("UPDATE `tbl_sub_category` SET `selected`='0' WHERE `status`='1'");
	
	if(isset($_POST["chkid"]))
	{
		$chkid = $_POST["chkid"];
		for($i=0;$i<count($chkid);$i++)
		{
			$qry1 = qry_runQuery("UPDATE `tbl_category` SET `selected`='1' WHERE `status`='1' AND `catidu`='".$chkid[$i]."'");
		}
	}
	
	if(isset($_POST['schkid']))
	{
		$schkid = $_POST["schkid"];
		for($i=0;$i<count($schkid);$i++)
		{
			$qry1 = qry_runQuery("UPDATE `tbl_sub_category` SET `selected`='1' WHERE `status`='1' AND `subcatidu`='".$schkid[$i]."'");
		}
	}
	
}
/*SELECTED UNSELECTED CATEGORY START*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Jake TV | SELECTED CATEGORY</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="shortcut icon" href="images/favjaketv.png" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/animate.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="plugins/toggle-switch/toggles.css" rel="stylesheet" type="text/css" />
<link href="plugins/bootstrap-fileupload/bootstrap-fileupload.min.css" rel="stylesheet">
<link href="plugins/dropzone/dropzone.css" rel="stylesheet">
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
            <h1>SELECTED CATEGORY</h1>
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
            	<h3 class="content-header">Selected Category Records</h3>
            </div>
            <div class="porlets-content">
                <form class="form-horizontal bucket-form" method="post" action="">
                <div class="form-group">
                <div class="col-sm-9 icheck ">
                <?php
                $qry1 = qry_numRows("SELECT * FROM `tbl_category` WHERE `status`!='2'");
				if($qry1 > 0)
				{
					$qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`!='2'");
					$i=1;
					foreach($qry2 as $qry2_data)
					{
				?>
                    <div>
                    <div>
                    <input type="checkbox" name="chkid[]" id="<?=$qry2_data['catidu']?>" value="<?=$qry2_data['catidu']?>" <?php if($qry2_data['selected']==1){ ?>checked<?php }?> onClick="checkedsub(this.id);"/>
                    <label for="<?=$qry2_data["category"]?>"><?=$qry2_data["category"]?></label>
                    <div id="<?=$qry2_data['catidu']?>">
					<?php 
						$qry02 = qry_fetchRows("SELECT * FROM `tbl_sub_category` WHERE `catidu`='".$qry2_data['catidu']."'");
						//print_r($qry02);
						if ($qry02)
						{
						foreach($qry02 as $qry02_data)
						{
							?>
							<div style="margin-left:20px;">
                            <input type="checkbox" name="schkid[]" class="<?=$qry2_data['catidu']?>" value="<?=$qry02_data['subcatidu']?>" <?php if($qry02_data['selected']==1){ ?>checked<?php }?> onClick="uncheckmain('<?=$qry2_data['catidu']?>');"/>
                    		<label for="<?=$qry02_data["subcategory"]?>"><?=$qry02_data["subcategory"]?></label>
                            </div>
							<?php
						}
						}
					?>
                    </div> 
                    </div>
                    </div>
                <?php
					$i++;
					}?>
                    <input type="submit" class="btn btn-primary btn-lg btn-block bs" name="submit" value="SAVE" style="float: left; width: 100px;margin-top: 10px;"/>
                    <?php
				}
				else
				{
					echo "No Selected Category Found";
				}
				?>
                </div>
                </div>
                </form>
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
<script type="text/javascript"  src="plugins/toggle-switch/toggles.min.js"></script> 
<script type="text/javascript" src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript" src="plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> 
<script type="text/javascript" src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
<script type="text/javascript" src="plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script> 
<script type="text/javascript" src="js/form-components.js"></script> 
<script type="text/javascript"  src="plugins/input-mask/jquery.inputmask.min.js"></script> 
<script type="text/javascript"  src="plugins/input-mask/demo-mask.js"></script> 
<script type="text/javascript"  src="plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script> 
<script type="text/javascript"  src="plugins/dropzone/dropzone.min.js"></script> 
<script type="text/javascript" src="plugins/ckeditor/ckeditor.js"></script>

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
function checkedsub(id)
{
	if(document.getElementById(id).checked==true)
	{
		$("."+id).prop('checked',true);	
	}
	if(document.getElementById(id).checked==false)
	{
		$("."+id).prop('checked',false);	
	}
}
function uncheckmain(ids)
{
	$("#"+ids).prop('checked',false);	
}

/*function check_uncheck(catid,value,id)
{
	if(document.getElementById(id).checked == true)
	{
		var selected = 1;
	}
	else
	{
		var selected = 0;
	}
	loader_show();
	$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'check_uncheck=1&catid='+catid+'&selected='+selected,				
		success : function(data) 
		{
			loader_hide();
			location.reload();
		}
	});
}*/
</script>
<?php //include("header_right.php"); ?>
<?php //include("footer.php"); ?>
</body>
</html>
