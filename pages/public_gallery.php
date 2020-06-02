<?php

    require_once("../config/class.user.php");
    // require_once("session.php");

	$user = new USER();

	// $username = $_SESSION['user_session'];

    //set number of pictures per page
    $query = $user->run_query("SELECT media_name FROM media");
    $query->execute();
    $number_of_results = $query->rowCount();

    $results_per_page = 6;
    //determine the number of pages needed
    $number_of_pages = ceil($number_of_results / $results_per_page);

    $page = 1;
    // determine whit page number the visitor is currently on
    if (!isset($_GET['page'])){
        $page = 1;
    }
    else{
        $page = $_GET['page'];
    }

    // determine the SQL limit starting number for the results on the displaying page
    $start_limit = ($page - 1) * $results_per_page;

    // retrieve data from the database
    $query = $user->run_query("SELECT * FROM media ORDER BY upload_time DESC
                            LIMIT $start_limit , $results_per_page");
    $query->execute();
    if($query->rowCount() < 1)
        $empty_gallery = "The Gallery is empty, post some Pictures!";
    else
        $pictures = $query->fetchAll();

?>

<!DOCTYPE HTML>
<html">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="./../Javascripts/stylesheet.css" rel="stylesheet" />
    <link rel="shortcut icon" href="media/fonts/fnbtree.png" type="image/png" />
    <title>Public gallery</title>
</head>
<header>
    <div class="header">
        <a href="#default" class="logo">Camagru</a>
        <div class="header-right">
            <a href="../index.php">Home</a>
            <a class="active" href="#home">Public Gallery</a>
            <a href="#about">About</a>
        </div>
    </div>
</header>
<body>

<div class="container">
   <nav class="nav-bar">
      <label class="h5">You have been redirected to Gallery; login to edit</label><hr />
  </nav>

  <div class="grid-container">
      <?php
        if (!empty($pictures)){
          foreach($pictures as $pic)
          {
              ?>
                <div class='grid-item'>
                    <?php echo "<img src='../media/images/". $pic['media_name'] . "'>"; ?>
                    <label id="image-label" for="image"><?php echo "Uploaded by: " . $pic['username'];?></label>
                </div>
                <?php
          }
        }
        else{
            echo "<h1>" . $empty_gallery . "</h1>";
        }
        ?>
  </div>
  <div class="page_numbers">
    <?php  // display links to pages
      for($page=1; $page <= $number_of_pages; $page++)
        echo "<a href='public_gallery.php?page=" . $page . "'>" . $page . "-</a>";
    ?>
  </div>
<?php include_once "footer.php";?>
</div>

</body>
</html">