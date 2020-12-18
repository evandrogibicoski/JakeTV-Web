<?php
error_reporting(0);
header('Content-type: application/json; charset=utf-8');
include('../jaketv_admin/secure/config.php');
$output = $param = array();

// if no parameter pass then throw error
if(!isset($_REQUEST) || count($_REQUEST) == 0) 
{
  $output[] = "Incorrect Data supplied";
  echo json_encode(array(
      'status'  =>0,
      'output'  =>$output
  ));
  exit;
}
$data = $_REQUEST["data"]; // here pass data from webservice in implode with %22
$data = stripcslashes($data); // explode by %22 like {"first_name":"Amit",} result
$data = str_replace("\/","",$data); // here if \ or/ find then pass blank
$dataparam = json_decode($data,true); // decode all data here
$METHODforCASE = $dataparam['method']; // here we take private variable for switch case. All case are called method or web service name
extract($dataparam); // all data will be VARIABLE

switch($METHODforCASE) 
{
	// (1)Registration Web Service
	case 'Registration':
		if(isset($userid) && $userid=="0")  // New Registration
		{
			/*$pst = array();
			$post_datas = array();
			$qry_check = qry_numRows("SELECT * FROM `tbl_category` AS `tc` 
									  INNER JOIN `tbl_post` AS `tp` ON `tc`.`catid`=`tp`.`catid` 
									  INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatid`
									  WHERE `tc`.`selected`='1'");
			if($qry_check > 0)
			{
				$qry0 = qry_fetchRows("SELECT * FROM `tbl_category` AS `tc` 
									  INNER JOIN `tbl_post` AS `tp` ON `tc`.`catid`=`tp`.`catid` 
									  INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatid`
									  WHERE `tc`.`selected`='1' ORDER BY `tp`.`cr_date` DESC");
				foreach($qry0 as $qry0_data)
				{
					$pst["postid"] = $qry0_data["postid"];
					$pst["title"] = $qry0_data["title"];
					$pst["catid"] = $qry0_data["catid"];
					$pst["category"] = $qry0_data["category"];
					$pst["subcatid"] = $qry0_data["subcatid"];
					$pst["subcategory"] = $qry0_data["subcategory"];
					$pst["image"] = $qry0_data["image"];
					$pst["url"] = $qry0_data["url"];
					$pst["description"] = $qry0_data["description"];
					$pst["totalpostlikes"] = $qry0_data["totalpostlikes"];
					$post_datas[] = $pst;
				}
			}*/
			
			if($googleplusid != 0 )//for social check Google
			{
				
				$qry044 = qry_numRows("SELECT * FROM `tbl_user` WHERE `status`=1 AND `email`='".$email."'");
				if($qry044 > 0)
				{
					$qry045 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `status`=1 AND `email`='".$email."'");
					//print_r($qry045);
					$qry0014 = qry_runQuery("UPDATE `tbl_user` SET `googleplusid`='".$googleplusid."', `fname`='".$fname."',`lname`='".$lname."' , `modify_date`=NOW() WHERE `userid`='".$qry045['userid']."' AND `status`='1'");	
					$param = array('success' =>1,'msg' =>'Profile Update successfully.','googleplusid'=>$googleplusid,'userid' =>$qry045['userid'],'fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>'','picture'=>$qry045['picture']);
				}
				else
				{
					$qry4 = qry_numRows("SELECT * FROM `tbl_user` WHERE `status`='1' AND `googleplusid`='".$googleplusid."'");
					if($qry4 > 0) // check exist or not, if not then insert new, else pass all data of same Google id user's
					{
						$qry5 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `googleplusid`='".$googleplusid."' AND `status`='1'");
						$param = array('success' =>1,'msg' =>'Login Successfully.','googleplusid'=>$googleplusid,'userid' =>$qry5['userid'],'fname'=>$qry5['fname'],'lname'=>$qry5['lname'],'email'=>$qry5['email'],'password'=>$qry5["password"],'picture'=>$qry5["picture"]); //Response
					}
					else
					{
						$picture="";
						$qry6 = qry_insertedId("INSERT INTO `tbl_user` (`googleplusid`,`fname`,`lname`,`email`,`password`,`picture`,`status`,`cr_date`,`modify_date`) VALUES 
						('".$googleplusid."','".$fname."','".$lname."','".$email."','','".$picture."','1',NOW(),NOW())"); 
						$param = array('success' =>1,'msg' =>'Profile added successfully.','googleplusid'=>$googleplusid,'userid' =>$qry6,'fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>'','picture'=>$picture); //Response
					}	
				}
			}
			else //for Non-social check and using email
			{
				$qry10 = qry_numRows("SELECT * FROM `tbl_user` WHERE `email`='".$email."' AND `status`='1'");
				if($qry10 > 0)
				{
					$param = array('success'=>0,'msg'=>'User Already Registered.');
				}
				else
				{
					$pictureurl = "";
					if(isset($_FILES["picture"]["name"]) && $_FILES["picture"]["name"]!="")
					{
						$picturename = $_FILES["picture"]["name"];
						$picture_image = date("dmyHis").$picturename;
						move_uploaded_file($_FILES["picture"]["tmp_name"],$upload_userprofile.$picture_image);
						$pictureurl = $download_userprofile.$picture_image;
					}
					$qry11 = qry_insertedId("INSERT INTO `tbl_user` (`googleplusid`,`fname`,`lname`,`email`,`password`,`picture`,`status`,`cr_date`,`modify_date`) VALUES 
					('0','".$fname."','".$lname."','".$email."','".$password."','".$pictureurl."','1',NOW(),NOW())"); 
					$param = array('success' =>1,'msg' =>'Profile added successfully.','userid' =>$qry11,'fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$password,'picture'=>''); //Response
				}
			}
		}
		else
		{
			$qry12 = qry_numRows("SELECT * FROM `tbl_user` WHERE `userid`='".$userid."' AND `status`='1'");
			if($qry12 > 0)
			{
				if(isset($_FILES["picture"]["name"]) && $_FILES["picture"]["name"]!="")
				{
					$picturename = $_FILES["picture"]["name"];
					$picture_image = date("dmyHis").$picturename;
					move_uploaded_file($_FILES["picture"]["tmp_name"],$upload_userprofile.$picture_image);
					$pictureurl = $download_userprofile.$picture_image;
					$qry13 = qry_runQuery("UPDATE `tbl_user` SET `picture`='".$pictureurl."' WHERE `userid`='".$userid."' AND `status`='1'");
				}
				$qry14 = qry_runQuery("UPDATE `tbl_user` SET `fname`='".$fname."',`lname`='".$lname."',`email`='".$email."',`modify_date`=NOW() WHERE `userid`='".$userid."' AND `status`='1'");
				$qry_pass_14 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `userid`='".$userid."'");
				$param = array('success' =>1,'msg' =>'Profile added successfully.','userid' =>$userid,'fname'=>$qry_pass_14["fname"],'lname'=>$qry_pass_14["lname"],'email'=>$qry_pass_14["email"],'password'=>$qry_pass_14["password"],'picture'=>$qry_pass_14["picture"]); //Response
			}
			else
			{
				$param = array('success'=>0,'msg'=>'Profile can not update.'); 
			}
		}
	echo TranslateNull($param);
	break;
	
	case 'Login':
		if(isset($email) && isset($password))
		{
				/*$pst = array();
				$post_datas = array();
				$qry_check = qry_numRows("SELECT * FROM `tbl_category` AS `tc` 
										  INNER JOIN `tbl_post` AS `tp` ON `tc`.`catid`=`tp`.`catid` 
										  INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatid`
										  WHERE `tc`.`selected`='1'");
				if($qry_check > 0)
				{
					$qry0 = qry_fetchRows("SELECT * FROM `tbl_category` AS `tc` 
										  INNER JOIN `tbl_post` AS `tp` ON `tc`.`catid`=`tp`.`catid` 
										  INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatid`
										  WHERE `tc`.`selected`='1' ORDER BY `tp`.`cr_date` DESC");
					foreach($qry0 as $qry0_data)
					{
						$pst["postid"] = $qry0_data["postid"];
						$pst["title"] = $qry0_data["title"];
						$pst["catid"] = $qry0_data["catid"];
						$pst["category"] = $qry0_data["category"];
						$pst["subcatid"] = $qry0_data["subcatid"];
						$pst["subcategory"] = $qry0_data["subcategory"];
						$pst["image"] = $qry0_data["image"];
						$pst["url"] = $qry0_data["url"];
						$pst["description"] = $qry0_data["description"];
						$pst["totalpostlikes"] = $qry0_data["totalpostlikes"];
						$post_datas[] = $pst;
					}
				}*/
				
				$qry_login = qry_numRows("SELECT * FROM `tbl_user` WHERE `status`='1' AND `email`='".$email."' AND `password`='".$password."'");
				if($qry_login > 0) 
				{
					$qry_pass = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `status`='1' AND `email`='".$email."' AND `password`='".$password."'");
					$param = array('success' =>1,'msg' =>'Login Successfully.','googleplusid'=>$qry_pass['googleplusid'],'userid' =>$qry_pass['userid'],'fname'=>$qry_pass['fname'],'lname'=>$qry_pass['lname'],'email'=>$qry_pass['email'],'password'=>$qry_pass["password"],'picture'=>$qry_pass["picture"],"status"=>"Active"); //Response
				}
				else
				{
					$param = array('success' =>0,'msg' =>'Please enter valid username and password.'); //Response
				}
		}
	echo TranslateNull($param);
	break;
	
	// (2)Forgot Password Web Service
	case 'ForgotPassword':
		if(isset($email))
		{
			$qry15 = qry_numRows("SELECT * FROM `tbl_user` WHERE `email`='".$email."' AND `status`='1'");
			if($qry15 > 0)
			{
				$qry16 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `email`='".$email."' AND `status`='1'");
				$userid = $qry16["userid"];
				$htmlbody = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml"><head>
								<title>Legitkicks</title>
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
								<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
								<style type="text/css">
								body{margin:0px;padding:0px;text-align:left;}
								html{width: 100%; }
								img {border:0px;text-decoration:none;display:block; outline:none;}
								a,a:hover{color:#FFF;text-decoration:none;}.ReadMsgBody{width: 100%; background-color: #ffffff;}.ExternalClass{width: 100%; background-color: #ffffff;}
								table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }  
								img[class=imageScale]{}
								.divater-bottom{ border-bottom:#eeeff1 solid 1px;}
								.space1{padding:35px 35px 35px 35px;}
								.contact-space{padding:15px 24px 15px 24px;}
								table[class=social]{ text-align:right;}
								.contact-text{font:Bold 14px Arial, Helvetica, sans-serif; color:#FFF; padding-left:4px;}
								.border-bg{ border-top:#986258 solid 4px; background:#11BCFA;}
								.borter-inner-bottom{ border-bottom:#e24851 solid 1px;}
								.borter-inner-top{ border-top:#f2767d solid 1px;}
								.borter-footer-bottom{ border-bottom:#ececec solid 1px; border-top:#eb5e66 solid 3px;}
								.borte-footer-inner-borter{ border-bottom:#cf4850 solid 3px;}
								.header-space{padding:0px 20px 0px 20px;}
								@media only screen and (max-width:640px)
								{
								body{width:auto!important;}
								.main{width:440px !important;margin:0px; padding:0px;}
								.two-left{width:440px !important; text-align: center!important;}
								.two-left-inner{width: 376px !important; text-align: center!important;}
								.header-space{padding:30px 0px 30px 0px;}
								}
								@media only screen and (max-width:479px)
								{
								body{width:auto!important;}
								.main{width:280px !important;margin:0px; padding:0px;}
								.two-left{width: 280px !important; text-align: center!important;}
								.two-left-inner{width: 216px !important; text-align: center!important;}
								.space1{padding:35px 0px 35px 0px;}
								table[class=social]{ width:100%; text-align:center; margin-top:20px;}
								table[class=contact]{ width:100%; text-align:center; font:12px;}
								.contact-space{padding:15px 0px 15px 0px;}
								.header-space{padding:30px 0px 30px 0px;}
								}
								</style>
								<style class="firebugResetStyles" type="text/css" charset="utf-8">
								.firebugResetStyles {
								z-index: 2147483646 !important;
								top: 0 !important;
								left: 0 !important;
								display: block !important;
								border: 0 none !important;
								margin: 0 !important;
								padding: 0 !important;
								outline: 0 !important;
								min-width: 0 !important;
								max-width: none !important;
								min-height: 0 !important;
								max-height: none !important;
								position: fixed !important;
								transform: rotate(0deg) !important;
								transform-origin: 50% 50% !important;
								border-radius: 0 !important;
								box-shadow: none !important;
								background: transparent none !important;
								pointer-events: none !important;
								white-space: normal !important;
								}
								style.firebugResetStyles {
								display: none !important;
								}
								.firebugBlockBackgroundColor {
								background-color: transparent !important;
								}
								.firebugResetStyles:before, .firebugResetStyles:after {
								content: "" !important;
								}
								.firebugCanvas {
								display: none !important;
								}
								.firebugLayoutBox {
								width: auto !important;
								position: static !important;
								}
								
								.firebugLayoutBoxOffset {
								opacity: 0.8 !important;
								position: fixed !important;
								}
								.firebugLayoutLine {
								opacity: 0.4 !important;
								background-color: #000000 !important;
								}
								.firebugLayoutLineLeft, .firebugLayoutLineRight {
								width: 1px !important;
								height: 100% !important;
								}
								.firebugLayoutLineTop, .firebugLayoutLineBottom {
								width: 100% !important;
								height: 1px !important;
								}
								.firebugLayoutLineTop {
								margin-top: -1px !important;
								border-top: 1px solid #999999 !important;
								}
								.firebugLayoutLineRight {
								border-right: 1px solid #999999 !important;
								}
								.firebugLayoutLineBottom {
								border-bottom: 1px solid #999999 !important;
								}
								.firebugLayoutLineLeft {
								margin-left: -1px !important;
								border-left: 1px solid #999999 !important;
								}
								.firebugLayoutBoxParent {
								border-top: 0 none !important;
								border-right: 1px dashed #E00 !important;
								border-bottom: 1px dashed #E00 !important;
								border-left: 0 none !important;
								position: fixed !important;
								width: auto !important;
								}
								.firebugRuler{
								position: absolute !important;
								}
								.firebugRulerH {
								top: -15px !important;
								left: 0 !important;
								width: 100% !important;
								height: 14px !important;
								border-top: 1px solid #BBBBBB !important;
								border-right: 1px dashed #BBBBBB !important;
								border-bottom: 1px solid #000000 !important;
								}
								.firebugRulerV {
								top: 0 !important;
								left: -15px !important;
								width: 14px !important;
								height: 100% !important;
								border-left: 1px solid #BBBBBB !important;
								border-right: 1px solid #000000 !important;
								border-bottom: 1px dashed #BBBBBB !important;
								}
								.overflowRulerX > .firebugRulerV {
								left: 0 !important;
								}
								.overflowRulerY > .firebugRulerH {
								top: 0 !important;
								}
								.fbProxyElement {
								position: fixed !important;
								pointer-events: auto !important;
								}
								a.CSS3_Button {
								display: inline-block;
								border: 1px solid #986258;
								padding: 8px 18px;
								text-decoration: none;
								color: #FFFFFF;
								font-size: 13px;
								font-weight: bold;
								font-family: Arial, Helvetica, sans-serif;
								width:180px;
								}
								#Theme-a {
								background:  #986258;
								}
								#Theme-a:hover {
								background: #986258;
								}
								</style>
								</head>
								<body>
								<table class="main-bg" cellpadding="0" cellspacing="0" align="center" border="0" width="100%">
								  <tbody>
									<tr>
										<td style="padding:50px 0px 50px 0px;" align="center" valign="top">
											<table class="main" cellpadding="0" cellspacing="0" align="center" border="0" width="600">
												<tbody>
													<tr>
														<td align="left" valign="top">
															<table class="main" cellpadding="0" cellspacing="0" align="center" border="0" width="600">
																<tbody>
																	<tr>
																		<td style="padding:30px 20px 30px 20px;background:#986258;" class="border-bg" align="left" valign="top">
																			<table cellpadding="0" cellspacing="0" align="center" border="0" width="100%">
																				<tbody>
																					<tr>
																						<td style="font:normal 12px Arial, Helvetica, sans-serif; color:#FFF; background:#986258;" align="left" valign="middle" width="100%">	
																								<img src="http://52.0.55.172/jaketv/jaketv_admin/images/jakelogo.png" style="width:100px; float:left;">
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td valign="top">
															<table class="main" cellpadding="0" cellspacing="0" border="0" width="600">
																<tbody>
																	<tr>
																		<td style="background-color:#f7f7f7; text-align:justify; font:normal 15px Arial, Helvetica, sans-serif;line-height:18px; padding:20px 25px 20px 25px;" valign="top">
																		 Hi, <br/> <br/> Please click on below link to reset your JAKETV account password.
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr>
														<td align="left" valign="top">
															<table class="main" cellpadding="0" cellspacing="0" border="0" width="600">
																<tbody>
																	<tr>
																		<td style="background-color:#f7f7f7; text-align:center; font:normal 16px Arial, Helvetica, sans-serif;line-height:18px; padding-top:0px; padding-bottom:15px;" align="left" bgcolor="#ffffff" valign="top">
																		<a href="'.$sitefront.'headerlocation.php?id='.$userid.'" class="CSS3_Button" id="Theme-a" style="padding:10px 20px; background:#986258; color:#fff;">Reset Password</a>
																		</td>
																	</tr>
																	<tr>
																		<td style="background-color:#986258; padding:16px 0px 14px 0px;border-bottom:#986258 solid 3px;text-align:center;" class="borte-footer-inner-borter" align="left"  valign="top">
																			<table cellpadding="0" cellspacing="0" align="center" border="0" width="204">
																				<tbody>
																					<tr>
																						<span style="color:#ffffff;">Copyright © 2015 Ohryta</span>
																						<!--<td align="left" valign="top" width="34"><a href="#"><img src="RidioMail_files/facebook-icon.png" alt="" height="28" width="27"></a></td>
																						<td align="left" valign="top" width="34"><a href="#"><img src="RidioMail_files/twitter-icon.png" alt="" height="28" width="27"></a></td>
																						<td align="left" valign="top" width="34"><a href="#"><img src="RidioMail_files/google-icon.png" alt="" height="28" width="27"></a></td>
																						<td align="left" valign="top" width="34"><a href="#"><img src="RidioMail_files/rss-icon.png" alt="" height="28" width="27"></a></td>
																						<td align="left" valign="top" width="34"><a href="#"><img src="RidioMail_files/dripple-icon.png" alt="" height="28" width="27"></a></td>
																						<td align="left" valign="top" width="34"><a href="#"><img src="RidioMail_files/youtube-icon.png" alt="" height="28" width="27"></a></td>-->
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</tbody>
								</table>
								</body>
								</html>';
				$subject = 'RESET PASSWORD';
				require '../jaketv_admin/phpmailer/PHPMailerAutoload.php';
				$mail = new PHPMailer;
				$mail->isSMTP(); 
				$mail->Host = 'smtp.gmail.com';    
				$mail->SMTPAuth = true;
				$mail->Username = 'jaketvmanager@gmail.com'; // amit.hjdimensions@gmail.com
				$mail->Password = '1mazeltov'; //hj*&^gr##k%$#WATER
				$mail->SMTPSecure = 'tls';
				$mail->From = 'no-reply@jaketv.com';
				$mail->FromName = 'JAKETV';
				$mail->addAddress($email);
				$mail->isHTML(true);
				$mail->Subject = $subject;
				$mail->Body = $htmlbody;
				$mail->send();
				
				$param = array('success'=>1,'msg'=>'Please check your email to reset password'); 
			}
			else
			{
				$param = array('success'=>1,'msg'=>'Incorrect email id');
			}
		}
	echo TranslateNull($param);
	break;
	
	// (3)Get Category Web Service
	case 'GetCategory':
		if(isset($userid))
		{
			/*Pagination Sneaker*/
			$PageLimit = 100;
			$numtotal=qry_numRows("SELECT * FROM `tbl_category` WHERE `status`='1'");
			$totalpage=$numtotal/$PageLimit;
			if($numtotal%$PageLimit!=0)
			{
				$totalpage=explode(".",$totalpage);
				$totalpage=$totalpage[0]+1;		
			}	
			$OffSet = $Page*$PageLimit; // Here $Page variable is passing from app side like 0,1,2,3...etc
			/*Pagination Sneaker*/
			
			$alldata = array();
			$responsedata = array();
			$qry17 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY category ASC LIMIT $OffSet,$PageLimit");
			$qry017 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `status`=1 AND `userid`='".$userid."'");
			foreach($qry17 as $qry17_data)
			{
				$subcatarray = array();
				reset($subcatarray);
				
				/*$qry18 = qry_numRows("SELECT * FROM `tbl_sub_category` WHERE `status`='1' AND `catidu`='".$qry17_data["catidu"]."'");
				if($qry18 > 0)
				{
					$qry19 = qry_fetchRows("SELECT * FROM `tbl_sub_category` WHERE `status`='1' AND `catidu`='".$qry17_data["catidu"]."' ORDER BY `cr_date`");
					foreach($qry19 as $qry19_data)
					{
						$subcatdata["subcatid"] = $qry19_data["subcatid"];
						$subcatdata["subcatuniqueid"] = $qry19_data["subcatidu"];
						$subcatdata["subcategory"] = $qry19_data["subcategory"];
						$book = explode(',',$qry017['catid']);
						if(in_array($qry19_data["subcatidu"],$book))
						{
							$subcatdata['isselected']='1';
						}
						else
						{
							$subcatdata['isselected']='0';
						}
						$subcatarray[] = $subcatdata; 
					}
				}*/
				$alldata["catid"] = $qry17_data["catid"];
				$alldata["catuniqueid"] = $qry17_data["catidu"];
				$alldata["category"] = $qry17_data["category"];
				$book = explode(',',$qry017['catid']);
				if(in_array($qry17_data["catidu"],$book))
				{
					$alldata['isselected']='1';
				}
				else
				{
					$alldata['isselected']='0';
				}
				$alldata["subcatdata"] = $subcatarray;
				$responsedata[] = $alldata;
			}
			$param = array('success'=>1,'msg'=>'Category found.','totalpage' => $totalpage,'data'=>$responsedata); //Response
		}
		else
		{
			$param = array('success' =>0,'msg' =>'Post not found.');
		}
	echo TranslateNull($param);
	break;
	
	// (4)Get Post Web Service
	case 'GetPost':
		if(isset($userid) && $userid!="")
		{
			$alldata = array();
			$responsedata = array();
			
			$qry011 = qry_fetchRow("SELECT `catid` FROM `tbl_user` WHERE `userid`='".$userid."'");
			$qry02 = qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");
			//$qry03 = qry_fetchRows("SELECT `subcatidu` FROM `tbl_sub_category` WHERE `selected`='1'");
			foreach($qry02 as $qry02_data){
				$id[] =  $qry02_data['catidu'];
			}
			
			/*foreach($qry03 as $qry03_data)
			{
				$ids[] =  $qry03_data['subcatidu'];	
			}*/
			
			/*$imp_catid = implode(',',$id);
			if($qry011['catid']!='' && !empty($ids))
			{
				$catids = $qry011['catid'].','.$imp_catid.','.implode(',',$ids);
			}
			else if($qry011['catid']=='' && !empty($ids))
			{
				$catids = $imp_catid.','.implode(',',$ids);
			}
			else if($qry011['catid']!='' && empty($ids))
			{
				$catids = $qry011['catid'].','.$imp_catid;
			}
			else
			{
				$catids = $imp_catid;
			}*/
			
			
			$imp_catid = implode(',',$id);
			if($qry011['catid']!='' && !empty($id)){
				$catids = $qry011['catid'].','.$imp_catid;
			}else{
				$catids = $imp_catid;
			}
			$catids = explode(',',$catids);
			$catids = array_unique($catids);
			
			
			foreach($catids as $key=>$d){
				$cat[] = $d;
			}

			for($i=0; $i<count($cat); $i++){
				$id = $cat[$i];
				$qry021 = qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
				$dd[] = $qry021;
			}
			
			foreach($dd as $v1){
				if(is_array($v1)){
					foreach($v1 as $v2){
						$newArray[] = $v2;
					}
				}
			}
			foreach($newArray as $newArray){
				$post_id[] = $newArray['postid'];
			}
			$post_id1 = array_unique($post_id);
			foreach($post_id1 as $k=>$v){
				if($v == ""){$post_id2 = array();}
				else{$post_id2[] = $v;}	
			}
			if(!empty($post_id2)){
				$d = implode(',',$post_id2);
			}else{
				$d = "";	
			}
			
			if($d != ""){
				$PageLimit = 25;
				$numtotal = qry_numRows("SELECT * FROM tbl_post WHERE postid IN (".$d.")");
				
				$totalpage=$numtotal/$PageLimit;
				if($numtotal%$PageLimit!=0)
				{
					$totalpage=explode(".",$totalpage);
					$totalpage=$totalpage[0]+1;		
				}	
				$OffSet = $Page*$PageLimit;
				
				$qry222 = qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") ORDER BY sort_order ASC LIMIT $OffSet,$PageLimit");
				
				foreach($qry222 as $qry21_data)
				{
					
					$alldata["postid"] = $qry21_data["postid"];
					$alldata["title"] = $qry21_data["title"];
					
					$cat = explode(',',$qry21_data["catid"]);
					for($i=0;$i<count($cat);$i++){
						$cat1 = 	qry_fetchRows("select * from tbl_category where catidu='".$cat[$i]."'");
						$cat2[] = $cat1;
					}
					foreach($cat2 as $v1){
						if(is_array($v1)){
							foreach($v1 as $v2){
								@$newArray12[] = $v2;
							}
						}
					}
					if(!empty($newArray12)){	
						foreach($newArray12 as $newArray21){
							$cat_id[] = $newArray21['catidu'];
							$cat_name[] = $newArray21['category'];
						}
					}
					
					
					
					$alldata["catuniqueid"] = implode(',',$cat_id);
					$alldata["category"] = implode(',',$cat_name);
					//$alldata["subcatuniqueid"] = $qry21_data["subcatidu"];
					//$alldata["subcategory"] = $qry21_data["subcategory"];
					$alldata["image"] = $qry21_data["image"];
					$alldata["url"] = $qry21_data["url"];
					$alldata["kickerline"] = $qry21_data["kicker"];
					$alldata["source"] = $qry21_data["source"];
					$alldata["description"] = $qry21_data["description"];
					$alldata["totalpostlikes"] = $qry21_data["totalpostlikes"];
					
					$book = explode(',',$qry21_data['isbookmarked']);
					if(in_array($userid,$book))
					{
						$alldata['isbookmarked']='1';
					}
					else
					{
						$alldata['isbookmarked']='0';
					}
					$like = explode(',',$qry21_data['isliked']);
					if(in_array($userid,$like))
					{
						$alldata['isliked']='1';
					}
					else
					{
						$alldata['isliked']='0';
					}
					$alldata["cr_date"] = $qry21_data["cr_date"];
					$responsedata[] = $alldata;
				}
				$param = array('success'=>1,'msg'=>'Post found','totalpage'=>$totalpage,'data'=>$responsedata);		
			}else{
				$param = array('success'=>1,'msg'=>'Post not found');
			}
			
			
			
					
			
		}
	echo TranslateNull($param);
	break;
	
	
	// (5)Get Post By Category Web Service
	case 'GetPostByCategory':
		if(isset($userid))
		{
			if(isset($catid) && $catid!="0")
			{
				
				/*$selectpost = qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`=1");
				foreach($selectpost as $posts)
				{
					if($posts['subcatid']!=$catid)
					{
						$maincat = "SELECT * FROM `tbl_post` WHERE `status`='1' AND FIND_IN_SET($catid,catid)";
						
						@$resultdata = qry_fetchRows($maincat);
						
						if(!empty($resultdata))
						{
							foreach( @$resultdata as $catdata)
							{
								@$maindata[] = @$catdata;	
							}
							@$resultcat[] = qry_numRows($maincat);
						}
						else
						{
							$maindata = array();
						}
					}
					else
					{
						$subcat = "SELECT * FROM `tbl_post` WHERE `status`='1' AND `subcatid`='".$catid."'";
						$resultsdata = qry_fetchRows($subcat);
						if(!empty($resultsdata))
						{
							foreach($resultsdata as $subcatdata )
							{
								$subdata[] = @$subcatdata;	
							}
							@$resultscat[] = qry_numRows($subcat);
						}
						else
						{
							$subdata = array();
						}
					}
					
					
				}*/
				
				$category_name = qry_fetchRow("SELECT category FROM `tbl_category` WHERE `catidu`=$catid");
					
					$maincat = "SELECT * FROM `tbl_post` WHERE `status`='1' AND FIND_IN_SET($catid,catid)";
						
						@$resultdata = qry_fetchRows($maincat);
						
						if(!empty($resultdata))
						{
							foreach( @$resultdata as $catdata)
							{
								@$maindata[] = @$catdata;	
							}
							@$resultcat[] = qry_numRows($maincat);
						}
						else
						{
							$maindata = array();
						}
				
				/*if(empty($maindata) && empty($subdata))
				{
					$param = array('success'=>1,'msg'=>'Post not found.'); //Response
					echo TranslateNull($param);
					exit;
				}
				else if(empty($maindata))
				{
					$input = array_map("unserialize", array_unique(array_map("serialize", $subdata)));
				}
				else
				{
					$input = array_map("unserialize", array_unique(array_map("serialize", $maindata)));	
				}*/
				
				if(empty($maindata))
				{
					$param = array('success'=>1,'msg'=>'Post not found.'); //Response
					echo TranslateNull($param);
					exit;
				}
				else
				{
					$input = array_map("unserialize", array_unique(array_map("serialize", $maindata)));	
				}
				
				
				if($input!=NULL)
				{
					@$PageLimit = 25;
					@$numtotal = count(@$input);
					@$totalpage=round(@$numtotal/@$PageLimit);
					if($totalpage==0)
					{
						$totalpage = 1;	
					}
					else
					{
						$totalpage = $totalpage;	
					}
					@$response = array();
					if(@$Page==0)
					{
						@$offset = @$Page;
					}
					else
					{
						@$offset = (@$Page*@$PageLimit);	
					}
					
					for(@$i=0;@$i<@$PageLimit;@$i++)
					{
						if(@$i==0)
						{
							@$array_ind = @$i+@$offset; 
						}
						else
						{
							@$array_ind = @$i+@$offset-1; 
						}
						
						if(@$input[@$array_ind]!='')
						{
							if(empty($response))
							{
								
								//$category 	 = qry_fetchRow("SELECT `category` FROM `tbl_category` WHERE `catidu`=".$input[@$array_ind]["catid"]);
								//$subcategory = qry_fetchRow("SELECT `subcategory` FROM `tbl_sub_category` WHERE `subcatidu`=".$input[@$array_ind]["subcatid"]);
								$alldata["postid"] = $input[@$array_ind]["postid"];
								$alldata["title"] = $input[@$array_ind]["title"];
								$alldata["catuniqueid"] = $input[@$array_ind]["catid"];
								$alldata["category"] = $category_name['category'];
								$alldata["subcatuniqueid"] = $input[@$array_ind]["subcatid"];
								//$alldata["subcategory"] = $subcategory['subcategory'];
								$alldata["image"] = $input[@$array_ind]["image"];
								$alldata["url"] = $input[@$array_ind]["url"];
								$alldata["kickerline"] = $input[@$array_ind]["kicker"];
								$alldata["source"] = $input[@$array_ind]["source"];
								$alldata["description"] = $input[@$array_ind]["description"];
								$alldata["totalpostlikes"] = $input[@$array_ind]["totalpostlikes"];
								$book = explode(',',$input[@$array_ind]['isbookmarked']);
								if(in_array($userid,$book))
								{
									$alldata['isbookmarked']='1';
								}
								else
								{
									$alldata['isbookmarked']='0';
								}
								$like = explode(',',$input[@$array_ind]['isliked']);
								if(in_array($userid,$like))
								{
									$alldata['isliked']='1';
								}
								else
								{
									$alldata['isliked']='0';
								}
								$alldata["cr_date"] = $input[@$array_ind]["cr_date"];
								$responsedata[] = $alldata;
							}
							else if( !in_array(@$input[@$array_ind], @$response) ) 
							{
								$category 	 = qry_fetchRow("SELECT `category` FROM `tbl_category` WHERE `catidu`=".$input[@$array_ind]["catid"]);
								$subcategory = qry_fetchRow("SELECT `subcategory` FROM `tbl_sub_category` WHERE `subcatidu`=".$input[@$array_ind]["subcatid"]);
								$alldata["postid"] = $input[@$array_ind]["postid"];
								$alldata["title"] = $input[@$array_ind]["title"];
								$alldata["catuniqueid"] = $input[@$array_ind]["catid"];
								$alldata["category"] = $category['category'];
								$alldata["subcatuniqueid"] = $input[@$array_ind]["subcatid"];
								$alldata["subcategory"] = $subcategory['subcategory'];
								$alldata["image"] = $input[@$array_ind]["image"];
								$alldata["url"] = $input[@$array_ind]["url"];
								$alldata["kickerline"] = $input[@$array_ind]["kicker"];
								$alldata["source"] = $input[@$array_ind]["source"];
								$alldata["description"] = $input[@$array_ind]["description"];
								$alldata["totalpostlikes"] = $input[@$array_ind]["totalpostlikes"];
								$book = explode(',',$input[@$array_ind]['isbookmarked']);
								if(in_array($userid,$book))
								{
									$alldata['isbookmarked']='1';
								}
								else
								{
									$alldata['isbookmarked']='0';
								}
								$like = explode(',',$input[@$array_ind]['isliked']);
								if(in_array($userid,$like))
								{
									$alldata['isliked']='1';
								}
								else
								{
									$alldata['isliked']='0';
								}
								$alldata["cr_date"] = $input[@$array_ind]["cr_date"];
								$responsedata[] = $alldata;
							}
						}
					}
					$outputdata = array_map("unserialize", array_unique(array_map("serialize", $responsedata)));
					foreach($outputdata as $finaldata)
					{
						$responces[] = $finaldata;
					}
					$param = array('success'=>1,'msg'=>'Post found.','totalpage' => $totalpage,'data'=>$responces); //Response
				}
				else
				{
					$param = array('success'=>1,'msg'=>'Post not found.'); //Response
				}
				
			}
		}
	echo TranslateNull($param);
	break;
	
	
	// (6)Like Post Web Service
	case 'LikePost':
		if(isset($userid))
		{
			$qry0 = qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'");
			if($qry0["isliked"]!="")
			{
				$isliked = $qry0["isliked"].','.$userid;
				$update_isliked = qry_runQuery("UPDATE `tbl_post` SET `isliked`='".$isliked."' WHERE `postid`='".$postid."'");
				$exp_isliked = explode(',',$isliked);
				$totallikes = count($exp_isliked);
				$update_totallikes = qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='".$totallikes."' WHERE `postid`='".$postid."'");
			}
			else
			{
				$isliked = $userid;
				$update_isliked = qry_runQuery("UPDATE `tbl_post` SET `isliked`='".$isliked."' WHERE `postid`='".$postid."'");
				$exp_isliked = explode(',',$isliked);
				$totallikes = count($exp_isliked);
				$update_totallikes = qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='".$totallikes."' WHERE `postid`='".$postid."'");
			}
			$param = array('success'=>1,'msg'=>'Post like successfully');
		}
	echo TranslateNull($param);
	break;
	
	
	// (7)Like Post Web Service
	case 'UnLikePost':
		if(isset($userid))
		{
			$qry0 = qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'");
			if($qry0["isliked"]!="")
			{
				$checkin = explode(',',$qry0["isliked"]);
				$index = array_search($userid,$checkin);
				if($index !== false)
				{
					unset($checkin[$index]);
				}
				$totallikes = count($checkin);
				$isliked=implode(',',$checkin);
				$update_isliked = qry_runQuery("UPDATE `tbl_post` SET `isliked`='".$isliked."' WHERE `postid`='".$postid."'");
				$update_totallikes = qry_runQuery("UPDATE `tbl_post` SET `totalpostlikes`='".$totallikes."' WHERE `postid`='".$postid."'");
				$param = array('success'=>1,'msg'=>'Post unlike successfully');
			}
		}
	echo TranslateNull($param);
	break;
	
	
	// (7)Bookmark Post Web Service
	case 'BookmarkPost':
		if(isset($userid))
		{
			$qry0 = qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'");
			if($qry0["isbookmarked"]!="")
			{
				$isbookmarked = $qry0["isbookmarked"].','.$userid;
				$update_isbookmarked = qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='".$isbookmarked."' WHERE `postid`='".$postid."'");
			}
			else
			{
				$isbookmarked = $userid;
				$update_isbookmarked = qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='".$isbookmarked."' WHERE `postid`='".$postid."'");
			}
			$param = array('success'=>1,'msg'=>'Post bookmark successfully');
		}
	echo TranslateNull($param);
	break;
	
	
	// (7)Bookmark Post Web Service
	case 'UnBookmarkPost':
		if(isset($userid))
		{
			$qry0 = qry_fetchRow("SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'");
			if($qry0["isbookmarked"]!="")
			{
				$checkin = explode(',',$qry0["isbookmarked"]);
				$index = array_search($userid,$checkin);
				if($index !== false)
				{
					unset($checkin[$index]);
				}
				$isbookmarked=implode(',',$checkin);
				$update_isbookmarked = qry_runQuery("UPDATE `tbl_post` SET `isbookmarked`='".$isbookmarked."' WHERE `postid`='".$postid."'");
				$param = array('success'=>1,'msg'=>'Post unbookmark successfully');
			}
		}
	echo TranslateNull($param);
	break;
	
	// (8)get Bookmark Post by userid Web Service
	case 'GetBookmarkByUserid':
		if(isset($userid))
		{
			$alldata = array();
			$responsedata = array();
			$qry0 = qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' ORDER BY `cr_date` DESC");
			foreach($qry0 as $qry0_data)
			{
				$checkin = explode(',',$qry0_data["isbookmarked"]);
				if(in_array($userid,$checkin))
				{
					$qry_cat = qry_fetchRow("SELECT * FROM `tbl_category` WHERE `catidu`='".$qry0_data["catid"]."'");
					$qry_subcat = qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `subcatidu`='".$qry0_data["subcatid"]."'");
					
					$alldata["postid"] = $qry0_data["postid"];
					$alldata["title"] = $qry0_data["title"];
					$alldata["catuniqueid"] = $qry0_data["catid"];
					$alldata["category"] = $qry_cat["category"];
					$alldata["subcatuniqueid"] = $qry0_data["subcatid"];
					$alldata["subcategory"] = $qry_subcat["subcategory"];
					$alldata["image"] = $qry0_data["image"];
					$alldata["url"] = $qry0_data["url"];
					$alldata["kickerline"] = $qry0_data["kicker"];
					$alldata["source"] = $qry0_data["source"];
					$alldata["description"] = $qry0_data["description"];
					$alldata["totalpostlikes"] = $qry0_data["totalpostlikes"];
					$book = explode(',',$qry0_data['isbookmarked']);
					if(in_array($userid,$book))
					{
						$alldata['isbookmarked']='1';
					}
					else
					{
						$alldata['isbookmarked']='0';
					}
					$like = explode(',',$qry0_data['isliked']);
					if(in_array($userid,$like))
					{
						$alldata['isliked']='1';
					}
					else
					{
						$alldata['isliked']='0';
					}
					$alldata["sort_order"] = $qry0_data["sort_order"];
					$alldata["cr_date"] = $qry0_data["cr_date"];
					$responsedata[] = $alldata;
				}
			}
			if($responsedata!=NULL)
			{
				@$PageLimit = 25;
				@$numtotal = count(@$responsedata);
				@$totalpage=round(@$numtotal/@$PageLimit);
				if($totalpage==0)
				{
					$totalpage = 1;	
				}
				else
				{
					$totalpage = $totalpage;	
				}
				@$response = array();
				if(@$Page==0)
				{
					@$offset = @$Page;
				}
				else
				{
					@$offset = (@$Page*@$PageLimit);	
				}
				
				for(@$i=0;@$i<@$PageLimit;@$i++)
				{
					if(@$i==0)
					{
						@$array_ind = @$i+@$offset; 
					}
					else
					{
						@$array_ind = @$i+@$offset-1; 
					}
					
					if(@$responsedata[@$array_ind]!='')
					{
						if(empty($response))
						{
							@$response[] = @$responsedata[@$array_ind];	
						}
						else if( !in_array(@$responsedata[@$array_ind], @$response) ) 
						{
							@$response[] = @$responsedata[@$array_ind];
						}
					}
				}
				
				//$response = array_unique(@$response);
				
				$param = array('success'=>1,'msg'=>'Bookmark found','totalpage'=>$totalpage,'data'=>$response);
			}
			else
			{
				$param = array('success'=>0,'msg'=>'No bookmark found'); //Response
			}
		}
	echo TranslateNull($param);
	break;
	
	
	// (9)Get Post Web Service
	case 'GetPostLikeByUserid':
		if(isset($userid))
		{
			$alldata = array();
			$responsedata = array();
			$qry0 = qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' ORDER BY `cr_date` DESC");
			foreach($qry0 as $qry0_data)
			{
				$checkin = explode(',',$qry0_data["isliked"]);
				$index = array_search($userid,$checkin);
				if($index !== false)
				{
					$qry_cat = qry_fetchRow("SELECT * FROM `tbl_category` WHERE `catidu`='".$qry0_data["catid"]."'");
					$qry_subcat = qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `subcatidu`='".$qry0_data["subcatid"]."'");
					
					$alldata["postid"] = $qry0_data["postid"];
					$alldata["title"] = $qry0_data["title"];
					$alldata["catuniqueid"] = $qry0_data["catid"];
					$alldata["category"] = $qry_cat["category"];
					$alldata["subcatuniqueid"] = $qry0_data["subcatid"];
					$alldata["subcategory"] = $qry_subcat["subcategory"];
					$alldata["image"] = $qry0_data["image"];
					$alldata["url"] = $qry0_data["url"];
					$alldata["kickerline"] = $qry0_data["kicker"];
					$alldata["source"] = $qry0_data["source"];
					$alldata["description"] = $qry0_data["description"];
					$alldata["totalpostlikes"] = $qry0_data["totalpostlikes"];
					$book = explode(',',$qry0_data['isbookmarked']);
					if(in_array($userid,$book))
					{
						$alldata['isbookmarked']='1';
					}
					else
					{
						$alldata['isbookmarked']='0';
					}
					$like = explode(',',$qry0_data['isliked']);
					if(in_array($userid,$like))
					{
						$alldata['isliked']='1';
					}
					else
					{
						$alldata['isliked']='0';
					}
					$alldata["sort_order"] = $qry0_data["sort_order"];
					$alldata["cr_date"] = $qry0_data["cr_date"];
					$responsedata[] = $alldata;
				}
			}
			
			if($responsedata!=NULL)
			{
				@$PageLimit = 25;
				@$numtotal = count(@$responsedata);
				@$totalpage=round(@$numtotal/@$PageLimit);
				if($totalpage==0)
				{
					$totalpage=1;
				}
				else
				{
					$totalpage=$totalpage;	
				}
				@$response = array();
				if(@$Page==0)
				{
					@$offset = @$Page;
				}
				else
				{
					@$offset = (@$Page*@$PageLimit);	
				}
				
				for(@$i=0;@$i<@$PageLimit;@$i++)
				{
					if(@$i==0)
					{
						@$array_ind = @$i+@$offset; 
					}
					else
					{
						@$array_ind = @$i+@$offset-1; 
					}
					
					if(@$responsedata[@$array_ind]!='')
					{
						if(empty($response))
						{
							@$response[] = @$responsedata[@$array_ind];	
						}
						else if( !in_array(@$responsedata[@$array_ind], @$response) ) 
						{
							@$response[] = @$responsedata[@$array_ind];
						}
					}
				}
				
				//$response = array_unique(@$response);
				
				$param = array('success'=>1,'msg'=>'Like found','totalpage'=>$totalpage,'data'=>$response);
			}
			else
			{
				$param = array('success'=>0,'msg'=>'No Like found'); //Response
			}
			
		}
	echo TranslateNull($param);
	break;
	
	
	// (10)Select category by user Web Service
	case 'SelectCategoryByUser':
		if(isset($userid))
		{
			$qry0 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `userid`='".$userid."'");
			if($qry0["catid"]!="")
			{
				$catidxyz= $qry0["catid"].','.$catid;
				$update_catidxyz = qry_runQuery("UPDATE `tbl_user` SET `catid`='".$catidxyz."' WHERE `userid`='".$userid."'");
			}
			else
			{
				$catidxyz = $catid;
				$update_catidxyz = qry_runQuery("UPDATE `tbl_user` SET `catid`='".$catidxyz."' WHERE `userid`='".$userid."'");
			}
			$param = array('success'=>1,'msg'=>'Category select successfully');
		}
	echo TranslateNull($param);
	break;
	
	
	// (11)Un Select category by user Web Service
	case 'UnSelectCategoryByUser':
		if(isset($userid))
		{
			$qry0 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `userid`='".$userid."'");
			if($qry0["catid"]!="")
			{
				$checkin = explode(',',$qry0["catid"]);
				$index = array_search($catid,$checkin);
				if($index !== false)
				{
					unset($checkin[$index]);
				}
				$catidxyz=implode(',',$checkin);
				$update_catidxyz = qry_runQuery("UPDATE `tbl_user` SET `catid`='".$catidxyz."' WHERE `userid`='".$userid."'");
				$param = array('success'=>1,'msg'=>'Category unselect successfully');
			}
		}
	echo TranslateNull($param);
	break;
	
	case 'GetSelectedCategory':
		if(isset($userid))
		{
			$qry0 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `userid`='".$userid."'");
			if($qry0["catid"]!="")
			{
				$qry00 = qry_fetchRows("SELECT `catidu` as `catid`,`category` FROM `tbl_category` WHERE `catidu` IN (".$qry0['catid'].") AND `status`=1");
				$qry01 = qry_fetchRows("SELECT `subcatidu` as `catid`,`subcategory` as `category` FROM `tbl_sub_category` WHERE `subcatidu` IN (".$qry0['catid'].") AND `status`=1");
				if(!empty($qry00) && !empty($qry01))
				{
					$array_merge = array_merge($qry00,$qry01);
				}
				else
				{
					if(!empty($qry00))
					{
						$array_merge = $qry00;	
					}
					else
					{
						$array_merge = $qry01;		
					}
				}
				foreach($array_merge as $arraydata)
				{
					$alldata['catid'] = $arraydata['catid'];
					$alldata['category'] = $arraydata['category'];
					$responce[] = $alldata;
				}
				$param = array('success'=>1,'msg'=>'Selected Category Found','data'=>$responce);
			}
			else
			{
				$param = array('success'=>0,'msg'=>'No Selected Category Found');	
			}
			
		}
	echo TranslateNull($param);
	break;
	
	
	case 'GetSearch':
		if(isset($userid) && $userid!="")
		{	
			if(!isset($search) || $search=='')
			{
				$param = array('success'=>0,'msg'=>'Invalid Arguments');	
				echo TranslateNull($param);
				exit;	
			}
			$alldata = array();
			$responsedata = array();
			
			$qry011 = qry_fetchRow("SELECT `catid` FROM `tbl_user` WHERE `userid`='".$userid."'");
			$qry02 = qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");
			//$qry03 = qry_fetchRows("SELECT `subcatidu` FROM `tbl_sub_category` WHERE `selected`='1'");
			foreach($qry02 as $qry02_data){
				$id[] =  $qry02_data['catidu'];
			}
			/*foreach($qry03 as $qry03_data)
			{
				$ids[] =  $qry03_data['subcatidu'];	
			}*/
			
			$imp_catid = implode(',',$id);
			/*if($qry011['catid']!='' && !empty($ids))
			{
				$catids = $qry011['catid'].','.$imp_catid.','.implode(',',$ids);
			}
			else if($qry011['catid']=='' && !empty($ids))
			{
				$catids = $imp_catid.','.implode(',',$ids);
			}
			else if($qry011['catid']!='' && empty($ids))
			{
				$catids = $qry011['catid'].','.$imp_catid;
			}
			else
			{
				$catids = $imp_catid;
			}*/
			
			if($qry011['catid']!='' && !empty($id))
			{
				$catids = $qry011['catid'].','.$imp_catid;
			}
			else
			{
				$catids = $imp_catid;
			}
			
			/*Pagination Sneaker*/
			$PageLimit =25;
			/*$numtotal=qry_numRows("SELECT `tp`.*,`tc`.`catidu`,`tc`.`category`,`tsc`.`subcatidu`,`tsc`.`subcategory` FROM `tbl_category` AS `tc` 
								    INNER JOIN `tbl_post` AS `tp` ON `tc`.`catidu`=`tp`.`catid` 
								    INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatidu`
								    WHERE (`tp`.`catid` IN (".$catids.") OR `tp`.`subcatid` IN (".$catids.")) AND (`tp`.`title` LIKE '%".addslashes($search)."%' OR `tp`.`description` LIKE '%".addslashes($search)."%' OR `tc`.`category` LIKE '%".addslashes($search)."%' OR `tsc`.`subcategory` LIKE '%".addslashes($search)."%' OR `tp`.`kicker` LIKE '%".addslashes($search)."%' OR `tp`.`source` LIKE '%".addslashes($search)."%') ORDER BY `tp`.`postid` DESC");*/

			$numtotal=qry_numRows("SELECT `tp`.*,`tc`.`catidu`,`tc`.`category` FROM `tbl_category` AS `tc` 
								    INNER JOIN `tbl_post` AS `tp` ON `tc`.`catidu`=`tp`.`catid` 
								    WHERE (`tp`.`catid` IN (".$catids.")) AND (`tp`.`title` LIKE '%".addslashes($search)."%' OR `tp`.`description` LIKE '%".addslashes($search)."%' OR `tc`.`category` LIKE '%".addslashes($search)."%' OR `tp`.`kicker` LIKE '%".addslashes($search)."%' OR `tp`.`source` LIKE '%".addslashes($search)."%') ORDER BY `tp`.`postid` DESC");
			
			$totalpage=$numtotal/$PageLimit;
			if($numtotal%$PageLimit!=0)
			{
				$totalpage=explode(".",$totalpage);
				$totalpage=$totalpage[0]+1;		
			}	
			$OffSet = $Page*$PageLimit;
			
			
			
			
			/*$qry222 = qry_fetchRows("SELECT `tp`.*,`tc`.`catidu`,`tc`.`category`,`tsc`.`subcatidu`,`tsc`.`subcategory` FROM `tbl_category` AS `tc` 
								    INNER JOIN `tbl_post` AS `tp` ON `tc`.`catidu`=`tp`.`catid` 
								    INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatidu`
								    WHERE (`tp`.`catid` IN (".$catids.") OR `tp`.`subcatid` IN (".$catids.")) AND (`tp`.`title` LIKE '%".addslashes($search)."%' OR `tp`.`description` LIKE '%".addslashes($search)."%' OR `tc`.`category` LIKE '%".addslashes($search)."%' OR `tsc`.`subcategory` LIKE '%".addslashes($search)."%') ORDER BY `tp`.`postid` DESC LIMIT $OffSet,$PageLimit");*/
			
			$qry222 = qry_fetchRows("SELECT `tp`.*,`tc`.`catidu`,`tc`.`category` FROM `tbl_category` AS `tc` 
								    INNER JOIN `tbl_post` AS `tp` ON `tc`.`catidu`=`tp`.`catid` 
								    WHERE (`tp`.`catid` IN (".$catids.")) AND (`tp`.`title` LIKE '%".addslashes($search)."%' OR `tp`.`description` LIKE '%".addslashes($search)."%' OR `tc`.`category` LIKE '%".addslashes($search)."%') ORDER BY `tp`.`postid` DESC LIMIT $OffSet,$PageLimit");
						
			
			
			if(!empty($qry222))
			{
				foreach($qry222 as $qry21_data)
				{
					
					$alldata["postid"] = $qry21_data["postid"];
					$alldata["title"] = $qry21_data["title"];
					$alldata["catuniqueid"] = $qry21_data["catidu"];
					$alldata["category"] = $qry21_data["category"];
					//$alldata["subcatuniqueid"] = $qry21_data["subcatidu"];
					//$alldata["subcategory"] = $qry21_data["subcategory"];
					$alldata["image"] = $qry21_data["image"];
					$alldata["url"] = $qry21_data["url"];
					$alldata["kickerline"] = $qry21_data["kicker"];
					$alldata["source"] = $qry21_data["source"];
					$alldata["description"] = $qry21_data["description"];
					$alldata["totalpostlikes"] = $qry21_data["totalpostlikes"];
					
					$book = explode(',',$qry21_data['isbookmarked']);
					if(in_array($userid,$book))
					{
						$alldata['isbookmarked']='1';
					}
					else
					{
						$alldata['isbookmarked']='0';
					}
					$like = explode(',',$qry21_data['isliked']);
					if(in_array($userid,$like))
					{
						$alldata['isliked']='1';
					}
					else
					{
						$alldata['isliked']='0';
					}
					$alldata["sort_order"] = $qry21_data["sort_order"];
					$alldata["cr_date"] = $qry21_data["cr_date"];
					$responsedata[] = $alldata;
				}
			}
			if(!empty($responsedata))
			{
				$param = array('success'=>1,'msg'=>'Post found','totalpage'=>$totalpage,'data'=>$responsedata);			
			}
			else
			{
				$param = array('success'=>1,'msg'=>'No Post found');		
			}
			
		}
	echo TranslateNull($param);
	break;
	
	case 'ChangePassword':
		if(isset($userid) && $userid!='0' && $userid!='')
		{
			if($password!='')
			{
				$changepassword = "UPDATE `tbl_user` SET password='".$password."' WHERE `userid`='".$userid."'";
				qry_runQuery($changepassword);
				
				$selectuser = "SELECT * FROM `tbl_user` WHERE `userid`=".$userid;
				$resultdata = mysql_query($selectuser);
				$userdata = mysql_fetch_assoc($resultdata);
			
				//print_r($userdata);
			
				$final['googleplusid'] = $userdata['googleplusid'];
				$final['userid'] 	   = $userid;
				$final['fname']	 	   = $userdata['fname'];
				$final['lname']	 	   = $userdata['lname'];
				$final['email']	 	   = $userdata['email'];
				$final['image']		   = $userdata['picture'];
				$final['password']	   = $password;
				$output[]			   = $final;
				
				$param = array('success'=>1,'msg'=>'Password Change Successfully',"data"=>$output);
			}
			else
			{
				$param = array('success'=>0,'msg'=>'Invalid Arguments');	
			}
		}
		echo TranslateNull($param);
		break;
	
	
	default: 
	{
      $result = "Method not defined";
      echo json_encode(array(
          'code'  =>0,
          'output'=>$result
      ));
    } 
}



function InvalidParams()
{
	$output = "Invalid Parameters Supplied";
	echo json_encode(array(
	  'code'  =>0,
	  'output'=>$output
	));
	exit;
}

function terminate($param)
{
	$temp = json_encode($param);
	$temp = str_replace("null",'""',$temp);
	echo $temp;
	exit;
}

function TranslateNull($param)
{
	$temp = json_encode($param);
	$temp = str_replace("null",'""',$temp);
	$temp = str_replace('\r\n','',$temp);
	return  $temp;
}

function escapeJsonString($value) 
{ 
	# list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}


?>