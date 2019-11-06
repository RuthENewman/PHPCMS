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
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Title</th>
                                    <th>File Name</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($photos as $photo) : ?>
                                    <tr>
                                    <td><?php echo $photo->photo_id; ?></td>
                                    <td><img class="thumbnail" style="height: 200px; width: 200px;" src="<?php echo $photo->picturePath();?>" alt="" />
                                        <div class="photo-link">
                                            <a href="delete-photo.php?id=<?php echo $photo->photo_id; ?>">Delete</a>
                                            <a href="edit-photo.php?id=<?php echo $photo->photo_id; ?>">Edit</a>
                                            <a href="#">View</a>
                                        </div>
                                    </td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->filename; ?></td>
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