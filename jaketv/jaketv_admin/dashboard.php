<?php
include("secure/config.php");
include("checksession.php");
$qry_user = qry_numRows("SELECT * FROM `tbl_user` WHERE `status`='1'");
$qry_cat = qry_numRows("SELECT * FROM `tbl_category` WHERE `status`='1'");
$qry_subcat = qry_numRows("SELECT * FROM `tbl_sub_category` WHERE `status`='1'");
$qry_post = qry_numRows("SELECT * FROM `tbl_post` WHERE `status`='1'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jake TV | DASHBOARD</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link rel="shortcut icon" href="images/favjaketv.png" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/animate.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="plugins/kalendar/kalendar.css" rel="stylesheet">
<link rel="stylesheet" href="plugins/scroll/nanoscroller.css">
<link href="plugins/morris/morris.css" rel="stylesheet" />



  
  
  

<style type="text/css">
.block_innerdiv {
	background-image: url(images/loader.GIF);
	height: 103px;
	width: 100px;
	display: inline-block;
	z-index: 1102;
}
.block_outerdiv {
	width: 100%;
	opacity: 0.87;
	display: none;
	position: absolute;
	z-index: 1102;
	text-align: center;
	background-color: #E7E7E7;
	ackground-repeat: repeat;
}







a {
	color: #fff;
}
.dropdown dd, .dropdown dt {
	margin: 0px;
	padding: 0px;
}
.dropdown ul {
	margin: -1px 0 0 0;
}
.dropdown dd {
	position: relative;
}
.dropdown a, .dropdown a:visited {
	color: #fff;
	text-decoration: none;
	outline: none;
	font-size: 16px;
}
.dropdown dt a {
	background-color: #fff;
	display: block;
	padding: 8px;
	;
	min-height: 45px;
	line-height: 12px;
	overflow: hidden;
	border: 1px solid #ccc;
	;
	width: 100%;
	font-family: open sans;
	font-weight: 400;
}
.dropdown dt a span, .multiSel span {
	cursor: pointer;
	display: inline-block;
	padding: 0 1px 2px 0;
	color: #999999;
	font-size: 16px;
	font-weight: 400;
	font-family: open sans;
	margin-top: 10px;
	margin-left: 5px;
}
.dropdown dd ul {
	background-color: #fff;
	border: 1px solid #ccc;
	border-top : none;
	color: #999999;
	display: none;
	left: 0px;
	padding: 2px 15px 2px 5px;
	position: absolute;
	top: 2px;
	width: 100%;
	list-style: none;
	height: 100px;
	overflow: auto;
	font-family: open sans;
	font-size: 16px;
	font-weight: 400;
}
.dropdown dd ul li:hover {
	background: #3276B1;
	color: #fff;
	width: 100%;
}
.dropdown span.value {
	display: none;
}
.dropdown dd ul li a {
	padding: 5px;
	display: block;
}
.dropdown dd ul li a:hover {
	background-color: #fff;
}
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
          <h1>Dashboard</h1>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <div class="row">
          <div class="col-sm-4 col-sm-6"> <a href="<?=$siteadmin?>users.php" style="cursor:pointer;text-decoration:none;">
            <div class="information green_info">
              <div class="information_inner">
                <div class="info green_symbols"><i class="fa fa-users icon"></i></div>
                <span>USERS</span>
                <h1 class="bolded">
                  <?=$qry_user?>
                </h1>
                <div class="infoprogress_green">
                  <div class="greenprogress"></div>
                </div>
              </div>
            </div>
            </a> </div>
          <div class="col-sm-4 col-sm-6"> <a href="<?=$siteadmin?>category.php" style="cursor:pointer;text-decoration:none;">
            <div class="information blue_info">
              <div class="information_inner">
                <div class="info blue_symbols"><i class="fa fa-th icon"></i></div>
                <span>CATEGORY</span>
                <h1 class="bolded">
                  <?=$qry_cat?>
                </h1>
                <div class="infoprogress_blue">
                  <div class="blueprogress"></div>
                </div>
              </div>
            </div>
            </a> </div>
          <div class="col-sm-4 col-sm-6"> <a href="<?=$siteadmin?>post.php" style="cursor:pointer;text-decoration:none;">
            <div class="information gray_info">
              <div class="information_inner">
                <div class="info gray_symbols"><i class="fa fa-tasks icon"></i></div>
                <span>POSTS</span>
                <h1 class="bolded">
                  <?=$qry_post?>
                </h1>
                <div class="infoprogress_gray">
                  <div class="grayprogress"></div>
                </div>
              </div>
            </div>
            </a> </div>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <div class="row">
          <div class="col-md-12 col-lg-8 col-sm-12">
            <section class="panel default blue_title h2">
              <div class="panel-body">
                <ul id="myTab" class="nav nav-tabs">
                  <li class="active"><a href="#Tab1" data-toggle="tab"><i class="fa fa-tasks"></i> Add Post <i class="fa fa-plus"></i> </a></li>
                </ul>
                <div id="myTabContent" class="tab-content" style="margin-bottom:-10px;">
                  <div class="tab-pane fade active in" id="Tab1">
                    <div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
                    <form id="postform" class="postform" name="postform" action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label>Title</label>
                        <input name="title" id="title" type="text" placeholder="Enter Post Title" parsley-trigger="change" class="form-control">
                      </div>
                     
                      
                      <!--<div class="form-group">
                                    <label>Category</label>
                                    <select name="catid" id="catid_post" class="form-control" onChange="subcategory_show(this.value)" >
                                        <option value="">--SELECT CATEGORY--</option>
                                        <?php
                                        $qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
                                        foreach($qry2 as $category_select2)
                                        {
                                            echo '<option value="'.$category_select2["catidu"].'" style="font-size:15px;height:25px;">'.$category_select2["category"].'</option>';
                                        }
                                        ?>
                                    </select>
                                    </div>-->
                      
                      <label>Category</label>
                      <dl class="dropdown">
                        <dt> <a> <span class="hida">SELECT CATEGORY</span>
                          <p class="multiSel"></p>
                          </a> </dt>
                        <dd>
                          <div class="mutliSelect">
                            <ul>
                              <?php
								$qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
								foreach($qry2 as $category_select2)
								{ ?>
                              <li style="cursor:pointer">
                                <input type="hidden" id="check_id<?php echo $category_select2["catidu"]; ?>" value="<?php echo $category_select2["category"]; ?>" />
                                <input type="checkbox"  name="catid[]" value="<?php echo $category_select2["catidu"]; ?>" />
                                <?php echo $category_select2["category"]; ?> </li>
                              <?php }
                                                    ?>
                            </ul>
                          </div>
                        </dd>
                      </dl>
                      <div class="form-group">
                        <label>Post Image</label>
                        <input name="postimage" id="postimage" type="file" parsley-trigger="change" class="form-control" style="padding:0px !important;">
                      </div>
                      <div class="form-group">
                        <label>URL</label>
                        <input name="url" id="url" type="text" placeholder="Enter URL" parsley-trigger="change" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Kicker Line</label>
                        <input name="kicker" id="kicker" type="text" placeholder="Enter kicker line" parsley-trigger="change" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Source</label>
                        <input name="source" id="source" type="text" placeholder="Enter Source" parsley-trigger="change" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control" style="width:100%  !important;"></textarea>
                      </div>
                      <input type="hidden" name="insert_post" id="insert_post"  class="form-control">
                      <input type="submit" class="btn btn-primary btn-lg btn-block bs" style="width:108px;" name="btn_save" id="submit" value="Save" onclick="return addpost_insert()">
                      <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
                    </form>
                  </div>
                </div>
              </div>
            </section>
          </div>
          <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="row">
              <div class="col-md-12">
                <section class="panel default blue_title h2"> 
                  <div class="panel-body">
                    <ul id="myTab" class="nav nav-tabs">
                      <li class="active"><a href="#Tab1" data-toggle="tab"><i class="fa fa-th"></i> Add Category <i class="fa fa-plus"></i> </a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content" style="margin-bottom:-10px;">
                      <div class="tab-pane fade active in" id="Tab1">
                        <div id="error_cat" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
                        <form id="pass_change" name="pass_change" method="post" action="">
                          <div class="form-group">
                            <label>Category</label>
                            <input name="category" id="category" type="text" placeholder="Enter Category Name" parsley-trigger="change" class="form-control">
                          </div>
                          <input type="button" class="btn btn-primary btn-lg btn-block bs" style="width:108px;" value="Save" onclick="addcategory_insert()">
                          <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
                        </form>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
<script language="javascript" type="text/javascript">



$(".dropdown dt a").on('click', function () {
          $(".dropdown dd ul").slideToggle('fast');
      });

      /*$(".dropdown dd ul li a").on('click', function () {
          $(".dropdown dd ul").hide();
      });

      function getSelectedValue(id) {
           return $("#" + id).find("dt a span.value").html();
      }

      $(document).bind('click', function (e) {
          var $clicked = $(e.target);
          if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
      });*/


      $('.mutliSelect input[type="checkbox"]').on('click', function () {
        
  var cc = 'check_id' + $(this).val();
  var dd = document.getElementById(cc).value;
  
    
          //var title = $(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
          var title = dd + ",";
        
          if ($(this).is(':checked')) {
              var html = '<span title="' + title + '">' + title + '</span>';
              $('.multiSel').append(html);
              $(".hida").hide();
          } 
          else {
              $('span[title="' + title + '"]').remove();
              var ret = $(".hida");
              $('.dropdown dt a').append(ret);
              
          }
      });



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

function addcategory_insert()
{
	var category = $("#category").val();
	if(category=="")
	{
		document.getElementById("error_cat").innerHTML = "Please enter category.";
		setTimeout(function() { 
			document.getElementById("error_cat").innerHTML = '';
			//document.getElementById('category').focus();	
		}, 5000)
		return false;
	}
	else
	{
		$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'addcategory_insert=1&category='+category,				
		success : function(returndata) 
		{
			if(returndata=='1')
			{
				location.reload();
			}
			else
			{
				document.getElementById("error_cat").innerHTML = "Category already exist.";
				setTimeout(function() { 
					document.getElementById("error_cat").innerHTML = '';
					//document.getElementById('category').focus();	
				}, 5000)
				return false;
			}
		}
		});
	}
}

