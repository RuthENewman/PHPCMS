<?php require_once("includes/init.php"); ?>
<?php include("includes/header.php"); ?>

<?php if(!$session->isSignedIn()) { redirect("login.php"); }?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->

            <?php include("includes/top-nav.php"); ?>
                
            <?php include("includes/side-nav.php"); ?>

            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <?php include("includes/admin_content.php"); ?>

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>