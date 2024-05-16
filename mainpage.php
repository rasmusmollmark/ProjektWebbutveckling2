<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hemsida</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script>

		function callPHP() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "handleDeck.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response from the PHP script
                    var response = xhr.responseText;
                    console.log(response);
                }
            };
            xhr.send();
        }
		window.onload = callPHP;
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