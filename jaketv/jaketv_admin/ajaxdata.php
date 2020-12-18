<?php
include("secure/config.php");

/*LOGIN START*/
if(isset($_POST["logindata"]) && $_POST["logindata"]!='')
{
	$email = $_POST["email"];
	$pass = $_POST["password"];
	$password = md5(stripcslashes($pass));
	$sel_user = mysql_query("SELECT * FROM `tbl_admin` WHERE `email`='".$email."' AND `password`='".$password."'") or die('Error at query:'.$sel_user.'at Line:'.__LINE__);
	$numdatalog = mysql_num_rows($sel_user);
	if($numdatalog > 0)
	{
		$data = mysql_fetch_assoc($sel_user);
		$_SESSION['admin_user_id'] = $data['adminid'];
		$_SESSION['admin_email']	= $data['email'];
		$_SESSION['admin_name']	= $data['name'];
		if(isset($_POST['login-check']) && $_POST['login-check']==1)
		{
			$name=$_POST['email'];
			setcookie("username", $name,time()+60*60*24*30);
			$pswd=$_POST['password'];
			setcookie("userpassword",$pswd,time()+60*60*24*30);
		}
		echo "1";
	}
	else
	{
		echo "0";
	}
}
/*LOGIN COMPLETE*/

/*LOGOUT START*/
if(isset($_POST["logoutdata"]) && $_POST["logoutdata"]!='')
{
	unset($_SESSION['admin_user_id']);
	unset($_SESSION['admin_email']);
	session_destroy();
	echo "1";
}
/*LOGOUT COMPLETE*/

/*FORGOT PASSWORD START*/
if(isset($_POST["forgotpassword"]) && $_POST["forgotpassword"])
{
	?>
            <div class="panel-heading" style="background-color:transparent;color:#8E6464;">
            <h3 class="panel-title">Forgot Password</h3>
            </div>
            <form role="form" id="userform" name="userform" method="post" action="" class="form-horizontal" style="padding:5px 25px 0 20px;">
            <div class="form-group" id="error" style="height:15px;color:#F00;font-size:16px;margin-top:-5px;"></div>
            <div class="form-group">
            <div class="col-sm-10">
                <input type="text" id="forgot_email" name="forgot_email" placeholder="Email" class="form-control" autofocus>
            </div>
            </div>
            <div class="form-group">
            <div class=" col-sm-10">
                <input class="btn btn-primary btn-lg btn-block bs" type="button" name="btn_save" value="Login" id="submit" onClick="forgotpasssendmail()">
            </div>
            </div>
            <div class="form-group">
            <div class="col-sm-10" style="text-align:center;font-size:18px;">
                <a href="javascript:void(0)" onClick="backtologin()" style="color:#fff !important;cursor:pointer;text-decoration:underline;">BACK TO LOGIN</a>
            </div>
            </div>
            </div>
            </div>
            </form>
    <?php
}
if(isset($_POST["forgotpasssendmail"]) && $_POST["forgotpasssendmail"]!="")
{
	$email = $_POST["email"];
	$selectemail = mysql_query("SELECT * FROM `tbl_admin` WHERE `email`='".$email."'") or die('Error at query:'.$selectemail.'at Line:'.__LINE__) ;
	$numemail = mysql_num_rows($selectemail);
	$data = mysql_fetch_assoc($selectemail);
	if($numemail > 0)
	{
		$userid = $data["adminid"];
		$htmlbody = 'Hi, <br/> <br/> Please click on below link to reset your JAKETV admin account password. <br/> <br/> <a href="'.$siteadmin.'globalreset.php?secure='.$userid.'&personaladd='.$email.'">'.$siteadmin.'globalreset.php?secure='.$userid.'&personaladd='.$email.'</a>';
		$subject = 'FORGOT PASSWORD';
		require 'phpmailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP(); 
		$mail->Host = 'smtp.gmail.com';    
		$mail->SMTPAuth = true;
		$mail->Username = 'amit.hjdimensions@gmail.com';
		$mail->Password = 'hj*&^gr##k%$#WATER';
		$mail->SMTPSecure = 'tls';
		$mail->From = 'no-reply@jaketv.com';
		$mail->FromName = 'JAKETV';
		$mail->addAddress($email);
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $htmlbody;
		$mail->send();
		echo "1";
	}
	else
	{
		echo "0";
	}
}
/*FORGOT PASSWORD COMPLETE*/

