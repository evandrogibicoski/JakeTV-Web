<?php
include("secure/config.php");
include("checksession.php");
if(isset($_POST['do_submit']))  {
	/* split the value of the sortation */
	$ids = explode(',',$_POST['sort_order']);
	/* run the update query for each id */
	foreach($ids as $index=>$id) {
		$id = (int) $id;
		if($id != '') {
			$query = 'UPDATE tbl_post SET sort_order = '.($index + 1).' WHERE postid = '.$id;
			$result = mysql_query($query) or die(mysql_error().': '.$query);
		}
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jake TV | POST</title>
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
	#sortable-list		{ padding:0; }
	#sortable-list li	{ padding:4px 8px; color:#000; cursor:move; list-style:none; width:500px; background:#ddd; margin:10px 0; border:1px solid #999; }
	#message-box		{ background:#fffea1; border:2px solid #fc0; padding:4px 8px; margin:0 0 14px 0; width:500px; }
</style>
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
            <h1>POST RECORDS</h1>
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
            <h3 class="content-header">Post Records</h3>
            </div>
        <div class="porlets-content">
        <?php 
			$query = 'SELECT postid, title FROM tbl_post WHERE `status`=1 ORDER BY sort_order ASC';
			$result = mysql_query($query) or die(mysql_error().': '.$query);
			if(mysql_num_rows($result)) {
		?>
        	<form id="dd-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <input type="submit" name="do_submit" class="btn btn-primary"  value="Submit Sortation" class="button" style="float:right;" />
            <ul id="sortable-list">
                <?php 
                    $order = array();
                    while($item = mysql_fetch_assoc($result)) {
                        echo '<li title="',$item['postid'],'">',$item['title'],'</li>';
                        $order[] = $item['postid'];
                    }
                ?>
            </ul>
            <br />
            <input type="hidden" name="sort_order" id="sort_order" value="<?php echo implode(',',$order); ?>" />
            
            </form>
            <?php } else { ?>
                
                <p>Sorry!  There are no items in the system.</p>
                
            <?php } ?>
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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.js"></script>
<script src="js/jquery.form.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.slimscroll.min.js"></script> 

<script src="js/jPushMenu.js"></script> 
<script src="js/side-chats.js"></script>
<script type="text/javascript">
/* when the DOM is ready */
		jQuery(document).ready(function() {
			/* grab important elements */
			var sortInput = jQuery('#sort_order');
			var submit = jQuery('#autoSubmit');
			var messageBox = jQuery('#message-box');
			var list = jQuery('#sortable-list');
			/* create requesting function to avoid duplicate code */
			var request = function() {
				jQuery.ajax({
					beforeSend: function() {
						messageBox.text('Updating the sort order in the database.');
					},
					complete: function() {
						messageBox.text('Database has been updated.');
					},
					data: 'sort_order=' + sortInput.val() + '&do_submit=1&byajax=1', //need [0]?
					type: 'post',
					url: '/demo/drag-drop-sort-save-jquery.php'
				});
			};
			/* worker function */
			var fnSubmit = function(save) {
				var sortOrder = [];
				list.children('li').each(function(){
					sortOrder.push(jQuery(this).data('id'));
				});
				sortInput.val(sortOrder.join(','));
				if(save) {
					request();
				}
			};
			/* store values */
			list.children('li').each(function() {
				var li = jQuery(this);
				li.data('id',li.attr('title')).attr('title','');
			});
			/* sortables */
			list.sortable({
				opacity: 0.7,
				update: function() {
					fnSubmit();
				}
			});
			list.disableSelection();
		});
	</script>
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

</script>
<?php //include("header_right.php"); ?>
<?php //include("footer.php"); ?>
</body>
</html>
