<?php include("includes/header.php"); ?>

<?php if(!$session->isSignedIn()) { redirect("login.php"); }?>

<?php 
    $photos = Photo::findAll();

?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->

            <?php include("includes/top-nav.php"); ?>
                
            <?php include("includes/side-nav.php"); ?>

            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Photos
                        <small>Subheading</small>
                    </h1>
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>ID</tH>
                                    <th>File Name</th>
                                    <th>Title</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($photos as $photo) : ?>
                                    <tr>
                                    <td><img src="http://placehold.it/62x62" alt="" /></td>
                                    <td><?php echo $photo->photo_id; ?></td>
                                    <td><?php echo $photo->filename; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                </tr>
                              <?php endforeach ?>
                                

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>