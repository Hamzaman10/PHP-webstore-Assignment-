<?php

require_once('includes/functions.php');
require_once('includes/config.php');

session_start();

$selectArtist = artist();
$selectMuseum = museum();
$selectShape = shape();

?>



<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
        <script src="js/misc.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">
    
</head>
<body >

<?php include 'includes/header.inc.php'; ?>
    
<main class="ui segment doubling stackable grid container">

    <section class="five wide column">
        <form class="ui form">
          <h4 class="ui dividing header">Filters</h4>

          <div class="field" name = 'Artist'>
            <label>Artist</label>
            <select class="ui fluid dropdown" name ='Artist'>
                <option value= 0>Select Artist</option>  
                <?php 
                while($artist = $selectArtist->fetch()){
                  echo "<option value='$artist[ArtistID]'>$artist[LastName]</option>";
                }
                    ?>
            </select>
          </div>  
          <div class="field">
            <label>Museum</label>
            <select class="ui fluid dropdown" name = 'Museum'>
                <option value= 0>Select Museum</option>  
                <?php
                while($museum = $selectMuseum->fetch()){
                  echo "<option value='$museum[GalleryID]'>$museum[GalleryName]</option>";
                }
                    ?>
            </select>
          </div>   
          <div class="field">
            <label>Shape</label>
            <select class="ui fluid dropdown" name = 'Shape'>
                <option value= 0>Select Shape</option>  
                <?php
                while($shape = $selectShape->fetch()){
                  echo "<option value='$shape[ShapeID]'>$shape[ShapeName]</option>";
                }
                    ?>
            </select>
          </div>   

            <button class="small ui orange button" type="submit" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <i class="filter icon"></i> Filter 
            </button>    

        </form>
    </section>
    

    <section class="eleven wide column">
        <h1 class="ui header">Paintings</h1>
        <ul class="ui divided items" id="paintingsList">

        <?php 
        $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
          if ($_GET["Artist"] != 0){
            $results = filterArtist($_GET["Artist"]);
          }
          elseif ($_GET["Museum"] != 0){
            $results = filterMuseum($_GET["Museum"]);
          }
          elseif ($_GET["Shape"] != 0){
            $results = filterShape($_GET["Shape"]);
          }
          elseif(($_GET["Artist"] == 0) &&  ($_GET["Museum"] == 0) && ($_GET["Shape"] == 0)){
            $results = noFilter();
          }
          elseif(empty($_GET["Artist"]) && empty($_GET["Museum"]) && empty($_GET["Shape"]) ){ //code for checking when page is first loaded up but doesnt seem to work
            $results = noFilter();
          }
          
          while($filter = $results->fetch()){
          
        ?>

          <li class="item">
            <a class="ui small image" href="Single-painting.php?id=<?php echo $filter["PaintingID"] ?>"><img src="images/art/works/square-medium/<?php echo $filter["ImageFileName"] ?>.jpg"></a>
            <div class="content">
              <a class="header" href="Single-painting.php?id=<?php echo $filter["PaintingID"] ?>"><?php echo $filter["Title"] ?></a>
              <div class="meta"><span class="cinema"><?php echo $filter["LastName"] ?></span></div>        
              <div class="description">
                <p><?php echo $filter["Excerpt"] ?>.</p>
              </div>
              <div class="meta">     
                  <strong><?php echo "$" . number_format($filter["Cost"]) ?></strong>
              </div>        
              <div class="extra">
                <a class="ui icon orange button" href="cart.php?id=<?php echo $filter["PaintingID"] ?>"><i class="add to cart icon"></i></a>
                <a class="ui icon button" href="addToFavorites.php?id=<?php echo $filter["PaintingID"] ?>&file=<?php echo $filter["ImageFileName"] ?>&title=<?php echo $filter["Title"] ?>"><i class="heart icon"></i></a>          
              </div>        
            </div>      
          </li>
            <?php }} ?>
        </ul>        
    </section>  
    
</main>    
    
  <footer class="ui black inverted segment">
      <div class="ui container">footer for later</div>
  </footer>
</body>
</html>