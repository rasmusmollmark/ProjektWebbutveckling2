<?php
$namn = $_POST['username'];
$lösenord = password_hash($_POST['password'], PASSWORD_DEFAULT);

addToDatabase($namn,$lösenord);

function addToDatabase($namn,$lösenord){
$db = new SQLite3 ("./db/database.db");
$sql = " INSERT INTO 'User' ('username', 'password') VALUES (:username, :password)" ;
$stmt = $db -> prepare ( $sql ); 
$stmt -> bindParam (':username', $namn, SQLITE3_TEXT);
$stmt -> bindParam (':password', $lösenord, SQLITE3_TEXT);


if ($stmt -> execute()) {
   
    $db -> close () ;
    echo "Inlogg lyckades!";
    return true;
    }
else {
    $db -> close ();
    echo "Inlogg misslyckades!";
    return false;
}
}

function validateInput($name,$mail,$comment){
    return (validateMail($mail) && strlen(trim($name)) > 0 && strlen(trim($comment)) > 0);
}

function validateMail($mail){
    return filter_var($mail, FILTER_VALIDATE_EMAIL); 
    }

?> 