/*BACK TO LOGIN START*/
if(isset($_POST["backtologin"]) && $_POST["backtologin"])
{}
/*BACK TO LOGIN COMPLETE*/

/*CHANGE PASSWORD START*/
if(isset($_POST["changepassword"]) && $_POST["changepassword"])
{
	$oldpass = md5(stripcslashes($_POST["oldpass"]));
	$userid = $_POST["userid"];
	$email = $_POST["email"];
	$password = md5(stripcslashes($_POST["password"]));
	
	$selpass = mysql_query("SELECT * FROM `tbl_admin` WHERE `adminid`='".$userid."' AND `email`='".$email."' AND `password`='".$oldpass."'") or die('Error at query:'.$selpass.'at Line:'.__LINE__);
	$numold = mysql_num_rows($selpass);
	if($numold > 0)
	{
		$updatepass = mysql_query("UPDATE `tbl_admin` SET `password`='".$password."' WHERE `adminid`='".$userid."' AND `email`='".$email."'") or die('Error at query:'.$updatepass.'at Line:'.__LINE__);
		echo "1";
	}
	else
	{
		echo "0";
	}
}
/*CHANGE PASSWORD COMPLETE*/


/*RESET ADMIN PASSWORD COMPLETE*/
if(isset($_POST["resetpass_admin"]) && $_POST["resetpass_admin"]=="1")
{
	$check_user = mysql_query("SELECT * FROM `tbl_admin` WHERE `adminid`='".$_POST["adminid"]."' AND `email`='".$_POST["email"]."'");
	$num = mysql_num_rows($check_user);
	if($num > 0)
	{
		$update = mysql_query("UPDATE `tbl_admin` SET `password`='".md5($_POST["new_pass"])."' WHERE `adminid`='".$_POST["adminid"]."' AND `email`='".$_POST["email"]."' ");
		echo "1";
	}
	else
	{
		echo "2";
	}
}
/*RESET ADMIN PASSWORD COMPLETE*/


/*BANNER ADD FORM START*/
if(isset($_POST["deleteuser"]))
{
	$userid = $_POST["userid"];
	$qry1 = qry_runQuery("UPDATE `tbl_user` SET `status`='2' WHERE `userid`='".$userid."'");
	echo "1";
}
/*CHANGE PASSWORD COMPLETE*/

								/*CATEGORY CATEGORY CATEGORY
								CATEGORY CATEGORY CATEGORY
								CATEGORY CATEGORY CATEGORY
								CATEGORY CATEGORY CATEGORY*/

/*Category ADD FORM START*/
if(isset($_POST["addcategory_form"]) && $_POST["addcategory_form"]!="")
{
	?>
    <div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
    <form id="pass_change" name="pass_change" method="post" action="">
    <div class="form-group">
    <label>Category</label>
    <input name="category" id="category" type="text" placeholder="Enter Category Name" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <input type="button" class="btn btn-primary btn-lg btn-block bs" style="width:108px;" value="Save" onclick="addcategory_insert()">
    <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
    </form>
    <?php
}
/*Category ADD FORM COMPLETE*/

/*Category ADD INSERT START*/
if(isset($_POST["addcategory_insert"]) && $_POST["addcategory_insert"]!="")
{
	$category = trim($_POST["category"]);
	$qry1 = qry_numRows("SELECT * FROM `tbl_category` WHERE `category`='".addslashes($category)."' AND `status`='1'");
	if($qry1 > 0)
	{
		echo "0"; //Error already exist
	}
	else
	{
		$rnum = mt_rand();
		$qry2 = qry_runQuery("INSERT INTO `tbl_category` (`catidu`,`category`,`status`,`cr_date`,`modify_date`) VALUES ('".$rnum."','".addslashes($category)."','1',NOW(),NOW())");
		echo "1";
	}
}
/*Category ADD INSERT COMPLETE*/

