<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    if(isset($_SESSION['USERID'])){
        require __DIR__ . '/getDeck.php';
        $_SESSION['DECKID'] = getDeckID();
    }
    else{
        header("Location: ./logOut.php");
        exit();
    }?>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="blackjack.css">
    <title>Hemsida</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
    let playerCurrency = Number('<?php echo $_SESSION['CURRENCY'] ?>');
    let playerBet = 0;
    let playerScore = 0;
    let houseScore = 0;
    let houseHiddenCard;

    function shuffleDeck() {
        let deck_id = '<?php echo $_SESSION['DECKID']?>';
        $.get("https://deckofcardsapi.com/api/deck/" + deck_id + "/shuffle/?deck_count=6", function(data) {});
    }

    function valueEncoder(value) {
        if (value === "JACK" || value === "QUEEN" || value === "KING") {
            return 10;
        } else if (value === "ACE") {
            return (playerScore + 11 > 21) ? 1 : 11;
        } else {
            return Number(value);
        }
    }

    function createPlayerDiv(input) {
        let cards = input.cards[0];
        var cardval = valueEncoder(cards.value);
        playerScore += cardval;
        let img = "<img src=\"" + cards.image + "\">";
        let div = `<div>${img}<br></div>`;
        $('#bottom').append(div);
        $('#score-bottom').children().last().remove();
        let scoreDiv = `
        <div>Score: ${playerScore}</div>
        `;
        $('#score-bottom').append(scoreDiv);
    }

    function createHouseDiv(input) {
        let cards = input.cards[0];
        var cardval = valueEncoder(cards.value);
        houseScore += cardval;
        let img = "<img src=\"" + cards.image + "\">";
        let div = `<div>${img}<br></div>`;
        $('#top').append(div);
        $('#score-top').children().last().remove();
        let scoreDiv = `
        <div>Score: ${houseScore}</div>
        `;
        $('#score-top').append(scoreDiv);
    }

    function updateVisualCurrency(){
        let currencyDiv = `<p>Money: ${playerCurrency}</p>
        `;
        $('#money').children().last().remove();
        $('#money').append(currencyDiv);
    }

    window.onload = function() {
        playerScore = 0;
        houseScore = 0;
        let img = "<img src=\"" + "https://deckofcardsapi.com/static/img/back.png" + "\">";
        let div = `<div>${img}<br></div>`;
        $('#top').append(div);
        $('#top').append(div);
        $('#bottom').append(div);
        $('#bottom').append(div);
        $('#money').show();
        $('#score-top').hide();
        $('#score-bottom').hide();
        updateVisualCurrency();
       
    };

    function addHidden(input) {
        houseHiddenCard = input;
        let img = "<img src=\"" + "https://deckofcardsapi.com/static/img/back.png" + "\">";
        let div = `<div>${img}<br></div>`;
        $('#top').append(div);
    }

    function blackjack() {
        shuffleDeck();
        $('#top').children().remove();
        $('#bottom').children().remove();
        playerScore = 0;
        houseScore = 0;
        drawCard().then(data => createPlayerDiv(data));
        drawCard().then(data => createPlayerDiv(data));
        drawCard().then(data => createHouseDiv(data));
        drawCard().then(data => addHidden(data));
        $('#blackjack_button').remove(); 
        $('#hit-button').show();
        $('#double-button').show();
        $('#stay-button').show();
        $('#score-top').show();
        $('#score-bottom').show();
    }

    function drawCard() {
        let deck_id = '<?php echo $_SESSION['DECKID']?>';
        return $.get("https://deckofcardsapi.com/api/deck/" + deck_id + "/draw/?count=1");
    }

    function housePlay() {
        createHouseDiv(houseHiddenCard);
        checkHouseScore();
    }

    function stay() {
        $('#top').children().last().remove();
        housePlay();
    }

    function playerWin() {
        notifyResult("PLAYER WON");
        gameOver(true);
    }

    function notifyResult(result){
        let para = `
        <div>${result}</div>
        `;
        $('#result').append(para);
    }

    function push() {
        notifyResult("PUSH");
        gameOver();
    }

    function checkHouseScore() {
        if (houseScore < 17) {
            drawCard().then(data => {
                createHouseDiv(data);
                checkHouseScore();
            });
        } else if (houseScore >= 17 && houseScore < 22) {
            if (houseScore > playerScore) {
                houseWin();
            } else if (houseScore < playerScore) {
                playerWin();
            } else {
                push();
            }
        } else {
            playerWin();
        }
    }

    function houseWin() {
        notifyResult("HOUSE WON");
        gameOver();
    }

    function checkPlayerScore() {
        if (playerScore > 21) {
            notifyResult("BUST");
            gameOver();
        }
        else if(playerScore == 21){
            stay();
        }
    }

    function playerHit(playerDoubled) {
        drawCard().then(data => {
            createPlayerDiv(data);
            checkPlayerScore();
        });
    }

    function resetPage() {
        playerScore = 0;
        houseScore = 0;
        $('#top').children().remove();
        $('#bottom').children().remove();
        $('#score-top').children().remove();
        $('#score-bottom').children().remove();
        let img = "<img src=\"" + "https://deckofcardsapi.com/static/img/back.png" + "\">";
        let div = `<div>${img}<br>${houseScore}<br></div>`;
        $('#top').append(div);
        $('#top').append(div);
        $('#bottom').append(div);
        $('#bottom').append(div);
        playerBet = 0;
        
    }

    function playAgain(){
        $('#button-container').children().last().remove();
        let blackjackButton = '<button id="blackjack_button" onclick="blackjack()">Spela blackjack</button>';
        $('#button-container').append(blackjackButton);
        $('#result').children().last().remove();
        resetPage();
    }

    function getPlayerWinnings(playerWon){
        if(playerWon){
            return playerCurrency += playerBet*2;
        }
        else{
            return playerCurrency;
        }
    }

    function gameOver(playerWon) {
        winnings = getPlayerWinnings(playerWon);
        updateCurrency(winnings);
        updateVisualCurrency();
        $('#hit-button').hide();
        $('#double-button').hide();
        $('#stay-button').hide();
        let playAgainButton = '<button id="playagain_button" onclick="playAgain()">Spela igen</button>';
        $('#button-container').append(playAgainButton);
        playerBet = 0;
       
    }
    function placeBet(bet){
        if(playerCurrency-bet >= 0){
            playerBet += bet;
            playerCurrency -= bet;
            updateVisualCurrency();
            updateCurrency(playerCurrency);
        }
        else{
            alert("Not enough money");
        }
    }

    function updateCurrency(newCurrency) {
    $.ajax({
        url: 'updateCurrency.php',
        type: 'POST',
        data: { currency: newCurrency },
        success: function(response) {
            console.log(response);
            playerCurrency = Number('<?php echo $_SESSION['CURRENCY']?>');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error updating currency: ', textStatus, errorThrown);
        }
    });

}
</script>

