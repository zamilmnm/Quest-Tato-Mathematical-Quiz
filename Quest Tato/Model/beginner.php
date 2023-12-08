<?php

session_start();
// Start the database connection
$conn = new mysqli("localhost","root","","questtato");

// check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// session for retrieve the current logged player's username from session 
$username = $_SESSION['username'];

// logic for calculate player's score
$score = 0;
$input="";
$solution="";

if ($input == $solution) {
  $score += 1000;// increment by 1000 for correct answer
}
if ($input != $solution) {
    $score -= 100; // decrement by 100 for incorrect answer
}



// update player's score in the database
$sql = "UPDATE players SET score = '$score' WHERE username = '$username'";

if ($conn->query($sql) === TRUE) {
  
} 
else {
	echo "Error updating score: " . $conn->error;
}

// close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beginner Level</title>

   <!-- linking css -->
  <link rel="stylesheet" href="../View/Styles/game.css">
  <link rel="stylesheet" href="../View/Styles/life.css">

</head>

<body>

  </div>
    <!-- to show the Player detail in progress bar -->
    <span style="float: right; color: white;" > <?php echo $_SESSION['username']; ?></span>
      <a href="#"><img src="../View/Images/user.png"  alt="" style="float: right;"></a>
  </div>
  
<script>

  // Logout player while click the user icon
document.querySelector('img').addEventListener('click', function() {
  // send a logout request to the server using PHP sessions
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'logout.php');
  xhr.onload = function() {
    // redirect the user to the welcome page
    window.location.href = "welcome.php";
  };
  xhr.send();
});

</script>

 <!-- progress-bar-container -->
<div  id="progress-bar-container">
  <div id="progress-bar"></div>
</div>
  <h2 id="question-number-title" style="color: white;">Question: <span id="questionnumber">0</span>/10</h2>

  <h2 id="score-title" style="color: white;">Current Score: <span id="score">0</span></h2>

  <h2 id="time-left-title" align="center" style="color: white;">Time remaining:  <span id="timer">60 seconds</span></h2>

  <script>
    // Game time countdown
    let timeLeft = 60;
    let score = 0;
    let timer = setInterval(() => {
      timeLeft--;
      document.getElementById("timer").textContent = timeLeft;
      if (timeLeft <= 0) {
        clearInterval(timer);
        alert("Time up!");
      }
    }, 1000);

      // Game
    let Question = "";
    let solution = -1;
    let numQuestions = 0;
    let numIncorrect = 0;

    function newGame() {
      startup();
    }

    let progressBar = document.getElementById("progress-bar");

    //input handling
    function handleInput() {
      let input = document.getElementById("answer");
      let message = document.getElementById("message");

      // update the progress bar for incorrect answers
      let progressBar = document.getElementById("progress-bar");
      let maxIncorrect = 6;
     
      if (input.value == solution) {
        //score Increment
		    score += 1000;
        document.getElementById("score").textContent = score;
        
        numQuestions++;
        document.getElementById("questionnumber").textContent = numQuestions; // update the question number

        //allocate 10 questions for first level
        if (numQuestions >= 10) {
          clearInterval(timer);
          alert("Congratulations! You have completed the First Level.");
          updateScoreInDatabase();
          window.location.href = 'start.php';
          return;
        }

        // Wait 1 second before going to the next question
        setTimeout(newGame, 1000); 
        //display message when answer is correct
        message.innerHTML = 'Congratulations, Your answer is correct! Keep it up :) ';
        message.style.color = 'white';

      } else {
        numIncorrect++;
        // end game if 6 incorrect attempts 
        if (numIncorrect >= maxIncorrect) { 
          clearInterval(timer);
          alert("You have made too many incorrect attempts. Game over.");
          updateScoreInDatabase();
          window.location.href = 'start.php';
          return;
        }
        if(score>=100)
        // If the answer is incorrect, the score decrement  by 100 
		    score -= 100;
        //display message for incorrect answer
        document.getElementById("score").textContent = score;
        message.innerHTML = "Incorrect answer, You have lose in the Quest!";
        message.style.color = 'white';
     
        // Reduce progress bar length based on number of incorrect answers
        let reductionFactor = numIncorrect / 10; // Reduce by 10% per incorrect answer
        let newWidth = Math.max(0, progressBar.offsetWidth - (progressBar.offsetWidth * reductionFactor));
        progressBar.style.width = newWidth + "px";
  
  }
      // Clear the input field after each question attempt
      input.value = "";
    }

    async function TomatoQuest(data) {
      // reset the countdown timer
      clearInterval(timer);
      timeLeft = 60;
      timer = setInterval(() => {
        timeLeft--;
        document.getElementById("timer").textContent = timeLeft;
        if (timeLeft <= 0) {
          clearInterval(timer);
          handleTimeOut();       
        }
      }, 1000);

function updateScoreInDatabase() {
    // AJAX to send an asynchronous request to the server
    // and update the score in the database using PHP
    // Example using XMLHttpRequest
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'update_score.php', true);
  xhr.onload = function() {
      // Handle the response from the server if needed
  };
  xhr.send();
}

function handleTimeOut() {
  // increment question count
  numQuestions++;
  document.getElementById("questionnumber").textContent = numQuestions; // update the question number
  
  if (numQuestions >= 10) {
    // end the game if there are no more questions
    clearInterval(timer);
    alert("Congratulations! You have earned PRO badge.");
  } else {
    alert("Oops ): Time's up! You have lose in the Quest, Move to the next question.");
    setTimeout(newGame, 1000); // 1 second interval for next question
  }
}

    // update the question and solution
    Question = data.question;
    solution = data.solution;

    let img = document.getElementById("questionimg");
    img.src = data.question;

    let message = document.getElementById("message");
    message.innerHTML = "";
  }

      //fetch the question from Tomato api

      async function fetchText() {
        // Using the 'await' keyword to pause execution until the 'fetch' operation is complete
        let response = await fetch('https://marcconrad.com/uob/tomato/api.php');
        // Using the 'await' keyword again to pause execution until the 'json' method is complete
        let data = await response.json();
        // Calling the 'TomatoQuest' function with the retrieved data as an argument
        TomatoQuest(data);
      }
      // Thanks to Stackoverflow for refenced and learned the "async function"
      function startup() {
        fetchText();
      }

      startup();

    </script>

<div class="questions" align="center">
  <div>
    <p id="question"></p>
    <img id="questionimg" src="" alt="Question Image">
    <label for="quantity"><h2 style="color: white;">Enter the missing Number</h2></label>
    <input class="button-62" type="number" id="answer" name="answer" min="1" max="10" onkeydown="if (event.keyCode === 13) handleInput();">
    <input class="button-62" name="btnSubmit" type="submit" class="btn" id="btnSubmit" value="Check" onClick="handleInput()"/>
    <button class="button-62" type="exit" onclick="window.location.href='start.php'" >Exit</button>
    <div id="message"></div>
  </div>

</div>

</body>
</html>