/*Category EDIT FORM START*/
if(isset($_POST["updatecategory_form"]) && $_POST["updatecategory_form"]!="")
{
	$catid = $_POST["catid"];
	$category = $_POST["category"];
	?>
    <div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
    <form id="pass_change" name="pass_change" method="post" action="">
    <div class="form-group">
    <label>Category</label>
    <input name="category" id="category" type="text" value="<?=$category?>" placeholder="Enter Category Name" parsley-trigger="change" class="form-control" style="width:220px !important;">
    <input name="catid" id="catid" type="hidden" value="<?=$catid?>">
    </div>
    <input type="button" class="btn btn-primary btn-lg btn-block bs" style="width:108px;" value="Save" onclick="updatecategory_update()">
    <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
    </form>
    <?php
}
/*Category EDIT FORM COMPLETE*/

/*Category UPDATE START*/
if(isset($_POST["updatecategory_update"]) && $_POST["updatecategory_update"]!="")
{
	$catid = $_POST["catid"];
	$category = trim($_POST["category"]);
	$qry1 = qry_numRows("SELECT * FROM `tbl_category` WHERE `category`='".addslashes($category)."' AND `status`='1' AND `catid`!='".$catid."'");
	if($qry1 > 0)
	{
		echo "0"; //Error already exist
	}
	else
	{
		$qry2 = qry_runQuery("UPDATE `tbl_category` SET `category`='".addslashes($category)."',`modify_date`=NOW() WHERE `catid`='".$catid."'");
		echo "1";
	}
}
/*Category UPDATE COMPLETE*/

/*DELETE CATEGORY START*/
if(isset($_POST["deletecategory"]))
{
	$catid = $_POST["catid"];
	$qry1 = qry_runQuery("UPDATE `tbl_category` SET `status`='2' WHERE `catid`='".$catid."'");
	echo "1";
}
/*DELETE CATEGORY COMPLETE*/


								/*SUBCATEGORY SUBCATEGORY SUBCATEGORY
								SUBCATEGORY SUBCATEGORY SUBCATEGORY
								SUBCATEGORY SUBCATEGORY SUBCATEGORY
								SUBCATEGORY SUBCATEGORY SUBCATEGORY*/

/*Sub Category ADD FORM START*/
if(isset($_POST["addsubcategory_form"]) && $_POST["addsubcategory_form"]!="")
{
	$qry1 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
	?>
    <div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
    <form id="pass_change" name="pass_change" method="post" action="">
    <div class="form-group">
    <label>Category</label>
    <select name="catid" id="catid" class="form-control" style="width:220px !important;">
    	<option value="">--SELECT CATEGORY--</option>
        <?php
		foreach($qry1 as $category_select)
		{
			echo '<option value="'.$category_select["catidu"].'" style="font-size:15px;height:25px;">'.$category_select["category"].'</option>';
		}
		?>
    </select>
    </div>
    <div class="form-group">
    <label>Sub Category</label>
    <input name="subcategory" id="subcategory" type="text" placeholder="Enter Sub Category Name" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <input type="button" class="btn btn-primary btn-lg btn-block bs" style="width:108px;"value="Save" onclick="addsubcategory_insert()">
    <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
    </form>
    <?php
}
/*Sub Category ADD FORM COMPLETE*/

/*Sub Category ADD INSERT START*/
if(isset($_POST["addsubcategory_insert"]) && $_POST["addsubcategory_insert"]!="")
{
	$catid = $_POST["catid"];
	$subcategory = trim($_POST["subcategory"]);
	$qry1 = qry_numRows("SELECT * FROM `tbl_sub_category` WHERE `catidu`='".$catid."' AND `subcategory`='".addslashes($subcategory)."' AND `status`='1'");
	if($qry1 > 0)
	{
		echo "0"; //Error already exist
	}
	else
	{
		$rnum = mt_rand();
		$qry2 = qry_runQuery("INSERT INTO `tbl_sub_category` (`subcatidu`,`catidu`,`subcategory`,`status`,`cr_date`,`modify_date`) VALUES ('".$rnum."','".$catid."','".addslashes($subcategory)."','1',NOW(),NOW())");
		echo "1";
	}
}
/*Sub Category ADD INSERT COMPLETE*/

