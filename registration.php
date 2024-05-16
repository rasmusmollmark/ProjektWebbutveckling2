<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrering</title>
        <link rel="stylesheet" href="registrationStyle.css">

        <script>
            function test(){
                let form = document.forms['register'];
			let uname = form['username'].value;
			let pword = form['password'].value;
                return true;
            /*if(uname.length > 0 && validateEmail(email) ){
                return true;
            }
            let error= "";
			if(uname.length < 4)
				error += "Username must be at least 4 letters long\r\n";
			if(!validateEmail(email))
				error += "Please enter a valid email address\r\n";
			alert(error)
			return false;
            }
            function validateEmail(email){
                email = email.trim()
                return (email.lastIndexOf(".") > email.indexOf("@") + 2 && email.indexOf("@") > 0 && email.length - email.lastIndexOf(".") > 2);*/
            }
        </script>
    </head>
    <body>
        <h1>Registera dig</h1>
        <div class="input" id="container">
            <p>
                <form name="register" action="registrationDb.php" method="post" onsubmit="test()">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Användarnamn...">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Lösenord">
                    <input type="submit" value="Skicka"> 
                </form>
            </p>
        </div>
        <a href="./login.php" class="button">Logga in</a>
    </body>

</html>