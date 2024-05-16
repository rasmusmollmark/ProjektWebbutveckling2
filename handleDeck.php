<?php
$deckID = $_GET['deckID'];

try{
    $db = new SQLite3 ("./db/database.db");
    $result = $db -> query('SELECT deckID FROM Deck');
    if($deckID = $result -> fetchArray()){
}


    while(){
        if(strcmp($namn, $person['username']) == 0 && password_verify($lösenord, $person['password'])){
            return true;
        }
    }
    return false;
    }

$db = new SQLite3 ("./db/database.db");
$sql = " INSERT INTO 'Deck' ('deckID') VALUES (:deckID)" ;
$stmt = $db -> prepare ( $sql ); 
$stmt -> bindParam (':deckID', $deckID, SQLITE3_TEXT);


if ($stmt -> execute()) {
   
    $db -> close () ;
    header("Location: ./mainpage.php");
    exit();
    return true;
    }
else {
    $db -> close ();
    echo "Nedladdning misslyckades!";
    return false;
}


?>