/*Sub Category EDIT FORM START*/
if(isset($_POST["updatesubcategory_form"]) && $_POST["updatesubcategory_form"]!="")
{
	$catid = $_POST["catid"];
	$subcatid = $_POST["subcatid"];
	$subcategory = $_POST["subcategory"];
	$qry1 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
	?>
    <div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
    <form id="pass_change" name="pass_change" method="post" action="">
    <div class="form-group">
    <label>Category</label>
    <select name="catid" id="catid" class="form-control" style="width:220px !important;">
    	<option value="">--SELECT CATEGORY--</option>
        <?php
		foreach($qry1 as $category_select)
		{
			?>
			<option value="<?=$category_select["catidu"]?>" <?php if($category_select["catidu"]==$catid){?>selected<?php } ?> style="font-size:15px;height:25px;"><?=$category_select["category"]?></option>
			<?php
		}
		?>
    </select>
    </div>
    <div class="form-group">
    <label>Sub Category</label>
    <input name="subcategory" id="subcategory" type="text" value="<?=$subcategory?>" placeholder="Enter Sub Category Name" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <input type="button" class="btn btn-primary btn-lg btn-block bs" style="width:108px;" value="Save" onclick="updatesubcategory_update('<?=$subcatid?>')">
    <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
    </form>
    <?php
}
/*Sub Category EDIT FORM COMPLETE*/


/*Sub Category UPDATE START*/
if(isset($_POST["updatesubcategory_update"]) && $_POST["updatesubcategory_update"]!="")
{
	$catid = $_POST["catid"];
	$subcatid = $_POST["subcatid"];
	$subcategory = trim($_POST["subcategory"]);
	$qry1 = qry_numRows("SELECT * FROM `tbl_sub_category` WHERE `subcategory`='".addslashes($subcategory)."' AND `status`='1' AND `subcatidu`!='".$subcatid."'");
	if($qry1 > 0)
	{
		echo "0"; //Error already exist
	}
	else
	{
		$qry2 = qry_runQuery("UPDATE `tbl_sub_category` SET `catidu`='".$catid."',`subcategory`='".addslashes($subcategory)."',`modify_date`=NOW() WHERE `subcatid`='".$subcatid."'");
		echo "1";
	}
}
/*Sub Category UPDATE COMPLETE*/

/*DELETE SUBCATEGORY START*/
if(isset($_POST["deletesubcategory"]))
{
	$subcatid = $_POST["subcatid"];
	$qry1 = qry_runQuery("UPDATE `tbl_sub_category` SET `status`='2' WHERE `subcatid`='".$subcatid."'");
	echo "1";
}
/*DELETE SUBCATEGORY COMPLETE*/


if(isset($_POST["subcategory_show"]))
{
	$catid = $_POST["catid"];
	$qry1 = qry_fetchRows("SELECT * FROM `tbl_sub_category` WHERE `status`='1' AND `catidu`='".$catid."' ORDER BY `subcategory` ASC");
	?>
    <label>Sub Category</label>
    <select name="subcatid" id="subcatid" class="form-control" style="width:220px !important;">
    	<option value="">--SELECT SUB CATEGORY--</option>
        <?php
		foreach($qry1 as $subcategory_select)
		{
			echo '<option value="'.$subcategory_select["subcatidu"].'" style="font-size:15px;height:25px;">'.$subcategory_select["subcategory"].'</option>';
		}
		?>
    </select>
    <?php
}						

														/*POST POST POST
														POST POST POST
														POST POST POST
														POST POST POST*/


