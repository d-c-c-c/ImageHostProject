<?php

  require('connect-db.php');
  require('db-logic.php');

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['logOutBtn'])) {
        logOut();
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>My Website</title>
    <!-- Add the following lines to include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/index.css">
  </head>
  <body>
    <!-- Add the "container" class to the header and main sections -->
    <header class="container">
    <div class="d-flex align-items-center">
      <h1 class="mb-0 mr-auto">Image Host</h1> <!-- Use me-auto class for margin-right (end) spacing -->
      <nav>
        <ul class="list-inline mb-0">
          <!-- <li class="list-inline-item"><a href="#">Home</a></li> -->
          <?php 
          if(isset($_SESSION['email'])) {
            echo '<li class="list-inline-item">Welcome, '.$_SESSION['username'].'!</li>';
            echo '<li class="list-inline-item"><form method="post"><button type="submit" class="btn btn-dark" name="logOutBtn" value="log out">Log Out</button></form></li>';
          } else {
          echo '<li class="list-inline-item"><a href="login-form.php">Log In</a></li>';
          echo'<li class="list-inline-item"><a href="signup-form.php">Sign Up</a></li>';
          }
          ?>
        </ul>
        
      </nav>
    </div>
  </header>


    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-2" id="column1">
                    <h2>Column 1</h2>
                    <p>Search column (potentially)</p>
                </div>
                <div class="col-md-8" id="column2">
                  <h2>Image Host</h2>
                  <p>
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    New Post
                  </button>
                  </p>
                  <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                      <p>Upload an Image</p>
                      <form method= "post" action= "index.php" enctype="multipart/form-data">
                        <div class="form-group">
                          <input type="file" class="form-control-file" id="image-upload" accept="image/*">
                        </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-md-2" id="column3">
                    <h2>Column 3</h2>
                    <p>Tag navigation (potentially)</p>
                </div>
            </div>
        </div>   
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>