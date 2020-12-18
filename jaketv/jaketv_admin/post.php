<?php
include("secure/config.php");
include("checksession.php");

if (isset($_REQUEST['postid'])) {
    if ($_REQUEST['publish'] == '0') {
        $query = "UPDATE `tbl_post` SET `publish`='1' WHERE `postid`=" . $_REQUEST['postid'];
        $run_query = qry_runQuery("UPDATE `tbl_post` SET `publish`='1' WHERE `postid`=" . $_REQUEST['postid']);
    } else {
        $query = "UPDATE `tbl_post` SET `publish`='0' WHERE `postid`=" . $_REQUEST['postid'];
        $run_query = qry_runQuery("UPDATE `tbl_post` SET `publish`='0' WHERE `postid`=" . $_REQUEST['postid']);
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
                            .block_innerdiv{background-image:url(images/loader.GIF);height:103px;width:100px;display:inline-block;z-index:1102;}
                            .block_outerdiv{width:100%;opacity:0.87;display:none;position:absolute;z-index:1102;
                                            text-align:center;background-color:#E7E7E7;ackground-repeat:repeat;}





                            .dropdown dd, .dropdown dt {
                                margin:0px;
                                padding:0px;
                            }
                            .dropdown ul {
                                margin: -1px 0 0 0;
                            }
                            .dropdown dd {
                                position:relative;
                            }
                            .dropdown a, 
                            .dropdown a:visited {
                                color:#fff;
                                text-decoration:none;
                                outline:none;
                                font-size: 16px;
                            }
                            .dropdown dt a {
                                background-color:#fff;
                                display:block;
                                padding: 5px 0px 0px 5px;
                                min-height: 45px;
                                line-height: 12px;
                                overflow: hidden;
                                border:1px solid #ccc;;
                                width:21.5%;
                                font-family:open sans;
                                font-weight:400;
                            }
                            .dropdown dt a span, .multiSel span {
                                cursor:pointer;
                                display:inline-block;
                                padding: 0 1px 2px 0;
                                color:#999999;
                                font-size:16px;
                                font-weight:400;
                                font-family:open sans;
                                margin-top:10px;
                                margin-left:5px;
                            }
                            .dropdown dd ul {
                                background-color: #fff;
                                border:1px solid #ccc;
                                border-top :none;
                                color:#999999;
                                display:none;
                                left:0px;
                                padding: 2px 15px 2px 5px;
                                position:absolute;
                                top:2px;
                                width:21.5%;
                                list-style:none;
                                height: 100px;
                                overflow: auto;
                                font-family:open sans;
                                font-size:16px;
                                font-weight:400;
                            }
                            .dropdown dd ul li:hover
                            {
                                background:#3276B1;
                                color:#fff;
                                width:100%;
                            }
                            .dropdown span.value {
                                display:none;
                            }
                            .dropdown dd ul li a {
                                padding:5px;
                                display:block;
                            }
                            .dropdown dd ul li a:hover {
                                background-color:#fff;
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
                                <?php include("header.php") ?>
                                <div class="inner">
                                    <?php include("header_left.php") ?>
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
                                                                    <div class="btn-group pull-right" style="padding-top:4px;">
                                                                        <button id="editable-sample_new" class="btn btn-primary" onclick="addpost_form()"> Add New <i class="fa fa-plus"></i> </button>
                                                                    </div>
                                                                    <h3 class="content-header">Post Table</h3>
                                                                </div>
                                                                <div class="porlets-content">
                                                                    <div class="table-responsive">
                                                                        <table  class="display table table-bordered table-striped" id="dynamic-table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>S.No</th>
                                                                                    <th>Title</th>
                                                                                    <th id="urldt" style="width:50px;">URL</th>
                                                                                    <th class="center">Image URL</th>
                                                                                    <th class="center">Action</th>
                                                                                    <th class="center">Publish/ Unpublish</th>
                                                                                </tr> 
                                                                            </thead>
                                                                            <tbody id="post_table_body">
                                                                                <?php
                                                                                $qry1 = qry_numRows("SELECT * FROM `tbl_post` WHERE `status`='1'");
                                                                                if ($qry1 > 0) {
                                                                                    $i = 1;
                                                                                    $qry2 = qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' ORDER BY `title` ASC");

                                                                                    foreach ($qry2 as $post_data) {
                                                                                        $qry3 = qry_fetchRow("SELECT * FROM `tbl_category` WHERE `status`='1' AND `catid`='" . $post_data["catid"] . "'");
                                                                                        $qry4 = qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `status`='1' AND `subcatid`='" . $post_data["subcatid"] . "'");
                                                                                        ?>
                                                                                        <tr class="gradeX">
                                                                                            <td onclick="updatepost_form('<?= $post_data["postid"] ?>', '<?= $post_data["catid"] ?>', '<?= $post_data["subcatid"] ?>')" style="cursor:pointer !important;"><?= $i++ ?></td>
                                                                                            <td onclick="updatepost_form('<?= $post_data["postid"] ?>', '<?= $post_data["catid"] ?>', '<?= $post_data["subcatid"] ?>')" style="cursor:pointer !important;"><?= $post_data["title"] ?></td>
                                                                                            <td onclick="updatepost_form('<?= $post_data["postid"] ?>', '<?= $post_data["catid"] ?>', '<?= $post_data["subcatid"] ?>')" style="cursor:pointer !important;width:50px;"><?= substr($post_data["url"],0,50)?></td>
                                                                                            <td class="center" onclick="updatepost_form('<?= $post_data["postid"] ?>', '<?= $post_data["catid"] ?>', '<?= $post_data["subcatid"] ?>')" style="cursor:pointer !important;">
                                                                                                <?php if ($post_data["image"] != "") { ?>
                                                                                                    <img src="<?= $post_data["image"] ?>" style="width:50px;height:50px;" />
                                                                                                <?php } else { ?>
                                                                                                    <img src="images/noimage.gif" style="width:50px;height:50px;" />
                                                                                                <?php } ?>
                                                                                            </td>
                                                                                            <td class="center"> 
                                                                                                <a href="javascript:void(0)" title="Edit Post" onclick="updatepost_form('<?= $post_data["postid"] ?>', '<?= $post_data["catid"] ?>', '<?= $post_data["subcatid"] ?>')" style="cursor:pointer !important;"><i class="fa fa-edit"></i></a> &nbsp; 
                                                                                                <a href="javascript:void(0)" title="Delete Post" onclick="deletepost('<?= $post_data["postid"] ?>')" style="cursor:pointer !important;"><i class="fa fa-trash-o"></i></a>&nbsp;
                                                                        <!--                        <a href="javascript:void(0)" title="Publish Post" onclick="unpublishpost('<?= $post_data["postid"] ?>')" style="cursor:pointer !important;"><i class="fa fa-times"></i></a>
                                                                                                -->						
                                                                                            </td>
                                                                                            <td id="publishdetail">
                                                                                                <?php
                                                                                                if ($post_data['publish'] == 0) {
                                                                                                    ?>
                                                                                                                                        <!--<a href="post.php?postid=<?= $post_data['postid'] ?>&publish=<?= $post_data['publish'] ?>" style="background:#CF000F; padding:5px 10px; color:#fff;text-decoration:none;border-radius:2px;">Unpublish</a> -->
                                                                                                    <a onclick="unpublishpost('<?= $post_data["postid"] ?>')"   style="line-height:4.429;background:#CF000F;cursor:pointer;padding:5px 10px; color:#fff;text-decoration:none;border-radius:2px;">Unpublished</a>
                                                                                                    <?php
                                                                                                } else {
                                                                                                    ?>
                                            <!--							<a href="post.php?postid=<?= $post_data['postid'] ?>&publish=<?= $post_data['publish'] ?>" style="background:#26A65B; padding:5px 17px; color:#fff;text-decoration:none;border-radius:2px;">Publish</a>
                                                                                                    -->							
                                                                                                    <a onclick="publishpost('<?= $post_data["postid"] ?>')"  style="line-height:4.429;background:#26A65B;cursor:pointer; padding:5px 10px; color:#fff;text-decoration:none;border-radius:2px;">Published</a>

                                                                                                <?php } ?> 
                                                                                            </td>
                                                                                        </tr>
                                                                                        <?php
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

                            <?php //include("popup_chat.php");  ?>

                            <script src="js/jquery-2.1.0.js"></script>
                            <script src="js/jquery.form.js"></script> 
                            <script src="js/bootstrap.min.js"></script> 
                            <script src="js/common-script.js"></script> 
                            <script src="js/jquery.slimscroll.min.js"></script> 
                            <script src="plugins/data-tables/jquery.dataTables.js"></script> 
                            <script src="plugins/data-tables/DT_bootstrap.js"></script> 
                            <script src="plugins/data-tables/dynamic_table_init.js"></script> 
                            <script src="plugins/edit-table/edit-table.js"></script> 
                            <script>
							jQuery(document).ready(function () {
								EditableTable.init();
							});
                            </script> 
                            <script src="js/jPushMenu.js"></script> 
                            <script src="js/side-chats.js"></script>
                            <script language="javascript" type="text/javascript">

				function dropdown_slide() {
					$('#dropdown_ul').slideToggle('fast');
				}

				function dropdown_check(x) {
					var cc = 'check_id' + x;
					var dd = document.getElementById(cc).value;

					var cc1 = 'check_id1' + x;


					var title = title = dd + ",";

					if (document.getElementById(cc1).checked == true) {
						var html = '<span title="' + title + '">' + title + '</span>';
						$('#multiSel').append(html);
						$("#hida").hide();
					} else {
						$('span[title="' + title + '"]').remove();
						var ret = $("#hida");
						$('#dropdown_a').append(ret);
					}

				}















				function loader_show()
				{
					var v = jQuery(document).height();
					var wheight = jQuery(window).height();
					var wheight = parseInt(wheight) / parseInt(2);
					var scrolling = jQuery(window).scrollTop();
					var $marginTop = parseInt(wheight) + parseInt(scrolling) - parseInt(50);

					var v2 = parseInt(v) - parseInt($marginTop);
					jQuery("#div_loader2").css({'margin-top': $marginTop});
					document.getElementById('div_loader').style.height = v + 'px';
					jQuery('#div_loader').fadeIn();
				}

				function loader_hide()
				{
					jQuery('#div_loader').fadeOut(1000);
				}

				function logout()
				{
					var siteurl = '<?= $_SESSION["ADMINPATH"] ?>';
					$.ajax({
						url: 'ajaxdata.php',
						type: 'post',
						data: 'logoutdata=1',
						success: function (data)
						{
							if (data == '1')
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
				function addcategory()
				{
					window.location.href = '<?= $_SESSION["ADMINPATH"] ?>category.php';
				}
				function addpost_form()
				{
					loader_show();
					$.ajax({
						url: 'ajaxdata.php',
						type: 'post',
						data: 'addpost_form=1',
						success: function (returndata)
						{
							loader_hide();
							document.getElementById("reloaddiv").innerHTML = returndata;
						}
					});
				}
				function subcategory_show(catid)
				{
					loader_show();
					$.ajax({
						url: 'ajaxdata.php',
						type: 'post',
						data: 'subcategory_show=1&catid=' + catid,
						success: function (returndata)
						{
							loader_hide();
							document.getElementById("reloaddiv_subcat").innerHTML = returndata;
						}
					});
				}


				/* ADD NEW POST FORM START FUNCTIONS*/

				function addpost_insert()
				{
					var urlvalid = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
					var max_file_size = 130000000;
					var title = $("#title").val();
					var catid = $("#catid").val();
					//var subcatid = $("#subcatid").val();
					var postimage = $("#postimage").val();
					var postfiletype = postimage.slice(-3);
					var urlpost = $("#url").val();
					var description = $("#description").val();


					var catid = [];
					var i = 1;
					$("input[type=checkbox]:checked").each(function () {
						catid[i] = $(this).val();
						i++;
					});


					if (title == "")
					{
						document.getElementById("error").innerHTML = "Please enter title.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('title').focus();
						}, 5000)
						return false;
					}
					else if (catid == "")
					{
						document.getElementById("error").innerHTML = "Please select category.";
						setTimeout(function () {
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
					else if ((postimage != "") && (postfiletype != "jpg" && postfiletype != "png" && postfiletype != "peg" && postfiletype != "gif" && postfiletype != "JPG" && postfiletype != "PNG" && postfiletype != "PEG" && postfiletype != "GIF"))
					{
						document.getElementById("error").innerHTML = "Image must be like in jpg, png, jpeg or gif format.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('postimage').focus();
						}, 5000)
						return false;
					}
					else if ((postimage != "") && (document.getElementById('postimage').files[0].size > max_file_size))
					{
						document.getElementById("error").innerHTML = "Image size must not larger than 10MB.";
						setTimeout(function () {
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
					else if (urlpost == "")
					{
						document.getElementById("error").innerHTML = "Please enter post URL.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('url').focus();
						}, 5000)
						return false;
					}
					else if (urlvalid.test(urlpost) == false)
					{
						document.getElementById("error").innerHTML = "Invalid URL.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('url').focus();
						}, 5000)
						return false;
					}
					else if (description == "")
					{
						document.getElementById("error").innerHTML = "Please enter description of post.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('description').focus();
						}, 5000)
						return false;
					}
					else
					{
						loader_show();
						var options = {
							beforeSubmit: showRequest,
							success: showResponse,
							url: "ajaxdata.php",
							type: "POST"
						};
						$('#postform').submit(function () {
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
					if (statusText == 'success')
					{
						loader_hide();
						if (redata == 1)
						{
							location.reload();
						}
						else if (redata == 0)
						{
							document.getElementById("error").innerHTML = "This URL is alrady used please try another.";
						}
					}
					$('#postform').unbind();
					$('#postform').bind();
					/*$('#postform').unbind('submit').bind('submit',function(){});*/
				}

				/* ADD NEW POST FORM COMPLETE FUNCTIONS*/

				function updatepost_form(postid, catid, subcatid)
				{
					loader_show();
					$.ajax({
						url: 'ajaxdata.php',
						type: 'post',
						data: 'updatepost_form=1&postid=' + postid + '&catid=' + catid + '&subcatid=' + subcatid,
						success: function (returndata)
						{
							loader_hide();
							document.getElementById("reloaddiv").innerHTML = returndata;
						}
					});
				}

				/* EDIT POST FORM START FUNCTIONS*/

				function editpost_update()
				{
					var urlvalid = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
					var max_file_size = 130000000;
					var title = $("#title").val();
					var catid = $("#catid").val();
					var subcatid = $("#subcatid").val();
					var postimage = $("#postimage").val();
					var postfiletype = postimage.slice(-3);
					var urlpost = $("#url").val();
					var description = $("#description").val();


					if (title == "")
					{
						document.getElementById("error").innerHTML = "Please enter title.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('title').focus();
						}, 5000)
						return false;
					}
					else if (catid == "")
					{
						document.getElementById("error").innerHTML = "Please select category.";
						setTimeout(function () {
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
					else if ((postimage != "") && (postfiletype != "jpg" && postfiletype != "png" && postfiletype != "peg" && postfiletype != "gif" && postfiletype != "JPG" && postfiletype != "PNG" && postfiletype != "PEG" && postfiletype != "GIF"))
					{
						document.getElementById("error").innerHTML = "Image must be like in jpg, png, jpeg or gif format.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('postimage').focus();
						}, 5000)
						return false;
					}
					else if ((postimage != "") && (document.getElementById('postimage').files[0].size > max_file_size))
					{
						document.getElementById("error").innerHTML = "Image size must not larger than 10MB.";
						setTimeout(function () {
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
					else if (urlpost == "")
					{
						document.getElementById("error").innerHTML = "Please enter post URL.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('url').focus();
						}, 5000)
						return false;
					}
					else if (urlvalid.test(urlpost) == false)
					{
						document.getElementById("error").innerHTML = "Invalid URL.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('url').focus();
						}, 5000)
						return false;
					}
					else if (description == "")
					{
						document.getElementById("error").innerHTML = "Please enter description of post.";
						setTimeout(function () {
							document.getElementById("error").innerHTML = '';
							document.getElementById('description').focus();
						}, 5000)
						return false;
					}
					else
					{
						loader_show();
						var options = {
							beforeSubmit: showRequest2,
							success: showResponse2,
							url: "ajaxdata.php",
							type: "POST"
						};
						$('#postform').submit(function () {
							$(this).ajaxSubmit(options);
							return false;
						});
					}
				}

				function showRequest2(formData, jqForm, options)
				{
					return true;
				}
				function showResponse2(redata, statusText)
				{
					if (statusText == 'success')
					{
						loader_hide();
						if (redata == 1)
						{
							location.reload();
						}
						else if (redata == 0)
						{
							document.getElementById("error").innerHTML = "This URL is alrady used please try another.";
						}
					}
					$('#postform').unbind();
					$('#postform').bind();
					/*$('#postform').unbind('submit').bind('submit',function(){});*/
				}


				/* EDIT POST FORM COMPLETE FUNCTIONS*/

				function deletepost(postid)
				{
					if (confirm("Are you sure want to delete this post?"))
					{
						loader_show();
						$.ajax({
							url: 'ajaxdata.php',
							type: 'post',
							data: 'deletepost=1&postid=' + postid,
							success: function (returndata)
							{
								loader_hide();
								if (returndata == '1')
								{
									location.reload();
								}
							}
						});
					}
				}

				/*function unpublishpost(postid)
				 {
				 if(confirm("Are you sure want to unpublish this post?"))
				 {
				 loader_show();
				 $.ajax( {
				 url : 'ajaxdata.php', 
				 type : 'post',
				 data: 'unpublishpost=1&postid='+postid,				
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
				 }*/
				function unpublishpost(postid)
				{
					$.ajax({
						url: 'ajaxdata.php',
						type: 'post',
						data: 'unpublishpost=1&postid=' + postid,
						success: function (data)
						{
							if(data == '0'){
								alert('0');
							}else{
								$('#post_table_body').html(''); 
							   $('#post_table_body').append(data); 
							}
							//$("#publishdetail").html();
						}
					});
				}
				function publishpost(postid)
				{
					$.ajax({
						url: 'ajaxdata.php',
						type: 'post',
						data: 'publishpost=1&postid=' + postid,
						success: function (data)
						{
							if(data == '0'){
							   alert('0'); 
							}else{
							   $('#post_table_body').html(''); 
							   $('#post_table_body').append(data); 
							}
							//$("#publishdetail").html();
						}
					});
				}
				
</script>
<?php //include("header_right.php");  ?>
<?php //include("footer.php");  ?>
</body>
</html>