/*POST ADD FORM START*/
if(isset($_POST["addpost_form"]) && $_POST["addpost_form"]!="")
{
	$qry1 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
	?>
    <div class="btn-group pull-right" style="padding-top:4px;">
        <button id="editable-sample_new" class="btn btn-primary" onclick="addcategory()">Add Category <i class="fa fa-plus"></i> </button>
    </div>
    <br/>
    <div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
    <form id="postform" class="postform" name="postform" action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label>Title</label>
    <input name="title" id="title" type="text" placeholder="Enter Post Title" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <label>Category</label>        
    <dl class="dropdown"> 
        <dt>
            <a onClick="dropdown_slide()" id="dropdown_a">
              <span class="hida" id="hida">SELECT CATEGORY</span>
              <p class="multiSel" id="multiSel"></p>  
            </a>
        </dt>
        <dd>
            <div class="mutliSelect">
                <ul id="dropdown_ul">
                <?php
                            //$qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
                            foreach($qry1 as $category_select)
                            { ?>
                                <li style="cursor:pointer">
                                    <input type="hidden" id="check_id<?php echo $category_select["catidu"]; ?>" value="<?php echo $category_select["category"]; ?>" />
                                    <input type="checkbox" id="check_id1<?php echo $category_select["catidu"]; ?>" onClick="dropdown_check(<?php echo $category_select["catidu"]; ?>)"  name="catid[]" value="<?php echo $category_select["catidu"]; ?>" /><?php echo $category_select["category"]; ?>
                                </li>
                            <?php }
                            ?>
                <?php
                //$qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1'  ORDER BY `category` ASC");
               // foreach($qry2 as $category_select2)
                //{
               // echo '<li><input type="checkbox"  value="'.$category_select2["category"].'">'.$category_select2["category"].'</li>';
               // }
                ?> 
                </ul>
            </div>
        </dd>
    </dl>
    <!--<div class="form-group">
    <label>Category</label>
    <select name="catid" id="catid" class="form-control" onChange="subcategory_show(this.value)" style="width:220px !important;">
    	<option value="">--SELECT CATEGORY--</option>
        <?php
		/*foreach($qry1 as $category_select)
		{
			echo '<option value="'.$category_select["catidu"].'" style="font-size:15px;height:25px;">'.$category_select["category"].'</option>';
		}*/
		?>
    </select>
    </div>-->
    <!--<div class="form-group" id="reloaddiv_subcat">
    <label>Sub Category</label>
    <select name="subcatid" id="subcatid" class="form-control" style="width:220px !important;">
    	<option value="">--SELECT SUB CATEGORY--</option>
    </select>
    </div>-->
    <div class="form-group">
    <label>Post Image</label>
    <input name="postimage" id="postimage" type="file" parsley-trigger="change" class="form-control" style="padding:0px !important; width:220px !important;">
    </div>
    <div class="form-group">
    <label>URL</label>
    <input name="url" id="url" type="text" placeholder="Enter URL" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <div class="form-group">
    <label>Kicker Line</label>
    <input name="kicker" id="kicker" type="text" placeholder="Enter Kicker Line" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <div class="form-group">
    <label>Source</label>
    <input name="source" id="source" type="text" placeholder="Enter Source" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <div class="form-group">
    <label>Description</label>
    <textarea name="description" id="description" class="form-control" style="width:220px !important;"></textarea>
    </div>
    <input type="hidden" name="insert_post" id="insert_post"  class="form-control">
    <input type="submit" class="btn btn-primary btn-lg btn-block bs" style="width:108px;" name="btn_save" id="submit" value="Save" onclick="return addpost_insert()">
    <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
    </form>
	<?php
}


/*POST INSERT Functionality START*/
if(isset($_POST["insert_post"]))
{

	$title = addslashes($_POST["title"]);
	$catid = implode(',',$_POST["catid"]);
	//$subcatid = $_POST["subcatid"];
	$url = trim($_POST["url"]);
	$description = addslashes($_POST["description"]);
	$postimageurl = "";
	
	$qry1 = qry_numRows("SELECT * FROM `tbl_post` WHERE `status`='1' AND `title`='".$title."' AND `url`='".$url."'");
	if($qry1 == 0)
	{
		if(isset($_FILES["postimage"]["name"]) && $_FILES["postimage"]["name"]!="")
		{
			$postimagename = $_FILES["postimage"]["name"];
			$post_image = date("dmyHis").$postimagename;
			move_uploaded_file($_FILES["postimage"]["tmp_name"],$upload_postimage.$post_image);
			$postimageurl = $download_postimage.$post_image;
		}
		$qry2 = qry_runQuery("INSERT INTO `tbl_post` (`title`,`catid`,`image`,`url`,`description`,`totalpostlikes`,`status`,`cr_date`,`modify_date`,`kicker`,`source`,`publish`) VALUES ('".addslashes($title)."','".$catid."','".$postimageurl."','".$url."','".addslashes($description)."','0','1',NOW(),NOW(),'".$_POST['kicker']."','".$_POST['source']."','1')");
		echo "1";
	}
	else
	{
		echo "0";
	}
}
/*POST INSERT Functionality COMPLETE*/