function addsubcategory_insert()
{
	var catid_subsel = $("#catid").val();
	var subcategory = $("#subcategory").val();
	if(catid_subsel=="")
	{
		document.getElementById("error_subcat").innerHTML = "Please select category.";
		setTimeout(function() { 
			document.getElementById("error_subcat").innerHTML = '';
			//document.getElementById('catid').focus();	
		}, 5000)
		return false;
	}
	else if(subcategory=="")
	{
		document.getElementById("error_subcat").innerHTML = "Please enter sub category.";
		setTimeout(function() { 
			document.getElementById("error_subcat").innerHTML = '';
			//document.getElementById('subcategory').focus();	
		}, 5000)
		return false;
	}
	else
	{
		$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'addsubcategory_insert=1&catid='+catid_subsel+'&subcategory='+subcategory,				
		success : function(returndata) 
		{
			if(returndata=='1')
			{
				location.reload();
			}
			else
			{
				document.getElementById("error_subcat").innerHTML = "Subcategory already exist.";
				setTimeout(function() { 
					document.getElementById("error_subcat").innerHTML = '';
					document.getElementById('subcategory').focus();	
				}, 5000)
				return false;
			}
		}
		});
	}
}

/* ADD NEW POST FORM START FUNCTIONS*/

function subcategory_show(catid)
{
	loader_show();
	$.ajax( {
		url : 'ajaxdata.php', 
		type : 'post',
		data: 'subcategory_show=1&catid='+catid,			
		success : function(returndata) 
		{
			loader_hide();
			document.getElementById("reloaddiv_subcat").innerHTML = returndata;
		}
	});
}


