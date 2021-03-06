<?php
include("secure/config.php");
include("checksession.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jake TV | SUB CATEGORY</title>
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
            <h1>SUB CATEGORY RECORDS</h1>
            <!--<h2 class="">Subtitle goes here...</h2>-->
            </div>
            </div>
        <div class="container clear_both padding_fix"> 
        <div id="main-content">
        <div class="page-content">
        <div class="row">
        <div class="col-md-12">
        <div class="block-web" id="reloaddiv">
            <div class="header">
            <div class="btn-group pull-right" style="padding-top:4px;">
                <button id="editable-sample_new" class="btn btn-primary" onclick="addsubcategory_form()"> Add New <i class="fa fa-plus"></i> </button>
            </div>
            <h3 class="content-header">Sub Category Table</h3>
            </div>
        <div class="porlets-content">
        <div class="table-responsive">
        	<table  class="display table table-bordered table-striped" id="dynamic-table">
                <thead>
                    <tr>
                    	<th>S.No</th>
                        <th>Sub Category</th>
                        <th>Category</th>
                        <th>Create Date</th>
                        <th>Modify Date</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
					$qry1 = qry_numRows("SELECT * FROM `tbl_sub_category` WHERE `status`='1'");
					if($qry1 > 0)
					{
						$i = 1; 
						$qry2 = qry_fetchRows("SELECT `tsc`.`subcatid`,`tsc`.`catidu`,`tsc`.`subcategory`,`tc`.`category`,`tsc`.`cr_date`,`tsc`.`modify_date` FROM `tbl_sub_category` AS `tsc` INNER JOIN `tbl_category` AS `tc` ON `tsc`.`catidu`=`tc`.`catidu` WHERE `tsc`.`status`='1' AND `tc`.`status`='1' ORDER BY `tsc`.`subcatid` DESC");
						if(!empty($qry2))
						{
							foreach($qry2 as $subcategory_data)
							{
								?>
								<tr class="gradeX">
									<td><?=$i++?></td>
									<td><?=$subcategory_data["subcategory"]?></td>
									<td><?=$subcategory_data["category"]?></td>
									<td><?=date('d-m-Y',strtotime($subcategory_data["cr_date"]))?></td>
									<td><?=date('d-m-Y',strtotime($subcategory_data["modify_date"]))?></td>
									<td class="center"> <a href="javascript:void(0)" title="Edit Sub Category" onclick="updatesubcategory_form('<?=$subcategory_data["catidu"]?>','<?=$subcategory_data["subcatid"]?>','<?=$subcategory_data["subcategory"]?>')"><i class="fa fa-edit"></i></a> &nbsp; <a href="javascript:void(0)" title="Delete Sub Category" onclick="deletesubcategory('<?=$subcategory_data["subcatid"]?>')"><i class="fa fa-trash-o"></i></a></td>
								</tr>
								<?php
							}
						}
					}
					?>
                </tbody>
            </table>
        </div>
        </div><!--/porlets-content-->
        </div><!--/block-web--> 
        </div><!--/col-md-12--> 
        </div><!--/row-->
        </div><!--/page-content end-->
        </div><!--/main-content end--> 
        </div><!--\\\\\\\ container  end \\\\\\-->
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
	location.reload();
}
function addsubcategory_form()
{
	loader_show();
	$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'addsubcategory_form=1',				
		success : function(returndata) 
		{
			loader_hide();
			document.getElementById("reloaddiv").innerHTML = returndata;
		}
	});
}
function addsubcategory_insert()
{
	var catid = $("#catid").val();
	var subcategory = $("#subcategory").val();
	if(catid=="")
	{
		document.getElementById("error").innerHTML = "Please select category.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('catid').focus();	
		}, 5000)
		return false;
	}
	else if(subcategory=="")
	{
		document.getElementById("error").innerHTML = "Please enter sub category.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('subcategory').focus();	
		}, 5000)
		return false;
	}
	else
	{
		loader_show();
		$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'addsubcategory_insert=1&catid='+catid+'&subcategory='+subcategory,				
		success : function(returndata) 
		{
			loader_hide();
			if(returndata=='1')
			{
				location.reload();
			}
			else
			{
				document.getElementById("error").innerHTML = "Subcategory already exist.";
				setTimeout(function() { 
					document.getElementById("error").innerHTML = '';
					document.getElementById('subcategory').focus();	
				}, 5000)
				return false;
			}
		}
		});
	}
}
function updatesubcategory_form(catid,subcatid,subcategory)
{
	loader_show();
	$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'updatesubcategory_form=1&catid='+catid+'&subcatid='+subcatid+'&subcategory='+subcategory,				
		success : function(returndata) 
		{
			loader_hide();
			document.getElementById("reloaddiv").innerHTML = returndata;
		}
	});
}
function updatesubcategory_update(subcatid)
{
	var catid = $("#catid").val();
	var subcategory = $("#subcategory").val();
	if(subcategory=="")
	{
		document.getElementById("error").innerHTML = "Please enter subcategory.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('subcategory').focus();	
		}, 5000)
		return false;
	}
	else
	{
		loader_show();
		$.ajax( {
			url : 'ajaxdata.php', 
			type : 'post',
			data: 'updatesubcategory_update=1&catid='+catid+'&subcatid='+subcatid+'&subcategory='+subcategory,				
			success : function(returndata) 
			{
				loader_hide();
				if(returndata=='1')
				{
					location.reload();
				}
				else
				{
					document.getElementById("error").innerHTML = "Subcategory already exist.";
					setTimeout(function() { 
						document.getElementById("error").innerHTML = '';
						document.getElementById('subcategory').focus();	
					}, 5000)
					return false;
				}
			}
		});
	}
}
function deletesubcategory(subcatid)
{
	if(confirm("Are you sure want to delete this subcategory?"))
	{
		loader_show();
		$.ajax( {
			url : 'ajaxdata.php', 
			type : 'post',
			data: 'deletesubcategory=1&subcatid='+subcatid,				
			success : function(returndata) 
			{
				loader_hide();
				if(returndata=='1')
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
