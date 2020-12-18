<?php 
	ob_start();
	include("servicesclass.php");
	$classobj = new servicecalss();
	if(isset($_POST['submit']))
	{
	$json_array = array("method"=>"GetPostByCategory","userid"=>$_POST['user'],"catid"=>$_POST['cat'],"Page"=>$_POST['page']);
	$result = $classobj->TranslateNull($json_array);
	header("location:service.php?data=".$result);
	}
?>
<html>
<form action="" method="post">
<select name="user" style="width:300px;height:30px;">
    <option value="">-----------------------SELECT USERID--------------------------</option>

	<?php
		$query = "SELECT * FROM `tbl_user`";
		$result = $classobj->fetcharray($classobj->runquery($query));
		
		foreach($result as $datas)
		{?>
        	<option value="<?= $datas['userid'] ?>"><?=$datas['userid']?></option>
		<?php
        }
        ?>
</select>

<select name="cat" style="width:300px;height:30px;">
    <option value="">-------------------SELECT CATID----------------------------</option>
<?php
		$query2 = "SELECT * FROM `tbl_category`";
		$result2 = $classobj->fetcharray($classobj->runquery($query2));
		
		foreach($result2 as $datas)
		{
	?>
    		<option value="<?=$datas['catid']?>"><?=$datas['catid']?></option>
    <?php
		}
		?>
</select>
<select name="cat" style="width:300px;height:30px;">
    <option value="">-------------------SELECT CATID----------------------------</option>
<?php
		$query2 = "SELECT * FROM `tbl_sub_category`";
		$result2 = $classobj->fetcharray($classobj->runquery($query2));
		
		foreach($result2 as $datas)
		{
	?>
    		<option value="<?=$datas['subcatid']?>"><?=$datas['subcatid']?></option>
    <?php
		}
		?>
</select>
<input type="text" name="page" placeholder="PAGE" style="width:300px;height:30px;">
<input type="submit" name="submit" style="height:30px;">
</form>
</html>