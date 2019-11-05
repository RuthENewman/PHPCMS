<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin
            <small>Subheading</small>
        </h1>
        <?php   
            $photos = Photo::findAll();
            foreach($photos as $photo) {
                echo $photo->title . "<br />";
            }

            $photo = new Photo();
            $photo->title = "Relaxing Caribbean beach";
            $photo->size = 8;
            $photo->description = "Enjoying myself on the beach in the Caribbean!";
            $photo->type = "jpg";
            $photo->filename = "beach.jpg";
            $photo->save();
        ?>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Blank Page
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->