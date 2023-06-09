<?php
    require('connect-db.php');
    require('db-logic.php');

    if(!empty($_POST['logOutBtn'])) {
      logOut();
    }
    //Check if user is logged in
    $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
    //echo $isLoggedIn;

    if (isset($_FILES['image_upload']) && !empty($_FILES['image_upload']['tmp_name'])) {
      $image_data = file_get_contents($_FILES['image_upload']['tmp_name']);
      newPost($image_data, $_POST['flexRadioDefault']);
      header('Location: home.php');

  } 


    $curTag = getTag($_SESSION['username'])[0]['tag'];
    $posts = getPosts($curTag);
    foreach ($posts as &$row) {
      // Encode image data as base64 string
      $row['image_data'] = base64_encode($row['image_data']);
    }
    if(isset($_SESSION['email'])) {
      $postsJSON = json_encode($posts); 
      
      $displayVotes = getDisplayVotes();
      $displayVotesJSON = json_encode($displayVotes);
      // foreach ($displayVotes as $row) {  
      //   echo "Post ID: " . $row["postID"] . "<br>";
      //   echo "Like Tally: " . $row["totalVotes"] . "<br>";
      // }

      $userVotes = getUserVotes($_SESSION['username']);
      $userVotesJSON = json_encode($userVotes);
    }
    
    // foreach ($userVotes as $row) {  
    //   echo "Post ID: " . $row["postID"] . "<br>";
    //   echo "user Tally: " . $row["vote"] . "<br>";
    // }

    //$_SESSION['username']
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      //echo "test";
      

      // VOTE UPDATE
      if(isset($_POST['vote']) && isset($_POST['post_id'])) {
        $vote = $_POST['vote'];
      
        echo $vote;
        $postId = $_POST['post_id'];
        $username = $_SESSION['username'];
        updateVotes($postId, $username, $vote);
      }

      if(isset($_POST['tagBtn'])) {
        updateTag($_SESSION['username'], $_POST['tagBtn']);
      }

      if(isset($_POST['delete-btn'])) {
        deletePost($_POST['delete-btn']);
      }

      header('Location: home.php');

    }
    
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
      .arrow-container {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
      }

      .upvote-btn {
        margin-bottom: 10px;
      }
      .downvote-btn {
        margin-top: 10px;
      }

      .button-container {
        display: flex;
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
            <li class="list-inline-item"><a href="#">Home</a></li>
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
    <form id="tagForm" action="home.php" method="post">
      <button type="submit" class="btn btn-primary" name="tagBtn" value="memes">memes</button>
      <button type="submit" class="btn btn-success" name="tagBtn" value="pets">pets</button>
      <button type="submit" class="btn btn-danger" name="tagBtn" value="sports">sports</button>
      <button type="submit" class="btn btn-light" name="tagBtn" value="none">clear tags</button>
    </form>
      <?php if ($isLoggedIn) { ?>
      <div class="container text-center">  <!-- NEW POST BUTTON -->
        <p>
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#newPostButton" aria-expanded="false" aria-controls="newPostButton">
            New Post
          </button>
        <div class="collapse" id="newPostButton">
          <div class="card card-body mx-auto">
            <h3>Upload an Image</h3>
            <form method= "post" action= "home.php" enctype="multipart/form-data">
              <div class="form-group">
                <input type="file" class="form-control-file" id="image-upload" name="image_upload" accept="image/*">
              </div>
              <h3>Choose Tag</h3>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="memes" checked>
                  <label class="form-check-label" for="flexRadioDefault1">
                    memes
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="pets">
                  <label class="form-check-label" for="flexRadioDefault2">
                    pets
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="sports">
                  <label class="form-check-label" for="flexRadioDefault2">
                    sports
                  </label>
                </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>

          </div>
        </div>
        <?php } else { ?>
          <p>You must be logged in to create a new post.</p>
          <?php } ?>
      </div>

      <!-- DUMMY CARDS FOR REFERENCE -->
      <!-- <div class="container row justify-content-left post">
        <div class="col-md-4 col-12">
          <div class="card-container">
            <div class="card" style="width: 18rem;">
              <img class="card-img-top" src="img/cola-0247.jpg" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">Cute smiley corgi</h5> -->
                <!-- p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p-->
                <!-- <div class="card-body tag">
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
        </div> -->

        
        <!-- Infinite scrolling code -->
        <div id="card-container">
        </div>
        <div id="loader" class="container d-flex justify-content-center align-items-center">
          <div class="skeleton-card"></div>
        </div>
        <div class="card-actions">
          <span>Showing 
            <span id="card-count"></span> of 
            <span id="card-total"></span> cards      
          </span>
        </div>
        <!-- <div class="gap"></div>
        <div class="card-container">
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="img/cola-0247.jpg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Cute smiley corgi</h5> -->
              <!-- p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p-->
              <!-- <div class="card-body tag">
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
      </div> -->
      <form id="voteForm" action="home.php" method="post">
        <!-- add a hidden input field -->
        <input type="hidden" id="post_id" name="post_id" value="">
        <input type="hidden" id="vote" name="vote" value="">
      </form>
    </main>
    <!-- CLIENT SIDE RENDERING -->
    <script>
      // THIS BLOCK GETS THE POSTS FROM THE PHP BACK END
      var posts = <?php echo $postsJSON; ?>;
      for (var i = 0; i < posts.length; i++) {
        //Retrieve data from each post's image_data field and append it into the image prefix for a valid url
        posts[i].image_data = 'data:image/jpeg;base64,' + posts[i].image_data;
      }
      console.log(posts['postID']);

      var displayVotes = <?php echo $displayVotesJSON; ?>;
      console.log(displayVotes);
      var userVotes = <?php echo $userVotesJSON; ?>;
      console.log(userVotes);

      /* SAMPLE IMAGE RENDERING
      var img = document.createElement('img');
      img.src = 'data:image/jpeg;base64,' + posts.image_data;
      document.body.appendChild(img);
      */

      /* TODO:
      0. MAKE SURE TO WORK IN NEW BRANCH, CAN GET MESSY
      1. https://webdesign.tutsplus.com/tutorials/how-to-implement-infinite-scrolling-with-javascript--cms-37055
         create infinite scroll using url tutorial above. do not need to worry about loader/loading animation or other things. just need the basic feature of infinite scroll
      2. Under "Defining Constants" we only need cardContainer.
      3. Set cardLimit = posts.length
      4. cardIncrease doesnt matter. can just be 5 for now.
      5. Under "Creating a New Card", we do not need any of the extra stuff like card background color. just implement basic feature like:
                      const createCard = (index) => {
                           const card = document.createElement("div");
                          card.className = "card";
                          card.innerHTML = index;
                          cardContainer.appendChild(card);
                        };
      */
                
    
      //Infinite loading code
      //Source: https://webdesign.tutsplus.com/tutorials/how-to-implement-infinite-scrolling-with-javascript--cms-37055
      const cardContainer = document.getElementById("card-container");
      const cardCountElem = document.getElementById("card-count");
      const cardTotalElem = document.getElementById("card-total");
      const loader = document.getElementById("loader");

      const cardLimit = posts.length;
      const cardIncrease = 2;
      const pageCount = Math.ceil(cardLimit / cardIncrease);
      let currentPage = 1;

      cardTotalElem.innerHTML = cardLimit;

      //Infinite scrolling optimization; Limits the number of calls made to handleInfiniteScroll
      var throttleTimer;
      const throttle = (callback, time) => {
        if (throttleTimer) return;

        throttleTimer = true;

        setTimeout(() => {
          callback();
          throttleTimer = false;
        }, time);
      };

      const createCard = (post) => {
        const card = document.createElement("div");
        card.className = "card";
        const img = document.createElement("img");
        img.src = post.image_data;
        img.style.height = "90%";

        const buttonContainer = document.createElement("div");
        buttonContainer.className = "button-container";

        const viewComments = document.createElement("button");
        viewComments.textContent = "View Comments";
        viewComments.classList.add("btn");
        viewComments.id = "comment-btn";

        const deleteForm = document.createElement("form");
        deleteForm.method = "post";

        const tagBtn = document.createElement("button");
        tagBtn.type = "button";
        console.log(post.tag);
        if (post.tag == 'memes') {
          tagBtn.classList.add("btn", "btn-primary");
          tagBtn.textContent = 'memes';
        } else if (post.tag == 'pets') {
          tagBtn.classList.add("btn", "btn-success");
          tagBtn.textContent = 'pets';
        } else if (post.tag == 'sports') {
          tagBtn.classList.add("btn", "btn-danger");
          tagBtn.textContent = 'sports';
        }
        

        const deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Delete";
        deleteBtn.classList.add("btn");
        deleteBtn.id = "delete-btn";
        deleteBtn.name = "delete-btn";
        deleteBtn.value = post.postID;

        const arrowContainer = document.createElement("div");
        arrowContainer.className = "arrow-container";

        const upvoteBtn = document.createElement("button");
        upvoteBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        upvoteBtn.classList.add("btn", "upvote-btn");

        const downvoteBtn = document.createElement("button");
        downvoteBtn.innerHTML = '<i class="fas fa-arrow-down"></i>';
        downvoteBtn.classList.add("btn", "downvote-btn");

        const karma = document.createElement("span");
        karma.textContent = displayVotes.find(vote => vote.postID === post.postID)?.totalVotes ?? "0";

        voteStatus = userVotes.find(vote => vote.postID === post.postID)?.vote;
        if (voteStatus === 1) {
          upvoteBtn.style.color = "blue";
        } else if (voteStatus === -1) {
          downvoteBtn.style.color = "red";
        }

        
        //Displays the comments and allows a user to post their own comment
        viewComments.addEventListener("click",() => showComments(viewComments));

        deleteForm.appendChild(deleteBtn);
        buttonContainer.appendChild(tagBtn);
        buttonContainer.appendChild(viewComments);
        buttonContainer.appendChild(deleteForm);
        
        
        arrowContainer.appendChild(upvoteBtn);
        arrowContainer.appendChild(karma);
        arrowContainer.appendChild(downvoteBtn);

        card.appendChild(img);
        card.appendChild(buttonContainer);
        card.appendChild(arrowContainer);

        upvoteBtn.addEventListener("click", () => {
          curvote = userVotes.find(vote => vote.postID === post.postID)?.vote;
          console.log(curvote)
          if (curvote == 1) {
            uservote = 0;
          } else {
            //post.like_tally++;
            uservote = 1;
            
          }
          document.getElementById("vote").value = uservote;
          document.getElementById("post_id").value = post.postID;
          document.getElementById("voteForm").submit();
        });

        downvoteBtn.addEventListener("click", () => {
          curvote = userVotes.find(vote => vote.postID === post.postID)?.vote;
          if (curvote == -1) {
            uservote = 0;
          } else {
            uservote = -1;
          }
          document.getElementById("vote").value = uservote;
          document.getElementById("post_id").value = post.postID;
          document.getElementById("voteForm").submit();
          console.log(document.getElementById("vote").value)
        });

        deleteBtn.addEventListener("click", () => {
          console.log(deleteBtn.value);
        })
        
        cardContainer.appendChild(card);
      };

      function showComments(viewComments) {
        const modal = document.createElement("div");
        modal.className = "modal";

        const modalContent = document.createElement("div");
        modalContent.className = "modal-content";

        const closeBtn = document.createElement("button");
        closeBtn.className = "close-btn";
        closeBtn.innerHTML = "X";
        closeBtn.addEventListener("click", function() {
        modal.style.display = "none";
        });



        const textBox = document.createElement("textarea");
        textBox.classList.add("comment-box");
        textBox.placeholder = "Enter your comment here";
        const arrowContainer = viewComments.parentNode.nextSibling;

        modalContent.appendChild(closeBtn);
        modalContent.appendChild(textBox);
        modal.appendChild(modalContent);

        document.body.appendChild(modal);
        modal.style.display = "block";
        modalContent.appendChild(textBox);
        }

      console.log(cardLimit);
      console.log(createCard);
      
      const addCards = (pageIndex) => {
        currentPage = pageIndex;

        const startRange = (pageIndex - 1) * cardIncrease;
        const endRange = Math.min(startRange + cardIncrease, posts.length);

        cardCountElem.innerHTML = endRange;

        for (let i = startRange; i < endRange; i++) {
          createCard(posts[i]);
        }
      };

      
      //Adjusts the dimensions of the page to dynamically change as the user scrolls down the page
      const handleInfiniteScroll = () => {
        throttle(() => {
          const endOfPage =
            window.innerHeight + window.pageYOffset >= document.body.offsetHeight;

          if (endOfPage) {
            addCards(currentPage + 1);
          }

          if (currentPage === pageCount) {
            removeInfiniteScroll();
          }
        }, 1000);
      };  

      //Prevents infinite scrolling when user reaches the end of stored posts
      const removeInfiniteScroll = () => {
        loader.remove();
        window.removeEventListener("scroll", handleInfiniteScroll);
      };

      window.onload = function () {
        addCards(currentPage);
      };

      window.addEventListener("scroll", handleInfiniteScroll);
    </script> 

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>