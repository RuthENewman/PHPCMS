<?php require_once("includes/init.php"); ?>

<?php if(!$session->isSignedIn()) { redirect("login.php"); }?>

<?php 

if(empty($_GET['id'])) {
    redirect("users.php");
}
$userID = (int) $_GET['id'];

$user = User::find($userID);

if($user) {
    $user->delete();
    redirect("users.php");
} else {
    redirect("users.php");
}


?>