</head>
<body>
    <?php if(isset($_SESSION['USERID'])): ?>
        <div class="center-flex" id="container">
            <a href="./displaycomments.php">
                <button style="font-size:25px;background-color: aquamarine; border-radius: 10px;">Kommentarer</button>
            </a>
            <div id="top">
                
            </div>
            <div id="bottom">
                
                
            </div>
            
            <div id="result"></div>
            <div id="score-top"></div>
            <div id="score-bottom"></div>
            <div id="betting">
                <p id="p-bet">Bet</p>
                <div id="bet-button-container">
                <button id="bet-10" onclick="placeBet(10)" style="font-size:10;background-color:red;color:white;">10</button>
                <button id="bet-10" onclick="placeBet(50)" style="font-size:10;background-color:red;color:white;">50</button>
                <button id="bet-10" onclick="placeBet(100)" style="font-size:10;background-color:red;color:white;">100</button>
                </div>
                
            <div id="money"></div>
            </div>
            
            <div id="button-container">
                <button id="blackjack_button" onclick="blackjack()">Spela blackjack</button>
                <button id="hit-button" onclick="playerHit(false)" style="display: none;">Hit</button>
                <button id="double-button" onclick="playerHit(true)" style="display: none;">Double</button>
                <button id="stay-button" onclick="stay()" style="display: none;">Stay</button>
            </div>
        </div>
    <?php else: ?>
        <section>
            <h2>DU ÄR INTE INLOGGAD</h2>
            <button>Gå tillbaka</button>
        </section>
    <?php endif ?>
</body>
</html>
