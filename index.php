<?php
    require('connect-db.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>My Website</title>
    <!-- Add the following lines to include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/index.css">
    <script src="https://kit.fontawesome.com/9359bae789.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <!-- Add the "container" class to the header and main sections -->
    <header>
      <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Image Host</h1>
        <nav>
          <ul class="list-inline mb-0">
            <li class="tag1" style="background-color: #687FAD; padding: 5px; padding-left: 20px; padding-right: 20px; border-radius: 5px">Tag</li>
            <li class="tag1" style="background-color: #E9AEAE; padding: 5px; padding-left: 20px; padding-right: 20px; border-radius: 5px">Tag</li>
            <li class="tag1" style="background-color: #AEE9D3; padding: 5px; padding-left: 20px; padding-right: 20px; border-radius: 5px">Tag</li>
            <li class="list-inline-item"><a href="#">Home</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <main>
        <div class="container row justify-content-center buttonDiv">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              New Post
            </button>
          <!--
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
          -->
        </div>
        <div class="container row justify-content-center post">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="img/cola-0247.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Cute smiley corgi</h5>
              <!-- p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p-->
              <div class="card-body tag">
                <p>pet</p>
              </div>
            </div>
            <p class="date">Posted 4:07am 1/5/2023</p>
          </div>
          <div class="gap"></div>
          <div>
            <div>
              <img src="img/caret-up-solid.svg" width="30" alt="up-arrow"/>
            </div>
            <p style="font-size: 24px; font-family: Helvetica; font-weight: bold; color: #b4b4b4">+20</p>
            <div>
              <img src="img/caret-down-solid.svg" width="30" alt="down-arrow"/>
            </div>
          </div>
        </div>
        <!--
        <div class="row justify-content-center">
          <button type="button" class="btn btn-secondary upvote">upvote</button>
          <button type="button" class="btn btn-secondary downvote">downvote</button>
        </div>
-->
        <div class="container row justify-content-center post">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="img/cola-0247.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Cute smiley corgi</h5>
              <!-- p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p-->
              <div class="card-body tag">
                <p>pet</p>
              </div>
            </div>
            <p class="date">Posted 4:07am 1/5/2023</p>
          </div>
          <div class="gap"></div>
          <div>
            <div>
              <img src="img/caret-up-solid.svg" width="30" alt="up-arrow"/>
            </div>
            <p style="font-size: 24px; font-family: Helvetica; font-weight: bold; color: #b4b4b4">+20</p>
            <div>
              <img src="img/caret-down-solid.svg" width="30" alt="down-arrow"/>
            </div>
          </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
