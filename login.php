<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggad</title>
</head>
<body>
    <h1>Logga in</h1>
<div class="loginInput" id="container">
            <p>
                <form name="register" action="loginDb.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Användarnamn...">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Lösenord">
                    <input type="submit" value="Skicka"> 
                </form>
            </p>
        </div>
        <a href="./registration.php" class="button">Registrera dig</a>
</body>
</html>