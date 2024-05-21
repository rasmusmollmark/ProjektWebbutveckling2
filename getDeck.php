<?php
function getDeckID(){
    $db = new SQLite3 ("./db/database.db");
    $deckID = "";
    $stmt = $db->prepare('SELECT deckID FROM Deck');
    $stmt->bindValue(':deckID', $deckID, SQLITE3_TEXT);

    // Execute the query
    $result = $stmt->execute();

    // Fetch the result
    if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Set the Content-Type header to text/plain
        
        // Output the deckID
        return $row['deckID'];
    }
}
?>