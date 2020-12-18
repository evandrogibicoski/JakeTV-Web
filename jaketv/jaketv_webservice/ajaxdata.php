<?php
include("../jaketv_admin/secure/config.php");
/*RESET ADMIN PASSWORD COMPLETE*/
if(isset($_POST["resetpass_user"]) && $_POST["resetpass_user"]=="1")
{
	$qry1 = qry_numRows("SELECT * FROM `tbl_user` WHERE `userid`='".$_POST["userid"]."' AND `email`='".$_POST["email"]."'");
	if($qry1 > 0)
	{
		$qry2 = qry_runQuery("UPDATE `tbl_user` SET `password`='".$_POST["new_pass"]."' WHERE `userid`='".$_POST["userid"]."' AND `email`='".$_POST["email"]."'");
		echo "1";
	}
	else
	{
		echo "2";
	}
}
/*RESET ADMIN PASSWORD COMPLETE*/
?>