/*POST EDIT FORM START*/
if(isset($_POST["updatepost_form"]))
{
	$postid = $_POST["postid"];
	$catid = $_POST["catid"];
	$cc = explode(',',$catid);
	
	for($i=0; $i<count($cc); $i++){
		$s = qry_fetchRow("SELECT * FROM `tbl_category` WHERE `status`='1' AND `catidu`='".$cc[$i]."'");
		
		$d[] = $s['category'];
	}
	$c = implode(',',$d);
	$subcatid = $_POST["subcatid"];
	
	$q = qry_fetchRow("SELECT * FROM `tbl_category` WHERE `status`='1' AND `catidu`='".$c."'");
	
	$qry1 = qry_fetchRow("SELECT * FROM `tbl_post` WHERE `status`='1' AND `postid`='".$postid."'");
	$qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
	$qry3 = qry_fetchRows("SELECT * FROM `tbl_sub_category` WHERE `status`='1' AND `catidu`='".$qry1['catid']."' ORDER BY `subcategory` ASC");
	?>
    <div id="error" style="color:#F00;font-size:16px;margin-top:5px;margin-bottom:5px;"></div>
    <form id="postform" class="postform" name="postform" action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label>Title</label>
    <input name="title" id="title" type="text" value="<?=$qry1["title"]?>" placeholder="Enter Post Title" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <label>Category</label>        
    <dl class="dropdown"> 
        <dt>
            <a href="#" onClick="dropdown_slide()" id="dropdown_a" style="color:black;">
              <!--<span class="hida" id="hida">SELECT CATEGORY</span>-->
              <p class="multiSel" id="multiSel" style="line-height:1.4"><?php 
			  		foreach($d as $a){ ?>
						<span title="<?php echo $a; ?>,"><?php echo $a; ?>,</span>
					<?php }
				?></p>  
            </a>
        </dt>
        <dd>
            <div class="mutliSelect">
                <ul id="dropdown_ul">
                <?php
                            //$qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `category` ASC");
                            foreach($qry2 as $category_select)
                            { ?>
                                <li style="cursor:pointer">
                                    <input type="hidden" id="check_id<?php echo $category_select["catidu"]; ?>" value="<?php echo $category_select["category"]; ?>" />
                                    <input type="checkbox" id="check_id1<?php echo $category_select["catidu"]; ?>" onClick="dropdown_check(<?php echo $category_select["catidu"]; ?>)"  name="catid[]" value="<?php echo $category_select["catidu"]; ?>"<?php echo (in_array($category_select["catidu"],$cc)) ? 'checked="checked"' : ' '; ?> /><?php echo $category_select["category"]; ?>
                                </li>
                            <?php }
                            ?>
                <?php
                //$qry2 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1'  ORDER BY `category` ASC");
               // foreach($qry2 as $category_select2)
                //{
               // echo '<li><input type="checkbox"  value="'.$category_select2["category"].'">'.$category_select2["category"].'</li>';
               // }
                ?> 
                </ul>
            </div>
        </dd>
    </dl>
    <!--<div class="form-group">
    <label>Category</label>
    <select name="catid" id="catid" class="form-control" onChange="subcategory_show(this.value)" style="width:220px !important;">
        <?php
		/*foreach($qry2 as $category_select)
		{
			?>
            <option value="<?=$category_select["catidu"]?>" <?php if($category_select["catidu"]==$catid){ ?>selected="selected"<?php } ?> style="font-size:15px;height:25px;"><?=$category_select["category"]?></option>
            <?php
		}*/
		?>
    </select>
    </div>-->
    <!--<div class="form-group" id="reloaddiv_subcat">
    <label>Sub Category</label>
    <select name="subcatid" id="subcatid" class="form-control" style="width:220px !important;">
        <?php
		/*foreach($qry3 as $subcategory_select)
		{
			?>
            <option value="<?=$subcategory_select["subcatidu"]?>" <?php if($subcategory_select["subcatidu"]==$subcatid){?>selected<?php } ?> style="font-size:15px;height:25px;"><?=$subcategory_select["subcategory"]?></option>
            <?php
		}*/
		?>
    </select>
    </div>-->
    <div class="form-group">
    <label>Post Image</label>
    <input name="postimage" id="postimage" type="file" parsley-trigger="change" class="form-control" style="padding:0px !important;width:220px !important;">
    </div>
    <div class="form-group">
    <?php if($qry1["image"]!=""){ ?>
    <img src="<?=$qry1["image"]?>" style="width:100px;height:100px;"/ >
    <?php }else { ?>
    <img src="images/noimage.gif" style="width:100px;height:100px;"/ >
    <?php } ?>
    </div>
    <div class="form-group">
    <label>URL</label>
    <input name="url" id="url" type="text" value="<?=$qry1["url"]?>" placeholder="Enter URL" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <div class="form-group">
    <label>Kicker Line</label>
    <input name="kicker" id="kicker" type="text" placeholder="Enter Kicker Line" value="<?=$qry1["kicker"]?>" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <div class="form-group">
    <label>Source</label>
    <input name="source" id="source" type="text" placeholder="Enter Source" value="<?=$qry1["source"]?>" parsley-trigger="change" class="form-control" style="width:220px !important;">
    </div>
    <div class="form-group">
    <label>Description</label>
    <textarea name="description" id="description" class="form-control" style="width:220px !important;"><?=$qry1["description"]?></textarea>
    </div>
    <div class="form-group">
    <label>Create Date</label>
    <input type="text" value="<?=date('d-m-Y',strtotime($qry1["cr_date"]))?>"  parsley-trigger="change" class="form-control" style="width:220px !important;" disabled>
    </div>
    <div class="form-group">
    <label>Modify Date</label>
    <input type="text" value="<?=date('d-m-Y',strtotime($qry1["modify_date"]))?>"  parsley-trigger="change" class="form-control" style="width:220px !important;" disabled>
    </div>
    <input type="hidden" name="edit_post" id="edit_post"  class="form-control">
    <input type="hidden" name="postid" id="postid" value="<?=$postid?>"  class="form-control">
    <input type="submit" class="btn btn-primary btn-lg btn-block bs" style="width:108px;" name="btn_save" id="submit" value="Save" onclick="return editpost_update()">
    <input type="button" class="btn btn-default btn-lg bs" style="width:108px;" value="Cancel" onclick="cancel()">
    </form>
    <?php
}
/*POST EDIT FORM COMPLETE*/

