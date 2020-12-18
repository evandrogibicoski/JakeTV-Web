<?php 
	include("servicesclass.php");
	$classobj = new servicecalss();
	if(!isset($_REQUEST['data']) || $_REQUEST['data']=='')
	{
		$json_array = array("success"=>"0",
							"msg"=>"data supplied invalid"
		);
		$result = $classobj->TranslateNull($json_array);
		echo $result;
	}
	$jsondata = $_REQUEST['data'];
	$jsondata = stripslashes($jsondata);
	$jsondata = str_replace('\/','',$jsondata);
	$jsondata = json_decode($jsondata,true);
	extract($jsondata);
	
	if(!isset($method) || $method=='')
	{
		$json_array = array("success"=>"0",
							"msg"=>"Method name is invalid"
		);
		$result = $classobj->TranslateNull($json_array);
		echo $result;	
	}
	
	switch($method)
	{
		case 'Registration':
		if(isset($userid) && $userid=="0")  // New Registration
		{
			if($googleplusid != 0 )//for social check Google
			{
				$qry4 = "SELECT * FROM `tbl_user` WHERE `status`='1' AND `googleplusid`='".$googleplusid."'";
				$result = $classobj->runquery($qry4);
				$nums=$classobj->numsrow($nums);
				if($nums > 0) // check exist or not, if not then insert new, else pass all data of same Google id user's
				{
					$qry5 = "SELECT * FROM `tbl_user` WHERE `googleplusid`='".$googleplusid."' AND `status`='1'";
					$result1 = $classobj->runquery($qry5);
					$nums1 = $classobj->fetchrow($result1);
					$param = array('success' =>1,'msg' =>'Login Successfully.','userid' =>$nums1['userid'],'fname'=>$nums1['fname'],'lname'=>$nums1['lname'],'email'=>$nums1['email'],'password'=>$nums1["password"],'picture'=>$nums1["picture"]); //Response
				}
				else
				{
					$picture="";
					$qry6 = "INSERT INTO `tbl_user` (`googleplusid`,`fname`,`lname`,`email`,`password`,`picture`,`status`,`cr_date`,`modify_date`) VALUES 
					('".$googleplusid."','".$fname."','".$lname."','".$email."','','".$picture."','1',NOW(),NOW())";
					$result2 = $classobj->runquery($qry6); 
					$param = array('success' =>1,'msg' =>'Profile added successfully.','userid' =>$qry6,'fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>'','picture'=>$picture); //Response
				}			
			}
			else //for Non-social check and using email
			{
				$qry10 = "SELECT * FROM `tbl_user` WHERE `email`='".$email."' AND `status`='1'";
				$result3 = $classobj->runquery($qry10);
				$nums2 = $classobj->numrows($result3);
				if($nums2 > 0)
				{
					$param = array('success'=>0,'msg'=>'User Already Registered.');
				}
				else
				{
					//$pictureurl = "";
//					if(isset($_FILES["picture"]["name"]) && $_FILES["picture"]["name"]!="")
//					{
//						$picturename = $_FILES["picture"]["name"];
//						$picture_image = date("dmyHis").$picturename;
//						move_uploaded_file($_FILES["picture"]["tmp_name"],$upload_userprofile.$picture_image);
//						$pictureurl = $download_userprofile.$picture_image;
//					}

					$qry11 = "INSERT INTO `tbl_user` (`googleplusid`,`fname`,`lname`,`email`,`password`,`picture`,`status`,`cr_date`,`modify_date`) VALUES 
					('0','".$fname."','".$lname."','".$email."','".$password."','".$picture."','1',NOW(),NOW())";
					$result4 = $classobj->runquery($qry11); 
				
					$param = array('success' =>1,'msg' =>'Profile added successfully.','userid' =>$userid,'fname'=>$fname,'lname'=>$lname,'email'=>$email,'password'=>$password,'picture'=>$picture); //Response
				}
			}
		}
		else
		{
			$qry12 = "SELECT * FROM `tbl_user` WHERE `userid`='".$userid."' AND `status`='1'";
			$result5 = $classobj->runquery($qry12);
			$nums3 = $classobj->numrows($result5);
			if($nums3 > 0)
			{
				if(isset($_FILES["picture"]["name"]) && $_FILES["picture"]["name"]!="")
				{
					$picturename = $_FILES["picture"]["name"];
					$picture_image = date("dmyHis").$picturename;
					move_uploaded_file($_FILES["picture"]["tmp_name"],$upload_userprofile.$picture_image);
					$pictureurl = $download_userprofile.$picture_image;
					$qry13 = "UPDATE `tbl_user` SET `picture`='".$pictureurl."' WHERE `userid`='".$userid."' AND `status`='1'";
					$result6 = $classobj->runquery($qry13);
				}
				$qry14 = "UPDATE `tbl_user` SET `fname`='".$fname."',`lname`='".$lname."',`email`='".$email."',`modify_date`=NOW() WHERE `userid`='".$userid."' AND `status`='1'";
				$result7 = $classobj->runquery($qry14);
				$qry_pass_14 = "SELECT * FROM `tbl_user` WHERE `userid`='".$userid."'";
				$result8 = $classobj->runquery($qry_pass_14);
				$fetch_row = $classobj->fetchrow($result8);
				$param = array('success' =>1,'msg' =>'Profile added successfully.','userid' =>$userid,'fname'=>$fetch_row["fname"],'lname'=>$fetch_row["lname"],'email'=>$fetch_row["email"],'password'=>$fetch_row["password"],'picture'=>$fetch_row["picture"]); //Response
			}
			else
			{
				$param = array('success'=>0,'msg'=>'Profile can not update.'); 
			}
		}
	echo $classobj->TranslateNull($param);
	break;

		case "login":
			if(isset($email) || $email!='')
			{
				$query = "SELECT * FROM `tbl_user` WHERE `email`='".$email."' AND `password`='".$password."'";	
				$result = $classobj->runquery($query);
				$nums = $classobj->numrows($result);
				if($nums > 0)
				{
					$rows = $classobj->fetcharray($result);
					foreach($rows as $datas){}
					//print_r($datas);
					$alldata['userid'] = $datas['userid'] ;
					$alldata['googlepluasid'] = $datas['googleplusid'];
					$alldata['fname'] = $datas['fname'];
					$alldata['lname'] = $datas['lname'];
					$alldata['email'] = $datas['email'];
					$alldata['password'] = $datas['password'];
					$alldata['picture'] = $datas['picture'];
					$alldata['catid'] = $datas['catid'];
					$alldata['status'] = $datas['status'];
					$response = array("success"=>"1","msg"=>"Login Successfully","data"=>$alldata);
					$result = $classobj->TranslateNull($response);
					echo $result;
				}
				else
				{
					$response = array("success"=>"0","msg"=>"Invalid userid or password.");
					$result = $classobj->TranslateNull($response);
					echo $result;
				}
			}
			break;	
			//forgot password webservice:
	case 'ForgotPassword':
		if(isset($email))
		{
			$qry8="SELECT * FROM `tbl_user` WHERE `email`='".$email."' AND `status`='1'";
			$result = $classobj->runquery($qry8);
			$nums=$classobj->numrows($result);
			if($nums>0)
			{
				$qry9="SELECT * FROM `tbl_user` WHERE `email`='".$email."' AND `status`='1'";
				$test = $classobj->runquery($qry9);
				$fetch_data=$classobj->fetchrow($test);
				$subject="RESET PASSWORD";
				require 'PHPMailer/PHPMailerAutoload.php';
				$htmlbody = 'Hi, <br/> <br/> Please click on below link to reset your JAKETV account password. <br/> <br/> <a href="'.$siteurl.'globalreset.php?secure='.$fetch_data['userid'].'&personaladd='.$email.'">'.$siteurl.'globalreset.php?secure='.$fetch_data['userid'].'&personaladd='.$email.'</a>';
				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';    
				$mail->SMTPAuth = true;
				$mail->Username = 'shivani.hjdimensions@gmail.com';
				$mail->Password = 'Shivani@123#';
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
				$param = array("success"=>0,"msg"=>"Incorrect email id");
			}
		}
	echo $classobj->TranslateNull($param);
	break;

		
		case "GetPost":
			if(isset($userid))
			{
				$selected_cat = "SELECT `catid` FROM `tbl_category` WHERE `selected`=1";	
				$result_cat = $classobj->fetcharray($classobj->runquery($selected_cat));
				foreach($result_cat as $catdatas)
				{
					$catids[] = $catdatas['catid'];
				}
				
				$impcatids = implode(',',$catids);
				
				$user_cat = "SELECT `catid` FROM `tbl_user` WHERE `userid`='".$userid."'";
				$result_usercat = $classobj->fetcharray($classobj->runquery($user_cat));
				foreach($result_usercat as $usercatdata){}
				
				if($usercatdata['catid']=='')
				{
					$catid = $impcatids;	
				}
				else
				{
					$catid = $usercatdata['catid'].','.$impcatids;
				}
				
				$pagelimit = 10;
				
				$mainquery = "SELECT * FROM `tbl_post` as `tp` 
							  INNER JOIN `tbl_category` as `tc` ON `tp`.`catid` = `tc`.`catid`
							  INNER JOIN `tbl_sub_category` `tsc` ON `tp`.`subcatid` = `tsc`.`subcatid`
							  WHERE `tp`.`catid` IN (".$catid.") ORDER BY `tp`.`postid`";
				$result_main = $classobj->runquery($mainquery);
				$totalpost = $classobj->numrows($result_main);
				
				$totalpage = round($totalpost/$pagelimit);
				if($Page==0)
				{
					$offset = 0;	
				}
				else
				{
					$offset = $Page*$pagelimit;	
				}
				
				$mainpaginagtion = "SELECT * FROM `tbl_post` as `tp` 
								  	INNER JOIN `tbl_category` as `tc` ON `tp`.`catid` = `tc`.`catid`
								  	INNER JOIN `tbl_sub_category` `tsc` ON `tp`.`subcatid` = `tsc`.`subcatid`
								  	WHERE `tp`.`catid` IN (".$catid.") ORDER BY `tp`.`postid` DESC LIMIT $offset,$pagelimit";
				$resultmainpagination = $classobj->fetcharray($classobj->runquery($mainpaginagtion));
				if($totalpost > 0)
				{
					foreach($resultmainpagination as $datas)
					{
						$alldata['postid']			= $datas['postid'];
						$alldata['title'] 			= $datas['title'];
						$alldata['catid']			= $datas['catid'];
						$alldata['category']		= $datas['category'];
						$alldata['subcatid']		= $datas['subcatid'];
						$alldata['subcategory']		= $datas['subcategory'];
						$alldata['totalpostlikes']	= $datas['totalpostlikes'];
						
						if($datas['isbookmarked']!='')
						{
							$exp_bookmark = explode(',',$datas['isbookmarked']);
							if(in_array($userid,$exp_bookmark))	
							{
								$alldata['isbookmarked'] = 1;
							}
							else
							{
								$alldata['isbookmarked'] = 0;
							}
						}
						else
						{
							$alldata['isbookmarked'] = 0;	
						}
						
						if($datas['isliked']!='')
						{
							$exp_like = explode(',',$datas['isliked']);
							if(in_array($userid,$exp_like))	
							{
								$alldata['isliked'] = 1;
							}
							else
							{
								$alldata['isliked'] = 0;
							}
						}
						else
						{
							$alldata['isliked'] = 0;	
						}
						$alldata['cr_date'] = $datas['cr_date'];
						$responcedata[]		= $alldata;
					}
					$responce = array("success"=>"1","msg"=>"Post found","totalpage"=>$totalpage,"data"=>$responcedata);
					$result = $classobj->TranslateNull($responce);
					echo $result;
				}
				else
				{
					$responce = array("success"=>"0","msg"=>"No Post found");
					$result = $classobj->TranslateNull($responce);
					echo $result;		
				}
			}
			break;
		case "GetCategory":
			if(isset($userid))
			{
				$cat_query = "SELECT * FROM `tbl_category` WHERE `status`=1" ;
				$result_cat = $classobj->runquery($cat_query);
				$nums = $classobj->numrows($result_cat);
				$pagelimit = 10;
				$totalpage = round($nums/$pagelimit);
				if($Page==0)
				{
					$offset = 0;	
				}
				else
				{
					$offset = $Page*$pagelimit;	
				}
				
				$main_query = "SELECT * FROM `tbl_category` WHERE `status`=1 ORDER BY `catid` DESC LIMIT $offset,$pagelimit";
				$result_main = $classobj->fetcharray($classobj->runquery($main_query));
				
				if($nums > 0)
				{
					foreach($result_main as $categoy)
					{
						$subcatdata = array();
						reset($subcatdata);
						$alldata['catid'] 	 = $categoy['catid'];
						$alldata['category'] = $categoy['category'];
						$subcat_query = "SELECT * FROM `tbl_sub_category` WHERE `status`=1 AND `catid`='".$categoy['catid']."' ORDER BY `subcatid` DESC";
						$result_sub = $classobj->fetcharray($classobj->runquery($subcat_query));
						foreach($result_sub as $subcat)
						{
							
							$sub_alldata['subcatid'] 		= $subcat['subcatid'];
							$sub_alldata['subcategory'] 	= $subcat['subcategory'];
							@$subcatdata[] = $sub_alldata;
						}
						$alldata['subcatdata'] = @$subcatdata;
						$responcedata[] = $alldata;
					}
					$responce = array("success"=>"1","msg"=>"Category Found","totalpage"=>$totalpage,"data"=>$responcedata);
					$result = $classobj->TranslateNull($responce);
					echo $result;
				}
				else
				{
					$responce = array("success"=>"0","msg"=>"No Category Found");
					$result = $classobj->TranslateNull($responce);
					echo $result;		
				}
			}
			break;
		
		case "GetPostByCategory":
			if(isset($userid))
			{	
				$pagelimit = 10;
				$mainquery = "SELECT * FROM `tbl_post` as `tp` 
							  INNER JOIN `tbl_category` as `tc` ON `tp`.`catid` = `tc`.`catid`
							  INNER JOIN `tbl_sub_category` `tsc` ON `tp`.`subcatid` = `tsc`.`subcatid`
							  WHERE `tp`.`catid` = ".$catid." ORDER BY `tp`.`postid`";
				$result_main = $classobj->runquery($mainquery);
				$totalpost = $classobj->numrows($result_main);
				
				$totalpage = round($totalpost/$pagelimit);
				if($Page==0)
				{
					$offset = 0;	
				}
				else
				{
					$offset = $Page*$pagelimit;	
				}
				
				$mainpaginagtion = "SELECT * FROM `tbl_post` as `tp` 
								  	INNER JOIN `tbl_category` as `tc` ON `tp`.`catid` = `tc`.`catid`
								  	INNER JOIN `tbl_sub_category` `tsc` ON `tp`.`subcatid` = `tsc`.`subcatid`
								  	WHERE `tp`.`catid` IN (".$catid.") ORDER BY `tp`.`postid` DESC LIMIT $offset,$pagelimit";
				$resultmainpagination = $classobj->fetcharray($classobj->runquery($mainpaginagtion));
				if($totalpost > 0)
				{
					foreach($resultmainpagination as $datas)
					{
						$alldata['postid']			= $datas['postid'];
						$alldata['title'] 			= $datas['title'];
						$alldata['catid']			= $datas['catid'];
						$alldata['category']		= $datas['category'];
						$alldata['subcatid']		= $datas['subcatid'];
						$alldata['subcategory']		= $datas['subcategory'];
						$alldata['totalpostlikes']	= $datas['totalpostlikes'];
						
						if($datas['isbookmarked']!='')
						{
							$exp_bookmark = explode(',',$datas['isbookmarked']);
							if(in_array($userid,$exp_bookmark))	
							{
								$alldata['isbookmarked'] = 1;
							}
							else
							{
								$alldata['isbookmarked'] = 0;
							}
						}
						else
						{
							$alldata['isbookmarked'] = 0;	
						}
						
						if($datas['isliked']!='')
						{
							$exp_like = explode(',',$datas['isliked']);
							if(in_array($userid,$exp_like))	
							{
								$alldata['isliked'] = 1;
							}
							else
							{
								$alldata['isliked'] = 0;
							}
						}
						else
						{
							$alldata['isliked'] = 0;	
						}
						$alldata['cr_date'] = $datas['cr_date'];
						$responcedata[]		= $alldata;
					}
					$responce = array("success"=>"1","msg"=>"Post found","totalpage"=>$totalpage,"data"=>$responcedata);
					$result = $classobj->TranslateNull($responce);
					echo $result;
				}
				else
				{
					$responce = array("success"=>"0","msg"=>"No Post found");
					$result = $classobj->TranslateNull($responce);
					echo $result;		
				}
			}
			break;
		
		case "BookmarkPost":
			if(isset($userid))
			{
				$select_post = "SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'";
				$result_post = $classobj->fetchrow($classobj->runquery($select_post));
				
				if($result_post['isbookmarked']!='')
				{
					$exp_book = explode(',',$result_post['isbookmarked']);
					if(!in_array($userid,$exp_book))
					{
						$result = $result_post['isbookmarked'].','.$userid;
						$updata_post = "UPDATE `tbl_post` set `isbookmarked`='".$result."', `modify_date`=NOW() WHERE `postid`='".$postid."'";
						$classobj->runquery($updata_post);
						$responce = array("success"=>"1","msg"=>"Post Bookmarked Successfully");
						$result = $classobj->TranslateNull($responce);
						echo $result;
					}
				}
				else
				{
					$updata_post = "UPDATE `tbl_post` set `isbookmarked`='".$userid."', `modify_date`=NOW() WHERE `postid`='".$postid."'";
					$classobj->runquery($updata_post);
					$responce = array("success"=>"1","msg"=>"Post Bookmarked Successfully");
					$result = $classobj->TranslateNull($responce);
					echo $result;	
				}
				//print_r($result_post);
			}
			break;
		
		case "UnBookmarkPost":
			if(isset($userid))
			{
				$select_post = "SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'";
				$result_post = $classobj->fetchrow($classobj->runquery($select_post));
				
				if($result_post['isbookmarked']!='')
				{
					$exp_book = explode(',',$result_post['isbookmarked']);
					$index = array_search($userid,$exp_book);
					if($index!=false)
					{
						unset($exp_book[$index]);
					}
					$imp_book = implode(',',$exp_book);
					$updata_post = "UPDATE `tbl_post` set `isbookmarked`='".$imp_book."', `modify_date`=NOW() WHERE `postid`='".$postid."'";
					$classobj->runquery($updata_post);
					$responce = array("success"=>"1","msg"=>"Post Un Bookmarked Successfully");
					$result = $classobj->TranslateNull($responce);
					echo $result;
				}
				//print_r($result_post);
			}
			break;
		
		case "LikePost":
			if(isset($userid))
			{
				$select_post = "SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'";
				$result_post = $classobj->fetchrow($classobj->runquery($select_post));
				
				if($result_post['isliked']!='')
				{
					$exp_like = explode(',',$result_post['isliked']);
					if(!in_array($userid,$exp_like))
					{
						$result = $result_post['isliked'].','.$userid;
						$exp_likes = explode(',',$result);
						$count = count($exp_likes);
						$updata_post = "UPDATE `tbl_post` set `isliked`='".$result."', `modify_date`=NOW(), `totalpostlikes`='".$count."' WHERE `postid`='".$postid."'";
						$classobj->runquery($updata_post);
						$responce = array("success"=>"1","msg"=>"Post Like Successfully");
						$result = $classobj->TranslateNull($responce);
						echo $result;
					}
				}
				else
				{
					$result = $userid;
					$exp_likes = explode(',',$result);
					$count = count($exp_likes);
					$updata_post = "UPDATE `tbl_post` set `isliked`='".$result."', `modify_date`=NOW(), `totalpostlikes`='".$count."' WHERE `postid`='".$postid."'";
					$classobj->runquery($updata_post);
					$responce = array("success"=>"1","msg"=>"Post Like Successfully");
					$result = $classobj->TranslateNull($responce);
					echo $result;	
				}
				//print_r($result_post);
			}
			break;
		
		case "UnLikePost":
			if(isset($userid))
			{
				$select_post = "SELECT * FROM `tbl_post` WHERE `postid`='".$postid."'";
				$result_post = $classobj->fetchrow($classobj->runquery($select_post));
				
				if($result_post['isliked']!='')
				{
					$exp_like = explode(',',$result_post['isliked']);
					$index = array_search($userid,$exp_like);
					if($index!=false)
					{
						unset($exp_like[$index]);
					}
					$count = count($exp_like);
					$imp_like = implode(',',$exp_like);
					$updata_post = "UPDATE `tbl_post` set `isliked`='".$imp_like."', `modify_date`=NOW(), `totalpostlikes` = '".$count."' WHERE `postid`='".$postid."'";
					$classobj->runquery($updata_post);
					$responce = array("success"=>"1","msg"=>"Post Un Like Successfully");
					$result = $classobj->TranslateNull($responce);
					echo $result;
				}
				//print_r($result_post);
			}
			break;
		
		case "GetBookmarkByUserid":
			if(isset($userid))
			{
				$postids = array();
				$select_post = "SELECT * FROM `tbl_post` WHERE `status`=1";
				$result_post = $classobj->fetcharray($classobj->runquery($select_post));
				foreach($result_post as $rsdatas)
				{
					if($rsdatas['isbookmarked']!='')
					{
						$exp_post = explode(',',$rsdatas['isbookmarked']);
						if(in_array($userid,$exp_post))
						{
							$postids[] = $rsdatas['postid'];
						}
					}
				}
				//print_r($postids);
				$postidsss =implode(',',$postids);
				$selectuser_post = "SELECT * FROM `tbl_post` as `tp`
									INNER JOIN `tbl_category` as `tc` ON `tc`.`catid` = `tp`.`catid`
									INNER JOIN `tbl_sub_category` as `tsc` ON `tsc`.`subcatid` = `tp`.`subcatid`
									WHERE `tp`.`postid` IN (".$postidsss.") ORDER BY `tp`.`postid` DESC";
				$resultuser_post = $classobj->numrows($classobj->runquery($selectuser_post));
				
				$pagelimit = 10;
				$totalpage = round($resultuser_post/$pagelimit);
				if($Page==0)
				{
					$offset = 0;	
				}
				else
				{
					$offset = $Page*$pagelimit;	
				}
				$selectuser_post1 = "SELECT * FROM `tbl_post` as `tp`
									INNER JOIN `tbl_category` as `tc` ON `tc`.`catid` = `tp`.`catid`
									INNER JOIN `tbl_sub_category` as `tsc` ON `tsc`.`subcatid` = `tp`.`subcatid`
									WHERE `tp`.`postid` IN (".$postidsss.") ORDER BY `tp`.`postid` DESC LIMIT $offset,$pagelimit";
				$resultuser_post1 = $classobj->fetcharray($classobj->runquery($selectuser_post1));
				foreach($resultuser_post1 as $user_post)
				{
					$alldata['postid']			= $user_post['postid'];
					$alldata['title'] 			= $user_post['title'];
					$alldata['catid']			= $user_post['catid'];
					$alldata['category']		= $user_post['category'];
					$alldata['subcatid']		= $user_post['subcatid'];
					$alldata['subcategory']		= $user_post['subcategory'];
					$alldata['totalpostlikes']	= $user_post['totalpostlikes'];
					
					if($user_post['isbookmarked']!='')
					{
						$exp_bookmark = explode(',',$user_post['isbookmarked']);
						if(in_array($userid,$exp_bookmark))	
						{
							$alldata['isbookmarked'] = 1;
						}
						else
						{
							$alldata['isbookmarked'] = 0;
						}
					}
					else
					{
						$alldata['isbookmarked'] = 0;	
					}
					
					if($user_post['isliked']!='')
					{
						$exp_like = explode(',',$user_post['isliked']);
						if(in_array($userid,$exp_like))	
						{
							$alldata['isliked'] = 1;
						}
						else
						{
							$alldata['isliked'] = 0;
						}
					}
					else
					{
						$alldata['isliked'] = 0;	
					}
					$alldata['cr_date'] = $user_post['cr_date'];
					$responcedata[]		= $alldata;		
				}
				$responce = array("success"=>"1","msg"=>"Post found","totalpage"=>$totalpage,"data"=>$responcedata);
				$result = $classobj->TranslateNull($responce);
				echo $result;
			}
			break;
		
		case "GetPostLikeByUserid":
			if(isset($userid))
			{
				$postids = array();
				$select_post = "SELECT * FROM `tbl_post` WHERE `status`=1";
				$result_post = $classobj->fetcharray($classobj->runquery($select_post));
				foreach($result_post as $rsdatas)
				{
					if($rsdatas['isliked']!='')
					{
						$exp_post = explode(',',$rsdatas['isliked']);
						if(in_array($userid,$exp_post))
						{
							$postids[] = $rsdatas['postid'];
						}
					}
				}
				//print_r($postids);
				$postidsss =implode(',',$postids);
				$selectuser_post = "SELECT * FROM `tbl_post` as `tp`
									INNER JOIN `tbl_category` as `tc` ON `tc`.`catid` = `tp`.`catid`
									INNER JOIN `tbl_sub_category` as `tsc` ON `tsc`.`subcatid` = `tp`.`subcatid`
									WHERE `tp`.`postid` IN (".$postidsss.") ORDER BY `tp`.`postid` DESC";
				$resultuser_post = $classobj->numrows($classobj->runquery($selectuser_post));
				
				$pagelimit = 10;
				$totalpage = round($resultuser_post/$pagelimit);
				if($Page==0)
				{
					$offset = 0;	
				}
				else
				{
					$offset = $Page*$pagelimit;	
				}
				$selectuser_post1 = "SELECT * FROM `tbl_post` as `tp`
									INNER JOIN `tbl_category` as `tc` ON `tc`.`catid` = `tp`.`catid`
									INNER JOIN `tbl_sub_category` as `tsc` ON `tsc`.`subcatid` = `tp`.`subcatid`
									WHERE `tp`.`postid` IN (".$postidsss.") ORDER BY `tp`.`postid` DESC LIMIT $offset,$pagelimit";
				$resultuser_post1 = $classobj->fetcharray($classobj->runquery($selectuser_post1));
				foreach($resultuser_post1 as $user_post)
				{
					$alldata['postid']			= $user_post['postid'];
					$alldata['title'] 			= $user_post['title'];
					$alldata['catid']			= $user_post['catid'];
					$alldata['category']		= $user_post['category'];
					$alldata['subcatid']		= $user_post['subcatid'];
					$alldata['subcategory']		= $user_post['subcategory'];
					$alldata['totalpostlikes']	= $user_post['totalpostlikes'];
					
					if($user_post['isbookmarked']!='')
					{
						$exp_bookmark = explode(',',$user_post['isbookmarked']);
						if(in_array($userid,$exp_bookmark))	
						{
							$alldata['isbookmarked'] = 1;
						}
						else
						{
							$alldata['isbookmarked'] = 0;
						}
					}
					else
					{
						$alldata['isbookmarked'] = 0;	
					}
					
					if($user_post['isliked']!='')
					{
						$exp_like = explode(',',$user_post['isliked']);
						if(in_array($userid,$exp_like))	
						{
							$alldata['isliked'] = 1;
						}
						else
						{
							$alldata['isliked'] = 0;
						}
					}
					else
					{
						$alldata['isliked'] = 0;	
					}
					$alldata['cr_date'] = $user_post['cr_date'];
					$responcedata[]		= $alldata;		
				}
				$responce = array("success"=>"1","msg"=>"Post found","totalpage"=>$totalpage,"data"=>$responcedata);
				$result = $classobj->TranslateNull($responce);
				echo $result;
			}
			break;
		
		case 'SelectCategoryByUser':
			if(isset($userid))
			{
				$qry0 = "SELECT * FROM `tbl_user` WHERE `userid`='".$userid."'";
				$result0 = $classobj->fetchrow($classobj->runquery($qry0));
				//print_r($result0);
				if($result0["catid"]!="")
				{
					$catidxyz= $result0["catid"].','.$catid;
					$update_catidxyz = $classobj->runquery("UPDATE `tbl_user` SET `catid`='".$catidxyz."' WHERE `userid`='".$userid."'");
				}
				else
				{
					$catidxyz = $catid;
					$update_catidxyz = $classobj->runquery("UPDATE `tbl_user` SET `catid`='".$catidxyz."' WHERE `userid`='".$userid."'");
				}
				$param = array('success'=>1,'msg'=>'Category select successfully');
			}
			echo $classobj->TranslateNull($param);
			break;
		
		case 'UnSelectCategoryByUser':
			if(isset($userid))
			{
				$qry0 = "SELECT * FROM `tbl_user` WHERE `userid`='".$userid."'";
				$result0 = $classobj->fetchrow($classobj->runquery($qry0));
				if($result0["catid"]!="")
				{
					$checkin = explode(',',$result0["catid"]);
					$catids = explode(',',$catid);
					$count = count($catids);
					for($i=0;$i<$count;$i++)
					{
						$index = array_search($catids[$i],$checkin);
						if($index !== false)
						{
							unset($checkin[$index]);
						}
						$catidxyz=implode(',',$checkin);
						$update_catidxyz = $classobj->runquery("UPDATE `tbl_user` SET `catid`='".$catidxyz."' WHERE `userid`='".$userid."'");
					}
					$param = array('success'=>1,'msg'=>'Category unselect successfully');
				}
			}
			echo $classobj->TranslateNull($param);
			break;
			
		
	}
?>