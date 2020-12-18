<?php 
	ob_start();
	include("servicesclass.php");
	$classobj = new servicecalss();
	if(isset($_POST['submit']))
	{
		$catid = implode(',',$_POST['catid']);
		$json_array = array("method"=>"UnSelectCategoryByUser","userid"=>"1","catid"=>$catid);
		$result = $classobj->TranslateNull($json_array);
		header("location:service.php?data=".$result);
	}
?>
<form action="" method="post">
	<?php 
		$select = "SELECT * FROM `tbl_category` WHERE `status`=1";
		$result = $classobj->fetcharray($classobj->runquery($select));
		foreach($result as $datas)
		{
			?>
            <input type="checkbox" value="<?=$datas['catid']?>" name="catid[]"><?=$datas['category']?>
            <?php
		}
	?>
    <input type="submit" name="submit">
</form>