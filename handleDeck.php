<?php
$deckID = $_GET['deckID'];

$result = getDeckID($deckID);
header('Content-Type: text/plain');
echo $result;
function getDeckID($deckID){
    if($_SERVER["REQUEST_METHOD"] === "GET")
    $db = new SQLite3 ("./db/database.db");

        $stmt = $db->prepare('SELECT deckID FROM Deck WHERE deckID = :deckID');
        $stmt->bindValue(':deckID', $deckID, SQLITE3_TEXT);

        // Execute the query
        $result = $stmt->execute();

        // Fetch the result
        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Set the Content-Type header to text/plain
            
            // Output the deckID
            return $row['deckID'];
        } else {
            // If no deckID is found, return an error message
            
            echo "No deckID found.";
        }

        // Close the database connection
        $db->close();
}
else{
    $db = new SQLite3 ("./db/database.db");
    $sql = " INSERT INTO 'Deck' ('deckID') VALUES (:deckID)" ;
    $stmt = $db -> prepare ( $sql ); 
    $stmt -> bindParam (':deckID', $deckID, SQLITE3_TEXT);
    
    
    if ($stmt -> execute()) {
       
        $db -> close () ;
        return getDeckID($deckID);
        }
    else {
        $db -> close ();
        echo "Nedladdning misslyckades!";
        return null;
    }
}

catch{
    $db = new SQLite3 ("./db/database.db");
    $sql = " INSERT INTO 'Deck' ('deckID') VALUES (:deckID)" ;
    $stmt = $db -> prepare ( $sql ); 
    $stmt -> bindParam (':deckID', $deckID, SQLITE3_TEXT);
    
    
    if ($stmt -> execute()) {
       
        $db -> close () ;
        return getDeckID($deckID);
        
        }
    else {
        $db -> close ();
        echo "Nedladdning misslyckades!";
        return null;
    }
}
}
?>