if(isset($_POST["edit_post"]))
{
	$title = $_POST["title"];
	$postid = $_POST["postid"];
	$catid = implode(',',$_POST["catid"]);
	//$subcatid = $_POST["subcatid"];
	$url = trim($_POST["url"]);
	$description = $_POST["description"];
	
	$qry1 = qry_numRows("SELECT * FROM `tbl_post` WHERE `status`='1' AND `title`='".addslashes($title)."' AND `url`='".$url."' AND `postid`!='".$postid."'");
	if($qry1 == 0)
	{
		if(isset($_FILES["postimage"]["name"]) && $_FILES["postimage"]["name"]!="")
		{
			$postimagename = $_FILES["postimage"]["name"];
			$post_image = date("dmyHis").$postimagename;
			move_uploaded_file($_FILES["postimage"]["tmp_name"],$upload_postimage.$post_image);
			$postimageurl = $download_postimage.$post_image;
			$update_image = qry_runQuery("UPDATE `tbl_post` SET `image`='".$postimageurl."',`modify_date`=NOW() WHERE `postid`='".$postid."'");
		}
		
		
		$qry2 = qry_runQuery("UPDATE `tbl_post` SET `title`='".addslashes($title)."',`catid`='".$catid."',`url`='".$url."',`description`='".addslashes($description)."',`modify_date`=NOW(),`kicker`='".$_POST['kicker']."',`source`='".$_POST['source']."' WHERE `postid`='".$postid."'");
		echo "1";
	}
	else
	{
		echo "0";
	}
}

