<?php 
	ob_start();
	include("servicesclass.php");
	$classobj = new servicecalss();
	if(isset($_POST['submit']))
	{
	$json_array = array("method"=>"GetPost","userid"=>$_POST['user'],"Page"=>$_POST['page']);
	$result = $classobj->TranslateNull($json_array);
	header("location:service.php?data=".$result);
	}
?>
<html>
<form action="" method="post">
<select name="user" style="width:300px;height:30px;">
	<?php
	$query = "SELECT * FROM `tbl_user`";
	$result = $classobj->fetcharray($classobj->runquery($query));
	
	foreach($result as $datas)
	{
    ?>
    	<option value="<?=$datas['userid']?>"><?=$datas['userid']?></option>
        <?php
	}?>
</select>
<input type="text" name="post" style="width:300px;height:30px;" placeholder="PAGE">
<input type="submit" name="submit" style="height:30px;">
</form>
</html>