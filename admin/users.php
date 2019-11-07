<?php include("includes/header.php"); ?>

<?php if(!$session->isSignedIn()) { redirect("login.php"); }?>

<?php 
    $users = user::findAll();

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
                        Users
                    </h1>
                    <a href="add-user.php" class="btn btn-primary">Add User</a>
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user) : ?>
                                    <tr>
                                    <td><?php echo $user->id; ?></td>
                                    <td><img class="admin-user-thumbnail" style="height: 100px; width: 100px;" src="<?php echo $user->imagePathAndPlaceholder();?>" alt="" />
                                    <td><?php echo $user->email; ?>
                                        <div class="user-link">
                                            <a href="delete-user.php?id=<?php echo $user->id; ?>">Delete</a>
                                            <a href="edit-user.php?id=<?php echo $user->id; ?>">Edit</a>
                                            <a href="#">View</a>
                                        </div>
                                    </td>
                                    <td><?php echo $user->first_name; ?></td>
                                    <td><?php echo $user->last_name; ?></td>
                                      
                                    </td>
                                   
                                    
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