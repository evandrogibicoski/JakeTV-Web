<?php 
	ob_start();
	include("servicesclass.php");
	$classobj = new servicecalss();
	$json_array = array("method"=>"GetBookmarkByUserid","userid"=>"1","Page"=>"0");
	$result = $classobj->TranslateNull($json_array);
	header("location:service.php?data=".$result);
?>