<?php
include('service.php');
include('secure/customjs.php');
//include('secure/config.php');



if(isset($_SESSION['sessionid'])){
	$sel = $obj->qry_fetchRow("select userid from tbl_user where sessid='".$_SESSION['sessionid']."'");
	
	$userid = $sel['userid'];



/*$obj = new service_class();



				$PageLimit = "25";
				if(isset($_POST['load_value'])){
					echo $Page1 = $_POST['load_value'];
					$PageLimit = $Page1*$PageLimit;
					$_SESSION['pagedata'] = $PageLimit;
				}
				
				if(!empty($_SESSION['pagedata'])){
					$PageLimit =  $_SESSION['pagedata'];
				}else{
					$PageLimit = "25";
					//$_SESSION['pagedata'] = $PageLimit;
				}

				  $qry02 = $obj->qry_fetchRows("SELECT `catidu` FROM `tbl_category` WHERE `selected`='1'");
                        foreach($qry02 as $qry){
                            $id = $qry['catidu'];
                            $qry021 = $obj->qry_fetchRows("SELECT * FROM `tbl_post` WHERE find_in_set($id,catid) AND status='1' order by postid desc");
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
						$d = implode(',',$post_id);
						$fetch_post = $obj->qry_fetchRows("SELECT * FROM tbl_post WHERE postid IN (".$d.") order by postid desc LIMIT $PageLimit");

*/

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Zoo Planet Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />

</head>
<body>
<div class="header">
  <?php
include('header.php'); 
?>
</div>
<div class="content">
    <div class="welcome" id="cat_page_main">
  <div class="row" style="margin-top:50px;">
        	<!--<div class="col-md-5"></div>
            <div class="col-md-2">
            	<h3 align="center" style="font-size:30px;">Category</h3>
            </div>
            <div class="col-md-5"></div>-->
        </div>
  		<br><br>
<div class="row" style="margin-left: 0px; margin-right: 0px;"> 
	<div class="col-lg-12" style="position:relative;">
    
    
    	<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" style="position:relative;">
			<?php
            $fetchcat = $obj->qry_fetchRows("select catid,catidu,category,selected,status from tbl_category where status='1' and selected='0' order by catid desc");
            $qry0 = $obj->qry_fetchRow("SELECT * FROM `tbl_user` WHERE `sessid`='".$_SESSION['sessionid']."'");
            if(!empty($fetchcat)){
                if(!empty($qry0['catid'])){
                    $user_cat = explode(',',$qry0['catid']);

                    foreach($fetchcat as $final){
                        $index = array_search($final['catidu'],$user_cat);
                        if($index !== false)
                        { ?>
                        <div class="col-lg-2">
                            <a class="btn btn-success btn-lg cat_id1<?php echo $final['catidu']; ?>" onclick="unset_user_cat_click(<?php echo $final['catidu']; ?>)" style="margin-bottom: 30px;  width:100%; border-radius:0px;padding:10px 0;">
                                                    <i class="fa fa-check-circle"></i>&nbsp;&nbsp;<?php echo $final['category']; ?></a>
                            <a class="btn btn-info btn-lg cat_id<?php echo $final['catidu']; ?>" onclick="user_cat_click(<?php echo $final['catidu']; ?>)" style="margin-bottom: 30px; display: none; border:1px solid gray; color:black; background-color:white; width:100%;border-radius:0px;padding:10px 0;">
                                                    <?php echo $final['category']; ?></a>
                        </div>
                                            <?php }else{ ?>
                        <div class="col-lg-2">
                            <a class="btn btn-info btn-lg cat_id<?php echo $final['catidu']; ?>" onclick="user_cat_click(<?php echo $final['catidu']; ?>)" style="margin-bottom: 30px; border:1px solid gray; color:black; background-color:white; width:100%;border-radius:0px;padding:10px 0;">
    <?php echo $final['category']; ?></a>
                           <a class="btn btn-success btn-lg cat_id1<?php echo $final['catidu']; ?>" onclick="unset_user_cat_click(<?php echo $final['catidu']; ?>)" style="margin-bottom: 30px; display: none; width:100%;border-radius:0px;padding:10px 0;">
     <i class="fa fa-check-circle"></i>&nbsp;&nbsp;<?php echo $final['category']; ?></a>
                                    </div>
                        <?php }
                    }


                }else{ 
                                    foreach($fetchcat as $final){
                            ?>
                <div class="col-lg-2">
                    <a class="btn btn-info btn-lg cat_id<?php echo $final['catidu']; ?>" onclick="user_cat_click(<?php echo $final['catidu']; ?>)" style="margin-bottom: 30px; border:1px solid gray; color:black; background-color:white; width:100%;border-radius:0px;padding:10px 0;">
    <?php echo $final['category']; ?></a>
                    <a class="btn btn-success btn-lg cat_id1<?php echo $final['catidu']; ?>" onclick="unset_user_cat_click(<?php echo $final['catidu']; ?>)" style="margin-bottom: 30px; display: none;  width:100%;border-radius:0px;padding:10px 0;">
                    <i class="fa fa-check-circle"></i>&nbsp;&nbsp;<?php echo $final['category']; ?></a>
                </div>
                            <?php 
                                    }
                            }
            }else{ ?>
            <h2 class="notfound">Category Not Available.</h2>
            <?php }
                 ?>
		</div>
    
    
    
    
    
        <!--<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" style="position:relative;">
        <?php
		//$post = mysql_query("select * from tbl_post where status=1");
        //$fetchpost = $obj->qry_fetchRows($post);
		
        /*$cat_qry=mysql_query("select * from tbl_category");
        $fetchcat = $obj->qry_fetchRows("select * from tbl_category");
		$i=1;
		foreach($fetchcat as $final)
		{*/
		
		?>
           <div class="col-lg-3">
            <?php 
				//if($final['selected']==1){
					
					?>
            <a href="javascript:;" onClick="select_categories(this.id)"  data-catid="<?=$final['catidu']?>" data-flag="<?=$final['selected']?>" class="category" id="category<?=$i?>">
            <?php //echo $final['category']; ?>
            /a>
			<?php 	//}
			//else{
			?>
            <a href="javascript:;" onClick="select_categories(this.id)" data-catid="<?=$final['catidu']?>" data-flag="<?=$final['selected']?>" class="catdel" id="catdel<?=$i?>">
           <?php //echo $final['category']; ?>
            <?php  //} ?>
            </a>
			</div>
            <?php //$i++;} ?>
	</div>-->
</div>
        <!--<input type="hidden" name="catidval" value="<?php $final['catidu']?>" />-->
   
</div>
</div>

<div class="footer-section" id="footerhr">
<div class="footer-top">
<p>&copy; 2015 JAKE TV. All rights reserved</p>
</div>
</div>
    
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
function description_length()
{
var yourString = $("#desc").text();

var stripped = yourString .substr(0, 10);


var abc = stripped.length;
}

</script>

<script>
$('#login').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input').val(recipient)
})

