<?php

require_once('includes/functions.php');
require_once('includes/config.php');

if ( isset($_GET['id']) ) {
    
    $genreResults = getGenre($_GET['id']);
    $subjectResults = getSubjects($_GET['id']);
    $paintingResults = getPainting($_GET['id']);
    $FrameResults = getFrame($_GET['id']);
    $glassResults = getGlass($_GET['id']);
    $MattResults = getMatt($_GET['id']);
    $reviewResults = getReview($_GET['id']);
    
    $painting = $paintingResults->fetch();
}else{

    $genreResults = getGenre(101);
    $subjectResults = getSubjects(101);
    $paintingResults = getPainting(101);
    $FrameResults = getFrame(101);
    $glassResults = getGlass(101);
    $MattResults = getMatt(101);
    $reviewResults = getReview(101);
    
    $painting = $paintingResults->fetch();
}

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

<main >
    <!-- Main section about painting -->
    <section class="ui segment grey100">
        <div class="ui doubling stackable grid container">
		
            <div class="nine wide column">
              <img src="images/art/works/medium/<?php echo $painting['ImageFileName'] ?>.jpg" alt="..." class="ui big image" id=<?php echo $painting['PaintingID'] ?>>
                
                <div class="ui fullscreen modal">
                  <div class="image content">
                      <img src="images/art/works/large/<?php echo $painting['ImageFileName'] ?>.jpg" alt="..." class="image" >
                      <div class="description">
                      <p></p>
                    </div>
                  </div>
                </div>                
                
            </div>	<!-- END LEFT Picture Column --> 
			
            <div class="seven wide column">
                
                <!-- Main Info -->
                <div class="item">
					<h2 class="header"><?php echo $painting['Title'] ?></h2>
					<h3 ><?php echo $painting['LastName']?></h3>
					<div class="meta">
						<p>
						<i class="orange star icon"></i>
						<i class="orange star icon"></i>
						<i class="orange star icon"></i>
						<i class="orange star icon"></i>
						<i class="empty star icon"></i>
						</p>
						<p><?php echo $painting['Excerpt'] ?></p>
					</div>  
                </div>                          
                  
                <!-- Tabs For Details, Museum, Genre, Subjects -->
                <div class="ui top attached tabular menu ">
                    <a class="active item" data-tab="details"><i class="image icon"></i>Details</a>
                    <a class="item" data-tab="museum"><i class="university icon"></i>Museum</a>
                    <a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a>
                    <a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a>    
                </div>
                
                <div class="ui bottom attached active tab segment" data-tab="details">
                    <table class="ui definition very basic collapsing celled table">
					  <tbody>
						  <tr>
						 <td>
							  Artist
						  </td>
						  <td>
							<a href="#"><?php echo $painting['LastName']?></a>
						  </td>                       
						  </tr>
						<tr>                       
						  <td>
							  Year
						  </td>
						  <td>
                          <?php echo $painting['YearOfWork']?>
						  </td>
						</tr>       
						<tr>
						  <td>
							  Medium
						  </td>
						  <td>
                          <?php echo $painting['Medium']?>
						  </td>
						</tr>  
						<tr>
						  <td>
							  Dimensions
						  </td>
						  <td>
                          <?php echo $painting['Height'] . ' x ' . $painting['Width'] ?>
						  </td>
						</tr>        
					  </tbody>
					</table>
                </div>
				
                <div class="ui bottom attached tab segment" data-tab="museum">
                    <table class="ui definition very basic collapsing celled table">
                      <tbody>
                        <tr>
                          <td>
                              Museum
                          </td>
                          <td>
                            <?php echo $painting['GalleryName']?>
                          </td>
                        </tr>       
                        <tr>
                          <td>
                              Assession #
                          </td>
                          <td>
                          <?php echo $painting['AccessionNumber']?>
                          </td>
                        </tr>  
                        <tr>
                          <td>
                              Copyright
                          </td>
                          <td>
                          <?php echo $painting['CopyrightText']?>
                          </td>
                        </tr>       
                        <tr>
                          <td>
                              URL
                          </td>
                          <td>
                            <a href="<?php echo $painting['GalleryWebSite'] ?>">View painting at museum site</a>
                          </td>
                        </tr>        
                      </tbody>
                    </table>    
                </div>     
                <div class="ui bottom attached tab segment" data-tab="genres">
 
                        <ul class="ui list">
                          <?php while($genre = $genreResults->fetch()){
                          echo "<li class='item'><a href='#'>$genre[GenreName]</a></li>";
                          }?>
                        </ul>

                </div>  
                <div class="ui bottom attached tab segment" data-tab="subjects">
                    <ul class="ui list">
                    <?php while($subject = $subjectResults->fetch()){
                          echo "<li class='item'><a href='#'>$subject[SubjectName]</a></li>";
                    }?>
                        </ul>
                </div>  
                
                <!-- Cart and Price -->
                <div class="ui segment">
                    <div class="ui form">
                        <div class="ui tiny statistic">
                          <div class="value">
                          <?php echo "$" . number_format($painting['Cost'])?>
                          </div>
                        </div>
                        <div class="four fields">
                            <div class="three wide field">
                                <label>Quantity</label>
                                <input type="number">
                            </div>                               
                            <div class="four wide field">
                                <label>Frame</label>
                                <select id="frame" class="ui search dropdown">
                                    <option value= 0>None</option>
                                    <?php while($Frame = $FrameResults->fetch()){
                                      echo "<option value='$Frame[FrameID]'>$Frame[Title]</option>";;
                                    }?>
                                </select>
                            </div>  
                            <div class="four wide field">
                                <label>Glass</label>
                                <select id="glass" class="ui search dropdown">
                                    <option>None</option>
                                    <?php while($glass = $glassResults->fetch()){
                                      echo "<option value='$glass[GlassId]'>$glass[Title]</option>";;
                                    }?>
                                </select>
                            </div>  
                            <div class="four wide field">
                                <label>Matt</label>
                                <select id="matt" class="ui search dropdown">
                                    <option>None</option>
                                    <?php while($matt = $MattResults->fetch()){
                                      echo "<option value='$matt[MattId]'>$matt[Title]</option>";;
                                    }?>
                                </select>
                            </div>           
                        </div>                     
                    </div>

                    <div class="ui divider"></div>

                    <button class="ui labeled icon orange button">
                      <i class="add to cart icon"></i>
                      Add to Cart
                    </button>
                    <button class="ui right labeled icon button">
                      <i class="heart icon"></i>
                      Add to Favorites
                    </button>        
                </div>     <!-- END Cart -->                      
                          
            </div>	<!-- END RIGHT data Column --> 
        </div>		<!-- END Grid --> 
    </section>		<!-- END Main Section --> 
    
    <!-- Tabs for Description, On the Web, Reviews -->
    <section class="ui doubling stackable grid container">
        <div class="sixteen wide column">
        
            <div class="ui top attached tabular menu ">
              <a class="active item" data-tab="first">Description</a>
              <a class="item" data-tab="second">On the Web</a>
              <a class="item" data-tab="third">Reviews</a>
            </div>
			
            <div class="ui bottom attached active tab segment" data-tab="first">
              <em><?php echo $painting['Description']?> </em>
            </div>	<!-- END DescriptionTab --> 
			
            <div class="ui bottom attached tab segment" data-tab="second">
				<table class="ui definition very basic collapsing celled table">
                  <tbody>
                      <tr>
                     <td>
                          Wikipedia Link
                      </td>
                      <td>
                        <a href="<?php echo $painting['WikiLink']?> ">View painting on Wikipedia</a>
                      </td>                       
                      </tr>                       
                      
                      <tr>
                     <td>
                          Google Link
                      </td>
                      <td>
                        <a href="<?php echo $painting['GoogleLink']?> ">View painting on Google Art Project</a>
                      </td>                       
                      </tr>
                      
                      <tr>
                     <td>
                          Google Text
                      </td>
                      <td>
                      <?php echo $painting['GoogleDescription']?> 
                      </td>                       
                      </tr>                      
                      
   
       
                  </tbody>
                </table>
            </div>   <!-- END On the Web Tab --> 

            <div class="ui bottom attached tab segment" data-tab="third">     
          <?php  while($review = $reviewResults->fetch()){ ?>           
				<div class="ui feed">
				  <div class="event">
					<div class="content">
						<div class="date"><?php echo $review['ReviewDate'] ?></div>
						<div class="meta">
							<a class="like">
							  <i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i><i class="star icon"></i>
							</a>
						</div>                    
						<div class="summary">
							<?php echo $review['Comment'] ?>        
						</div>       
					</div>
				  </div>
					
				<div class="ui divider"></div>                                  
            </div>   <!-- END Reviews Tab -->
          <?php } ?>          
        
        </div>        
    </section> <!-- END Description, On the Web, Reviews Tabs --> 
    
    <!-- Related Images ... will implement this in assignment 2 -->    
    <section class="ui container">
    <h3 class="ui dividing header">Related Works</h3>
    <a href="Single-painting.php?id=101">Andre Derain</a></br>
    <a href="Single-painting.php?id=105">Charing Cross Bridge</a></br>
	</section>  
	
</main>    
    

    
  <footer class="ui black inverted segment">
      <div class="ui container">footer</div>
  </footer>
</body>
</html>