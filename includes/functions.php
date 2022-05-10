<?php

// Collection of functions to deal with SQL database

function setConnectionInfo($values=array()) {
      $connString = $values[0];
      $user = $values[1]; 
      $password = $values[2];

      $pdo = new PDO($connString,$user,$password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;      
}


function runQuery($pdo, $sql, $parameters=array())     {
    // Ensure parameters are in an array
    if (!is_array($parameters)) {
        $parameters = array($parameters);
    }

    $statement = null;
    if (count($parameters) > 0) {
        // Use a prepared statement if parameters 
        $statement = $pdo->prepare($sql);
        $executedOk = $statement->execute($parameters);
        if (! $executedOk) {
            throw new PDOException;
        }
    } else {
        // Execute a normal query     
        $statement = $pdo->query($sql); 
        if (!$statement) {
            throw new PDOException;
        }
    }
    return $statement;
}


function artist() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM Artists ORDER BY LastName", array());
    return $statement;
}

function museum() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM galleries ORDER BY GalleryName", array());
    return $statement;
}

function shape() {
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM shapes ORDER BY ShapeName", array());
    return $statement;
}

function filterArtist($artist){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM Paintings NATURAL JOIN Artists WHERE Paintings.ArtistID = ? ORDER BY YearOfWork", array($artist));
    return $statement;
}

function filterMuseum($museum){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM Paintings NATURAL JOIN Artists WHERE Paintings.GalleryID = ? ORDER BY YearOfWork", array($museum));
    return $statement;
}

function filterShape($shape){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM Paintings NATURAL JOIN Artists WHERE Paintings.ShapeID = ? ORDER BY YearOfWork LIMIT 20", array($shape));
    return $statement;
}

function noFilter(){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM Paintings NATURAL JOIN Artists ORDER BY YearOfWork LIMIT 20", array());
    return $statement;
}

/* Single-painting.php functions */

function getPainting($paintingID){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM paintings NATURAL JOIN Artists NATURAL JOIN galleries WHERE PaintingID = ?", array($paintingID));
    return $statement;
}

function getGenre($paintingID){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM Genres NATURAL JOIN PaintingGenres WHERE PaintingID = ?", array($paintingID));
    return $statement;
}

function getSubjects($paintingID){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM Subjects NATURAL JOIN PaintingSubjects WHERE PaintingID = ?", array($paintingID));
    return $statement;
}

function getFrame($paintingID){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM TypesFrames NATURAL JOIN OrderDetails WHERE PaintingID = ?", array($paintingID));
    return $statement;
}

function getGlass($paintingID){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM TypesGlass NATURAL JOIN OrderDetails WHERE PaintingID = ?", array($paintingID));
    return $statement;
}

function getMatt($paintingID){
    $pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
    $statement = runQuery($pdo, $sql = "SELECT * FROM TypesMatt NATURAL JOIN OrderDetails WHERE PaintingID = ?", array($paintingID));
    return $statement;
}

function getReview($paintingID){
$pdo = setConnectionInfo(array(DBCONNECTION, DBUSER, DBPASS));
$statement = runQuery($pdo, $sql = "SELECT * FROM Reviews NATURAL JOIN Paintings WHERE PaintingID = ?", array($paintingID));
return $statement;
}



?>