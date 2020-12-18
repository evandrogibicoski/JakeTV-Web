<?php 
	ob_start();
	$id = $_REQUEST['id'];
	$device = $_REQUEST['device'];
?>
<script>
<?php
	if ($device == "android") {
?>
window.location = "intent://jaketv/#Intent;scheme=jaketv;package=com.jaketv.jaketvapp;S.jaketvpassword=<?=$id?>;end";

<?php
	} else {
?>
window.location = "jaketvPassword://<?=$id?>";
<?php
	};
?>

</script>