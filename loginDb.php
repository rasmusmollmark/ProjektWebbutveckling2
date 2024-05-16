<?php
$namn = $_POST['username'];
$lösenord = $_POST['password'];


if(checkLogin($namn,$lösenord)){
    session_start();
    header("Location: ./mainpage.php");
    exit();
}
else{
    echo "Inlogg misslyckades!";
}

function checkLogin($namn,$lösenord){
$db = new SQLite3 ("./db/database.db");
$result = $db -> query('SELECT username, password FROM User');
while($person = $result -> fetchArray()){
    if(strcmp($namn, $person['username']) == 0 && password_verify($lösenord, $person['password'])){
        return true;
    }
}
return false;
}
?> 