$(document).ready(function(e) {
	
	$("#login_detail").click(function(e) {
  $("#register_page").hide();
  $("#login_page").show();
  $("#login_detail").css("color","#185BAE");
  $("#register").css("color","#333");
    });
 
    $("#register").click(function(e) {
  $("#register_page").show();
  $("#login_page").hide();
  $("#login_detail").css("color","#333");
  $("#register").css("color","#185BAE");
    });
 $("#viewmore").click(function(e) {
        $("#moredesc").show();
  $("#viewless").show();
  $('.post_desc').css('heigth','900px');
    });
 $("#viewless").click(function(e) {
  $("#moredesc").hide();
  $("#desc").show();
  $("#viewless").hide(); 
    });
});
function select_categories(id)
{
	var catid = $("#"+id).attr("data-catid");
	var flag = $("#"+id).attr("data-flag");
	$.ajax({
		url : 'service.php',
		type : 'post',
		data: 'sel_categroy=1&catid='+catid+"&flag="+flag,				
		success : function(data) 
		{
			if(flag==1)
			{
				
				$("#"+id).attr("data-flag","0");
				$("#"+id).removeClass("category");	
				$("#"+id).addClass("catdel");
			}
			else
			{
				$("#"+id).attr("data-flag","1");
				$("#"+id).removeClass("catdel");
				$("#"+id).addClass("category");	
			}
		}	
	});
}
</script>
</body>
</html>
<?php
}
else{
	header('location:index.php');	
}
?>
