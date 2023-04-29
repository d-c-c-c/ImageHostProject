<?php
    require('connect-db.php');
    require('db-logic.php');

    if (isset($_FILES['image_upload'])) {
      $image_data = file_get_contents($_FILES['image_upload']['tmp_name']);
      newPost($image_data);
      header('Location: home.php');
    }

    $posts = getPosts();
    foreach ($posts as &$row) {
      // Encode image data as base64 string
      $row['image_data'] = base64_encode($row['image_data']);
    }
    $postsJSON = json_encode($posts);
    
    /*foreach ($posts as $row) {
      echo "Post ID: " . $row["postID"] . "<br>";
      echo "Like Tally: " . $row["like_tally"] . "<br>";
      echo "Datetime Posted: " . $row["datetime_posted"] . "<br>";
      // print the image data if it exists
      if ($row["image_data"]) {
          echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image_data'] ).'"/>';
      }
      echo "<hr>";
    } */
?>

<!DOCTYPE html>
<html>
  <head>
    <title>My Website</title>
    <!-- Add the following lines to include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/index.css">
    <script src="https://kit.fontawesome.com/9359bae789.js" crossorigin="anonymous"></script>
    <style>
      .card-container {
        display: flex;
        flex-direction: row;
        align-items: center;
      }
      
      @media (max-width: 767.98px) {
        .col-sm-8 {
          max-width: none;
        }
      }
    </style>
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
      <div class="container col justify-content-right buttonDiv">
        <p>
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            New Post
          </button>
        </p>
        <div class="collapse" id="collapseExample">
          <div class="card card-body">
            <p>Upload an Image</p>
            <form method= "post" action= "home.php" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" class="form-control-file" id="image-upload" name="image_upload" accept="image/*">
              </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
      
     
      




        <div class="container row justify-content-left post">
        <div class="col-md-4 col-12">
          <div class="card-container">
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
            <div class="class-arrows">
              <div>
                <img src="img/caret-up-solid.svg" width="30" alt="up-arrow"/>
              </div>
              <p style="font-size: 24px; font-family: Helvetica; font-weight: bold; color: #b4b4b4">+20</p>
              <div>
                <img src="img/caret-down-solid.svg" width="30" alt="down-arrow"/>
              </div>
            </div>
          </div>
          <div class="gap"></div>
          <div class="card-container">
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
            <div class="class-arrows">
              <div>
                <img src="img/caret-up-solid.svg" width="30" alt="up-arrow"/>
              </div>
              <p style="font-size: 24px; font-family: Helvetica; font-weight: bold; color: #b4b4b4">+20</p>
              <div>
                <img src="img/caret-down-solid.svg" width="30" alt="down-arrow"/>
              </div>
            </div>
          </div>
        </div>
    </div>

      
    </main>
    <script>
      //console.log(posts[0][postID]);
      var posts = <?php echo $postsJSON; ?>;
      for (var i = 0; i < posts.length; i++) {
        posts[i].image_data = (posts[i].image_data);
      }
      console.log(posts[0]['postID']);


      var img = document.createElement('img');
      // Set the src attribute to the base64 string
      img.src = 'data:image/jpeg;base64,' + posts[1].image_data;
      // Append the image element to the document body
      document.body.appendChild(img);
    </script> 

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
