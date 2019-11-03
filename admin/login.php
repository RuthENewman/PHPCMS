<?php require_once("includes/init.php"); ?>
<?php include("includes/header.php"); ?>

<?php
    $message = "";
    if($session->isSignedIn()) {
        redirect("index.php");
    }

    if(isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

    $userFound = User::verifyUser($email, $password);

    if($userFound) {
        $session->login($userFound);
        redirect('index.php');
    } else {
        $message = "Incorrect email or password.";
    }
    } else {
        $email = "";
        $password = "";
    }

?>

<div class="col-md-4 col-md-offset-3">

    <h4 class="bg-danger"><?php echo $message; ?></h4>
	
    <form id="login-id" action="" method="post">
	
        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlentities($email); ?>" >

        </div>

        <div class="form-group">
            <label for="password">Your Password</label>
            <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
            
        </div>

        <div class="form-group">
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">

        </div>
    </form>
</div>