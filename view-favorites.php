<?php

session_start();

foreach($_SESSION['favorite'] as $key => $value){

    echo '<a href = Single-painting.php?id=' . $value[0] .'>';
    echo '<img src="images/art/works/small-square/"' . $value[1] .'.jpg" alt="...">';
    echo '</a>';
    echo $value[2]; 
    echo '<form action="/remove-favorites.php?'. $value[0] .'" method="get"';
    echo '<button type="submit">Click Me!</button> </form> </br>';

}

echo "was unable to get pictures to display but link works";

?>
