<?php 
	ob_start();
	include("servicesclass.php");
	$classobj = new servicecalss();
	$json_array = array("method"=>"GetPostByCategory","userid"=>"1","catid"=>"7","Page"=>"0");
	$result = $classobj->TranslateNull($json_array);
	header("location:service.php?data=".$result);
?>