<!DOCTYPE html>
<html lang="en">
<head>
<?php session_start(); 
    if(!isset($_SESSION['USERID'])){
    header("Location: ./login.php");
    exit();
    }?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php if(isset($_SESSION['USERID'])):?>
        <div class="center-flex" id="container">
	<?php 

    ?>
	<button id="click_me" onclick="btn_click()">Click me!</button>
    <a href="./displaycomments.php">
        <button style="font-size:25px;background-color: aquamarine; border-radius: 10px;">Kommentarer</button>
    </a>
    <a href="./logOut.php">
        <button style="font-size:25px;background-color: aquamarine; border-radius: 10px;">Logga ut</button>
    </a>
    </div>
        <?php endif?>
       <?php if(!isset($_SESSION['USERID'])):?>
        
        <section>
    <h2>DU ÄR INTE INLOGGAD</h2>
    <button>Gå tillbaka</button>
   </section>
        <?php endif?>

    
</body>
</html>