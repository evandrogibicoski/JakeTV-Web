<?php
include('service.php');
include('secure/customjs.php');
//include('secure/config.php');

if(isset($_SESSION['sessionid'])){



$obj = new service_class();


$sessid = $_SESSION['sessionid'];

if(isset($sessid)){
	$s = $obj->qry_fetchRow("SELECT * FROM `tbl_user` WHERE `sessid`='".$sessid."'");
	$userid = $s['userid'];
}

if(isset($userid))
{
	$alldata = array();
	$responsedata = array();
	$qry0 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE `status`='1' ORDER BY `cr_date` DESC");
	foreach($qry0 as $qry0_data)
	{
		$checkin = explode(',',$qry0_data["isliked"]);
		$index = array_search($userid,$checkin);
		if($index !== false)
		{
			$qry_cat = $obj->qry_fetchRow("SELECT * FROM `tbl_category` WHERE `catidu`='".$qry0_data["catid"]."'");
			$qry_subcat = $obj->qry_fetchRow("SELECT * FROM `tbl_sub_category` WHERE `subcatidu`='".$qry0_data["subcatid"]."'");
			
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
		
		if(isset($_POST['load_value'])){
				echo $Page1 = $_POST['load_value'];
				$PageLimit = $Page1*$PageLimit;
				$_SESSION['pagedata_like'] = $PageLimit;
			}
			
			if(!empty($_SESSION['pagedata_like'])){
				$PageLimit =  $_SESSION['pagedata_like'];
			}else{
				$PageLimit = "25";
				//$_SESSION['pagedata'] = $PageLimit;
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
			
			//echo $array_ind;
			
			
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
		
	}
	
}
			
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="images/JAKEtv_flav.png">
<title>Jake TV • Jewish Arts Knowledge Entertainment</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,700,800' rel='stylesheet' type='text/css'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Zoo Planet Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>

</script>

<script>

</script>
</head>
<body>
<div class="header">
  <?php
include('header.php'); 
?>
</div>

<!--welcome-->
<div class="content">
  <div class="welcome"> 
    <!--<div class="container">-->
    
    <div class="row" id="content_likes" style="margin-top:80px; margin-left:25px;">
    	<div class="row">
        	<div class="col-md-5"></div>
            <div class="col-md-2">
            	<h3 align="center" style="font-size:30px;">Liked Post</h3>
            </div>
            <div class="col-md-5"></div>
        </div>
        <br><br>
    <?php
    	$count = count($response);
		for($i=0; $i<$count; $i++){ ?>
			<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12" align="left" id="post_column" style="min-height:550px;">
                    <!--<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="postblock" >--> 
                    <img src="<?php echo $response[$i]['image']; ?>" class="marginimg" style="cursor:pointer;" onClick="window.open('<?php echo $response[$i]['url']; ?>','_blank')"/>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cicker" style="cursor:pointer;" onClick="window.open('<?php echo $response[$i]['url']; ?>','_blank')">
                        <?php
                 			echo $str = strtoupper(substr($response[$i]['kickerline'], 0, 100));
                 		?>
                         </div>
                         <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_title" style="cursor:pointer;" onClick="window.open('<?php echo $response[$i]['url']; ?>','_blank')"><?php echo $response[$i]['title']; ?> </div>
                          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_cat_subcat" style="cursor:pointer;" onClick="window.open('<?php echo $response[$i]['url']; ?>','_blank')"> 
                    		<?php echo $response[$i]['category']; ?>
                          </div>
                      
                      <?php
						if(strlen($response[$i]['description']) > 330){ ?>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $response[$i]['postid']; ?>" onClick="window.open('<?php echo $response[$i]['url']; ?>','_blank')" style="cursor:pointer;" onload="init();">
						
							<?php 
							  //$desc =$fetch_post['description'];
							  //$strdesc = substr($desc, 0, 40);
							//echo $strdesc;
							 echo substr($response[$i]['description'],0,330); ?><?php echo "..."; ?>
								 </div>
								 <div id="seemore<?php echo $response[$i]['postid']; ?>"><?php echo "<span onClick='see_more(".$response[$i]['postid'].")' style='cursor:pointer; color:blue;'>see more</span>"; ?></div>
								 <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc1<?php echo $response[$i]['postid']; ?>" onClick="window.open('<?php echo $response[$i]['url']; ?>','_blank')" style="cursor:pointer; display:none;" onload="init();">
									<?php echo $response[$i]['description']; ?>
								 </div>
								 <!--<div id="back<?php //echo $fetch_post['postid'] ?>" style="display:none;"><?php //echo "<span onClick='back(".$fetch_post['postid'].")' style='cursor:pointer; color:blue;'>back</span>"; ?></div>-->
						<?php }else{ ?>
							<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 post_desc" id="desc<?php echo $response[$i]['postid']; ?>" onClick="window.open('<?php echo $response[$i]['url']; ?>','_blank')" style="cursor:pointer;" onload="init();">
						
							<?php 
							  //$desc =$fetch_post['description'];
							  //$strdesc = substr($desc, 0, 40);
							//echo $strdesc;
							 echo $response[$i]['description']; ?>
								 </div>
						<?php }
						?>
                        
                   <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:5px;"></div>
                    <div class="post_button col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    	<?php
						if($response[$i]['isliked'] == '1'){ ?>
							<a onClick="unlike_post(<?php echo $response[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $response[$i]['postid']; ?>">LIKED</a>
                            <a onClick="like_post(<?php echo $response[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $response[$i]['postid']; ?>" style="display:none;">LIKE</a>&nbsp;&nbsp;
						<?php }else{ ?>
							<a onClick="like_post(<?php echo $response[$i]['postid']; ?>)" id="like_post1" class="like_post1<?php echo $response[$i]['postid']; ?>">LIKE</a>
							<a onClick="unlike_post(<?php echo $response[$i]['postid']; ?>)" id="like_post" class="like_post<?php echo $response[$i]['postid']; ?>" style="display:none;">LIKED</a>&nbsp;&nbsp;
						<?php }
						?>
                        <a id="share_post">SHARE</a>&nbsp;&nbsp;
                        <?php
						if($response[$i]['isbookmarked'] == '1'){ ?>
                            <a onClick="unbookmark_post(<?php echo $response[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $response[$i]['postid']; ?>">BOOKMARKED</a>
							<a onClick="bookmark_post(<?php echo $response[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $response[$i]['postid']; ?>" style="display:none;">BOOKMARK</a>&nbsp;&nbsp;
						<?php }else{ ?>
							<a onClick="bookmark_post(<?php echo $response[$i]['postid']; ?>)" id="bookmark_post1" class="bookmark_post1<?php echo $response[$i]['postid']; ?>">BOOKMARK</a>
							<a onClick="unbookmark_post(<?php echo $response[$i]['postid']; ?>)" id="bookmark_post" class="bookmark_post<?php echo $response[$i]['postid']; ?>" style="display:none;">BOOKMARKED</a>&nbsp;&nbsp;
						<?php }
						?>
                        
                    </div>
                   <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="min-height:25px;">&nbsp;</div>
                      
          </div>
		<?php }
    ?>
    		
    </div>
        <div class="row" id="load_more">
          <div class="col-sm-5"></div>
          <div class="col-sm-2" onClick="load_like_page()">
            <input type="hidden" id="load_value_hidden" name="load_value_hidden" value="1"/>
            <button type="button" class="form-control input-lg btn btn-default">LOAD MORE</button>
            </div>
          <div class="col-sm-5"></div>
        </div>
</div>
  </div>
  



<div class="footer-section" id="footerhr">
<div class="footer-top">
<p>&copy; 2015 JAKE TV. All rights reserved</p>
</div>
</div>
</body>
</html>

<?php
}else{
	header('location:index.php');	
}
?>