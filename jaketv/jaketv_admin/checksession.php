<?php
	if(!isset($_SESSION['admin_user_id']) && !isset($_SESSION['admin_email']))
	{
		@header("location://".$_SESSION["ADMINPATH"]);
	}
?>