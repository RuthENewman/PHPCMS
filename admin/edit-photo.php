<?php include("includes/header.php"); ?>

<?php if(!$session->isSignedIn()) { redirect("login.php"); }?>

<?php 
    if(empty($_GET['id'])) {
        redirect("photos.php");
    } else {
        $photo = Photo::find($_GET['id']);
        if(isset($_POST['update'])) {
            if($photo) {
                $photo->title = trim($_POST['title']);
                $photo->description = trim($_POST['description']);
                $photo->caption = trim($_POST['caption']);
                $photo->alternateText = trim($_POST['alternateText']);
                $photo->update();
                redirect("photos.php");
            }
        }
    }
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
                    <form action="" method="post">
                        <div class="col-md-8">
                            <div class="form-group">
                                <a class="thumbnail" href="#"><img style="height: 120px; width: 120px;" src="<?php echo $photo->picturePath();?>" alt=""></a>
                            </div>
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" value="<?php echo $photo->title;?>" />
                            </div>
                            <div class="form-group">
                                <label for="caption">Caption</label>
                                <input type="text" name="caption" class="form-control" value="<?php echo $photo->caption;?>"/>
                            </div>
                            <div class="form-group">
                                <label for="alternateText">Alternate Text</label>
                                <input type="text" name="alternateText" class="form-control" value="<?php echo $photo->alternateText;?>" />
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="" rows="10" cols="30">
                                    <?php echo trim($photo->description); ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-4" >
                                <div  class="photo-info-box">
                                    <div class="info-box-header">
                                    <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                    </div>
                                <div class="inside">
                                <div class="box-inner">
                                    <p class="text">
                                    <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                    </p>
                                    <p class="text ">
                                        Photo Id: <span class="data photo_id_box">34</span>
                                    </p>
                                    <p class="text">
                                        Filename: <span class="data">image.jpg</span>
                                    </p>
                                    <p class="text">
                                    File Type: <span class="data">JPG</span>
                                    </p>
                                    <p class="text">
                                    File Size: <span class="data">3245345</span>
                                    </p>
                                </div>
                                <div class="info-box-footer clearfix">
                                    <div class="info-box-delete pull-left">
                                        <a  href="delete-photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger btn-lg ">Delete</a>   
                                    </div>
                                    <div class="info-box-update pull-right ">
                                        <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                    </div>   
                                </div>
                                </div>          
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>