/*DELETE POST START*/
if(isset($_POST["deletepost"]))
{
	$postid = $_POST["postid"];
	$qry1 = qry_runQuery("UPDATE `tbl_post` SET `status`='2' WHERE `postid`='".$postid."'");
	echo "1";
}
/*DELETE POST COMPLETE*/

/* UNPUBLISH POST */
/*if(isset($_POST['unpublishpost']))
{
	$postid = $_POST['postid'];
	$qry_unpublish =qry_runQuery("UPDATE `tbl_post` SET `publish`='0' WHERE `postid`='".$postid."'");
	echo "1";
}*/
/* UNPUBLISH COMPLETE */


if (isset($_POST['unpublishpost'])) {
    $postid = $_POST['postid'];
    $qry_unpublish = qry_runQuery("UPDATE `tbl_post` SET `publish`='1' WHERE `postid`='" . $postid . "'");
    if ($qry_unpublish) {
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
                    <td onclick="updatepost_form('<?= $post_data["postid"] ?>', '<?= $post_data["catid"] ?>', '<?= $post_data["subcatid"] ?>')" style="cursor:pointer !important;"><?= substr($post_data["url"],0,50) ?></td>
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
                            <a onclick="unpublishpost('<?= $post_data["postid"] ?>')" style="line-height:4.429;background:#CF000F; padding:5px 17px; cursor:pointer;color:#fff;text-decoration:none;border-radius:2px;">Unpublished</a>
                            <?php
                        } else {
                            ?>
                    <!--							<a href="post.php?postid=<?= $post_data['postid'] ?>&publish=<?= $post_data['publish'] ?>" style="background:#26A65B; padding:5px 17px; color:#fff;text-decoration:none;border-radius:2px;">Publish</a>
                            -->							
                            <a onclick="publishpost('<?= $post_data["postid"] ?>')" style="line-height:4.429;background:#26A65B; padding:5px 17px;cursor:pointer; color:#fff;text-decoration:none;border-radius:2px;">Published</a>

                        <?php } ?> 
                    </td>
                </tr>
                <?php
            }
        }
    } else {
        echo '0';
    }
}

if (isset($_POST['publishpost'])) {
    $postid = $_POST['postid'];
    $qry_unpublish = qry_runQuery("UPDATE `tbl_post` SET `publish`='0' WHERE `postid`='" . $postid . "'");
    if ($qry_unpublish) {
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
                    <td onclick="updatepost_form('<?= $post_data["postid"] ?>', '<?= $post_data["catid"] ?>', '<?= $post_data["subcatid"] ?>')" style="cursor:pointer !important;"><?= substr($post_data["url"],0,50) ?></td>
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
                            <a onclick="unpublishpost('<?= $post_data["postid"] ?>')" style="line-height:4.429;cursor:pointer;background:#CF000F; padding:5px 10px; color:#fff;text-decoration:none;border-radius:2px;">Unpublished</a>
                            <?php
                        } else {
                            ?>
                    <!--							<a href="post.php?postid=<?= $post_data['postid'] ?>&publish=<?= $post_data['publish'] ?>" style="background:#26A65B; padding:5px 17px; color:#fff;text-decoration:none;border-radius:2px;">Publish</a>
                            -->							
                            <a onclick="publishpost('<?= $post_data["postid"] ?>')" style="line-height:4.429;cursor:pointer;background:#26A65B; padding:5px 17px; color:#fff;text-decoration:none;border-radius:2px;" style="margin-top:10px;">Published</a>

                        <?php } ?> 
                    </td>
                </tr>
                <?php
            }
        }
    } else {
        echo '0';
    }
}

?>