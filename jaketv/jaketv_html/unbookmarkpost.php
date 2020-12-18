<?php 
	ob_start();
	include("servicesclass.php");
	$classobj = new servicecalss();
	if(isset($_POST['submit']))
	{
	$json_array = array("method"=>"UnBookmarkPost","userid"=>$_POST['user'],"postid"=>$_POST['post']);
	$result = $classobj->TranslateNull($json_array);
	header("location:service.php?data=".$result);
	}
?>

<form action="" method="post">
	<select name="post" style="width:300px;height:30px;">
    <option value="">---------------------SELECT POSTID------------------------</option>
    	<?php 
			$select = "SELECT * FROM `tbl_post`";
			$result = $classobj->fetcharray($classobj->runquery($select));
			foreach($result as $datas)
			{
				?>
                <option value="<?=$datas['postid']?>"><?=$datas['postid']?></option>
                <?php	
			}
		?>
    </select>
    <select name="user" style="width:300px;height:30px;">
    <option value="">-----------------------SELECT USERID--------------------------</option>
    	<?php 
			$select = "SELECT * FROM `tbl_user`";
			$result = $classobj->fetcharray($classobj->runquery($select));
			foreach($result as $datas)
			{
				?>
                <option value="<?=$datas['userid']?>"><?=$datas['userid']?></option>
                <?php	
			}
		?>
    </select>
    <input type="submit" name="submit" style="height:30px;">
</form>