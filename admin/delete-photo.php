<?php require_once("includes/init.php"); ?>

<?php if(!$session->isSignedIn()) { redirect("login.php"); }?>

<?php 

echo "Working";

?>