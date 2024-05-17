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
    session_start();
    $_SESSION['USERID'] = getUserID($namn,$lösenord);
    $db -> close () ;
    header("Location: ./mainpage.php");
    exit();
    return true;
    }
else {
    $db -> close ();
    echo "Inlogg misslyckades!";
    return false;
}
}

function getUserID($namn,$lösenord){
    $db = new SQLite3 ("./db/database.db");
$result = $db -> query('SELECT userID, username, password FROM User');
while($person = $result -> fetchArray()){
    if(strcmp($namn, $person['username']) == 0 && password_verify($lösenord, $person['password'])){
        return $person['userID'];
    }
}
return "";

}

function validateInput($name,$mail,$comment){
    return (validateMail($mail) && strlen(trim($name)) > 0 && strlen(trim($comment)) > 0);
}

function validateMail($mail){
    return filter_var($mail, FILTER_VALIDATE_EMAIL); 
    }

?> 