function addpost_insert()
{
	loader_show();
	loader_hide();
	var urlvalid = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
	var max_file_size = 130000000;
	var title = $("#title").val();
	//var catid = $("#catid_post").val();
	//var subcatid = $("#subcatid").val();
	var postimage = $("#postimage").val();
	var postfiletype = postimage.slice(-3);
	var urlpost = $("#url").val();
	var description = $("#description").val();
	
	var catid = [];
	 var i = 1;
	 $("input[type=checkbox]:checked").each(function(){
	  catid[i] = $(this).val(); 
	  i++;
	 });
	
	
	if(title=="")
	{
		document.getElementById("error").innerHTML = "Please enter title.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('title').focus();	
		}, 5000)
		return false;
	}
	else if(catid=="")
	{
		document.getElementById("error").innerHTML = "Please select category.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('catid').focus();	
		}, 5000)
		return false;
	}
	/*else if(subcatid=="")
	{
		document.getElementById("error").innerHTML = "Please select sub category.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('subcatid').focus();	
		}, 5000)
		return false;
	}*/
	else if((postimage!="") && (postfiletype!="jpg" && postfiletype!="png" && postfiletype!="peg" && postfiletype!="gif" && postfiletype!="JPG" && postfiletype!="PNG" && postfiletype!="PEG" && postfiletype!="GIF"))
	{
		document.getElementById("error").innerHTML = "Image must be like in jpg, png, jpeg or gif format.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('postimage').focus();	
		}, 5000)
		return false;
	}
	else if((postimage!="") && (document.getElementById('postimage').files[0].size > max_file_size))
	{
		document.getElementById("error").innerHTML = "Image size must not larger than 10MB.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('postimage').focus();	
		}, 5000)
		return false;
	}
	/*else if($('input#postimage')[0].files.length > 5)
	{
		document.getElementById("error").innerHTML = "You can select maximum 5 images.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('postimage').focus();	
		}, 5000)
	}*/
	else if(urlpost=="")
	{
		document.getElementById("error").innerHTML = "Please enter post URL.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('url').focus();	
		}, 5000)
		return false;
	}
	else if(urlvalid.test(urlpost)==false)
	{
		document.getElementById("error").innerHTML = "Invalid URL.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('url').focus();	
		}, 5000)
		return false;
	}
	else if(description=="")
	{
		document.getElementById("error").innerHTML = "Please enter description of post.";
		setTimeout(function() { 
			document.getElementById("error").innerHTML = '';
			document.getElementById('description').focus();	
		}, 5000)
		return false;
	}
	else
	{
		var options = {
		beforeSubmit:  showRequest,
		success:       showResponse,
		url:       "ajaxdata.php", 
		type: "POST"
		};
		$('#postform').submit(function(){ 
			$(this).ajaxSubmit(options);
			return false;
		});
	}
}

function showRequest(formData, jqForm, options) 
{
	return true;
}
function showResponse(redata, statusText)  
{
	if(statusText == 'success')
	{
		if(redata==1)
		{
			document.getElementById("error").innerHTML = "Data added successfully.";
			document.getElementById('postform').reset();
		}
		else if(redata==0)
		{
			document.getElementById("error").innerHTML = "This URL is alrady used please try another.";
		}
	}
	$('#postform').unbind();
	$('#postform').bind();
	/*$('#postform').unbind('submit').bind('submit',function(){});*/
}

/* ADD NEW POST FORM COMPLETE FUNCTIONS*/
</script>
</body>
</html>
