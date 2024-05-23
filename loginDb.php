<?php
$namn = $_POST['username'];
$lösenord = $_POST['password'];


if(loginCorrect($namn,$lösenord) && !empty($namn)){
    session_set_cookie_params(0);
    session_start();
    $_SESSION['USERID'] = getUserID($namn,$lösenord);
    $_SESSION['CURRENCY'] = getUserCurrency();
    header("Location: ./index.php");
    exit();
}
else{
    echo "Inlogg misslyckades!";
}

function loginCorrect($namn,$lösenord){
$db = new SQLite3 ("./db/database.db");
$result = $db -> query('SELECT username, password FROM User');
while($person = $result -> fetchArray()){
    if(strcmp($namn, $person['username']) == 0 && password_verify($lösenord, $person['password'])){
        return true;
    }
}
return false;
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

function getUserCurrency(){
    $db = new SQLite3 ("./db/database.db");
$result = $db -> query('SELECT currency, userID FROM User');
while($person = $result -> fetchArray()){
    if(strcmp($person['userID'], $_SESSION['USERID']) == 0){
        return $person['currency'];
    }
}
return 0;
}
?> 