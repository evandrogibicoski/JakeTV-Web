<?php 
	ob_start();
	include("servicesclass.php");
	$classobj = new servicecalss();
	if(isset($_POST['submit']))
	{
	$json_array = array("method"=>"BookmarkPost","userid"=>"1","postid"=>$_POST['post'],"Page"=>"0");
	$result = $classobj->TranslateNull($json_array);
	header("location:service.php?data=".$result);
	}
?>

<form action="" method="post">
	<select name="post">
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
    <input type="submit" name="submit">
</form>