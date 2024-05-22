<?php
session_start();
if (!isset($_SESSION['USERID'])) {
    header("Location: ./login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="displaycomments.css">
    <title>Comments</title>
</head>
<body>
    <div class="header"> <h1>Comments</h1> 
    </div> 
<br>
<br>
    <div class= "commentbox">
    <form action="addcomment.php" method="post">
        <textarea name="comment" placeholder="Write your comment here..." required></textarea>
        <button type="submit">Submit</button>
    </form>
    </div>
<br>
<br>

    <div class= "commentsection" id="comments-section">
    <h2> Previous Comments</h2> 
        <?php
        $db = new SQLite3("./db/database.db");
        $query = "SELECT Comments.comment, User.username 
                  FROM Comments 
                  JOIN User ON Comments.userID = User.userID 
                  ORDER BY Comments.commentID DESC";
        $result = $db->query($query);

        while ($row = $result->fetchArray()) {
            echo "<p><b>{$row['username']}:</b> {$row['comment']}</p>";
        }

        $db->close();
        ?>
        <a href="./index.php">
        <button style="font-size:25px;background-color: aquamarine; border-radius: 10px;">Home</button>

    </div>
</body>
</html>
