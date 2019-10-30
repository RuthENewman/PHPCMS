<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin
            <small>Subheading</small>
        </h1>
        <?php 
            $users = User::findAll();
            while ($user = mysqli_fetch_array($users)) {
                echo $user['email'] . "<br/>" . $user['first_name'] . " " . $user['last_name'] . "<br />";
            }

            $user = User::find(2);
            echo $user['first_name'];

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