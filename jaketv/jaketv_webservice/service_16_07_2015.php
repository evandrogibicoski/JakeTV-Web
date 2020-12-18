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
					$param = array('success' =>1,'msg' =>'Login Successfully.','userid' =>$qry_pass['userid'],'fname'=>$qry_pass['fname'],'lname'=>$qry_pass['lname'],'email'=>$qry_pass['email'],'password'=>$qry_pass["password"],'picture'=>$qry_pass["picture"]); //Response
				}
				else
				{
					$param = array('success' =>0,'msg' =>'Invalid userid or password.'); //Response
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
				$htmlbody = 'Hi, <br/> <br/> Please click on below link to reset your JAKETV account password. <br/> <br/> <a href="'.$sitefront.'globalreset.php?secure='.$userid.'&personaladd='.$email.'">'.$sitefront.'globalreset.php?secure='.$userid.'&personaladd='.$email.'</a>';
				$subject = 'RESET PASSWORD';
				require '../jaketv_admin/phpmailer/PHPMailerAutoload.php';
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
			$qry17 = qry_fetchRows("SELECT * FROM `tbl_category` WHERE `status`='1' ORDER BY `cr_date` DESC LIMIT $OffSet,$PageLimit");
			$qry017 = qry_fetchRow("SELECT * FROM `tbl_user` WHERE `status`=1 AND `userid`='".$userid."'");
			foreach($qry17 as $qry17_data)
			{
				$subcatarray = array();
				reset($subcatarray);
				
				$qry18 = qry_numRows("SELECT * FROM `tbl_sub_category` WHERE `status`='1' AND `catidu`='".$qry17_data["catidu"]."'");
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
				}
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
			foreach($qry02 as $qry02_data){
				$id[] =  $qry02_data['catidu'];
			}
			$imp_catid = implode(',',$id);
			if($qry011['catid']!='')
			{
				$catids = $qry011['catid'].','.$imp_catid;
			}
			else
			{
				$catids = $imp_catid;
			}
			
			
			/*Pagination Sneaker*/
			$PageLimit =10;
			$numtotal=qry_numRows("SELECT `tp`.*,`tc`.`catidu`,`tc`.`category`,`tsc`.`subcatidu`,`tsc`.`subcategory` FROM `tbl_category` AS `tc` 
								    INNER JOIN `tbl_post` AS `tp` ON `tc`.`catidu`=`tp`.`catid` 
								    INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatidu`
								    WHERE `tp`.`catid` IN (".$catids.") ORDER BY `tp`.`postid` DESC");
			
			$totalpage=$numtotal/$PageLimit;
			if($numtotal%$PageLimit!=0)
			{
				$totalpage=explode(".",$totalpage);
				$totalpage=$totalpage[0]+1;		
			}	
			$OffSet = $Page*$PageLimit;
			
			
			
			
			$qry222 = qry_fetchRows("SELECT `tp`.*,`tc`.`catidu`,`tc`.`category`,`tsc`.`subcatidu`,`tsc`.`subcategory` FROM `tbl_category` AS `tc` 
								    INNER JOIN `tbl_post` AS `tp` ON `tc`.`catidu`=`tp`.`catid` 
								    INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatidu`
								    WHERE `tp`.`catid` IN (".$catids.") ORDER BY `tp`.`postid` DESC LIMIT $OffSet,$PageLimit");
			
			
			foreach($qry222 as $qry21_data)
			{
				
				$alldata["postid"] = $qry21_data["postid"];
				$alldata["title"] = $qry21_data["title"];
				$alldata["catuniqueid"] = $qry21_data["catidu"];
				$alldata["category"] = $qry21_data["category"];
				$alldata["subcatuniqueid"] = $qry21_data["subcatidu"];
				$alldata["subcategory"] = $qry21_data["subcategory"];
				$alldata["image"] = $qry21_data["image"];
				$alldata["url"] = $qry21_data["url"];
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
			/*$qry222 = qry_fetchRows("SELECT `tp`.*,`tc`.`catid`,`tc`.`category`,`tsc`.`subcatid`,`tsc`.`subcategory` FROM `tbl_category` AS `tc` 
								    INNER JOIN `tbl_post` AS `tp` ON `tc`.`catid`=`tp`.`catid` 
								    INNER JOIN `tbl_sub_category` AS `tsc` ON `tp`.`subcatid`=`tsc`.`subcatid`
								    WHERE `tc`.`selected`='1' ORDER BY `tp`.`postid` DESC");
									
			$qry333 =  qry_fetchRow("SELECT `catid` FROM `tbl_user` WHERE `userid`='".$userid."'");
			 
			$exp_catid = explode(',',$qry333['catid']);
			$catidcount = count($exp_catid);
			for($j=0;$j<$catidcount;$j++)
			{
				$qry444[] = qry_fetchRows("SELECT * FROM `tbl_post` where `catid`='".$exp_catid[$j]."' ORDER BY `postid` DESC");
			}
			
			
			
			foreach($qry444 as $qry444_data)
			{
				foreach($qry444_data as $qry444data)
				{
					$qry_cat = qry_fetchRow("SELECT * FROM `tbl_category` WHERE `catid`='".$qry444data["catid"]."'");
					$qry_subcat = qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `subcatid`='".$qry444data["subcatid"]."'");
					
					$alldata["postid"] = $qry444data["postid"];
					$alldata["title"] = $qry444data["title"];
					$alldata["catid"] = $qry444data["catid"];
					$alldata["category"] = $qry_cat["category"];
					$alldata["subcatid"] = $qry_subcat["subcatid"];
					$alldata["subcategory"] = $qry_subcat["subcategory"];
					$alldata["image"] = $qry444data["image"];
					$alldata["url"] = $qry444data["url"];
					$alldata["description"] = $qry444data["description"];
					$alldata["totalpostlikes"] = $qry444data["totalpostlikes"];
					
					$book = explode(',',$qry444data['isbookmarked']);
					if(in_array($userid,$book))
					{
						$alldata['isbookmarked']='1';
					}
					else
					{
						$alldata['isbookmarked']='0';
					}
					$like = explode(',',$qry444data['isliked']);
					if(in_array($userid,$like))
					{
						$alldata['isliked']='1';
					}
					else
					{
						$alldata['isliked']='0';
					}
					$alldata["cr_date"] = $qry444data["cr_date"];
					$responsedata2[] = $alldata;
				}
			}
			$responsedata = array_merge($responsedata2,$responsedata1);
			$input = array_map("unserialize", array_unique(array_map("serialize", $responsedata)));
			
			if($input!=NULL)
			{
				@$PageLimit = 2;
				@$numtotal = count(@$input);
				@$totalpage=round(@$numtotal/@$PageLimit);
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
						@$array_ind = @$i+@$offset; 
					}
					
					if(@$input[@$array_ind]!='')
					{
						if(empty($response))
						{
							@$response[] = @$input[@$array_ind];	
						}
						else if( !in_array(@$input[@$array_ind], @$response) ) 
						{
							@$response[] = @$input[@$array_ind];
						}
					}
				}
				
				
			}
			else
			{
				$param = array('success'=>0,'msg'=>'No Post found'); //Response
			}*/
		}
	echo TranslateNull($param);
	break;
	
	
	// (5)Get Post By Category Web Service
	case 'GetPostByCategory':
		if(isset($userid))
		{
			if(isset($catid) && $catid!="0")
			{
				
				$selectpost = qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`=1");
				foreach($selectpost as $posts)
				{
					if($posts['subcatid']!=$catid)
					{
						$maincat = "SELECT * FROM `tbl_post` WHERE `status`='1' AND `catid`='".$catid."'";
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
				}
				
				if(empty($maindata) && empty($subdata))
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
				}
				
				
				
				if($input!=NULL)
				{
					@$PageLimit = 10;
					@$numtotal = count(@$input);
					@$totalpage=round(@$numtotal/@$PageLimit);
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
					$alldata["cr_date"] = $qry0_data["cr_date"];
					$responsedata[] = $alldata;
				}
			}
			
			if($responsedata!=NULL)
			{
				@$PageLimit = 10;
				@$numtotal = count(@$responsedata);
				@$totalpage=round(@$numtotal/@$PageLimit);
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
					$alldata["cr_date"] = $qry0_data["cr_date"];
					$responsedata[] = $alldata;
				}
			}
			
			if($responsedata!=NULL)
			{
				@$PageLimit = 1;
				@$numtotal = count(@$responsedata);
				@$totalpage=round(@$numtotal/@$PageLimit);
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