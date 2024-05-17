<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start(); 
    echo $_SESSION['USERID'];
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hemsida</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script>
		function getDeck(){
			$.get("https://deckofcardsapi.com/api/deck/new/shuffle/?deck_count=6", function(data){
				return callPHP(data);
			});
        }
		
        function btn_click(){
			$.get("https://deckofcardsapi.com/api/deck/new/draw/?count=1", function(data){
				make_result(data);
			});
        }
		function make_result(input){

			let json = input.cards[0];
			// $('#container').empty();
			let img = "<img src=\"" + json.image + "\">";
			let div = `
				<div>
					${img}<br>
					Name: ${json.value} <br>
					
				</div>
			`;
			$('#container').append(div);
			console.log(input);
			console.log(input.data)
		}

		function callPHP(deckID) {
    // Construct the URL with parameters
    var url = "handleDeck.php?deckID="+deckid;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
            } else if (data) {
                console.log("Deck ID:", data.deckID);
                return data.deckID;
            } else {
                console.log("No deckID found.");
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
}
	</script>
</head>
<body>
<div class="center-flex" id="container">
	</div>
	<button id="click_me" onclick="btn_click()">Click me!</button>
    <a href="./displaycomments.php">
        <button style="font-size:25px;background-color: aquamarine; border-radius: 10px;">Kommentarer</button>
    </a>
</body>
</html>