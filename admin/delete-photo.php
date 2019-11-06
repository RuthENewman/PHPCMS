<?php require_once("includes/init.php"); ?>

<?php if(!$session->isSignedIn()) { redirect("login.php"); }?>

<?php 

if(empty($_GET['id'])) {
    redirect("photos.php");
}
$photoID = (int) $_GET['id'];

$photo = Photo::find($photoID);

if($photo) {
    $photo->deletePhoto();
    redirect("photos.php");
} else {
    redirect("photos.php");
}


?>
