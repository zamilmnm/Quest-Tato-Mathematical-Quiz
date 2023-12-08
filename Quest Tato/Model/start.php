<?php
// Start a PHP session
session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Start</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/Styles/start.css">
   
    <script>
      // setting session time out 
        var inactivityTime = 0;
        var sessionTimeout = 60; // 60 seconds (1 minute)

        function resetTimer() {
            inactivityTime = 0;
        }

        function logout() {
            // Implementing logout 
            alert('Session expired. You will be logged out.');
            // Redirect to the logout page or perform the necessary actions.
            window.location.href = 'logout.php'; // Adjust the logout page URL
        }

        // Detect user activity
        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keydown', resetTimer);

        // Increment inactivityTime every second if nothing then logout
        setInterval(function () {
            inactivityTime++;
            if (inactivityTime >= sessionTimeout) {
                logout();
            }
        }, 1000);
    </script>
  </head>
  <body>
    
    <div class="container">
      
      <div class="button" onclick="window.location.href='beginner.php'">
        <a href="#">BEGINNER</a>
      </div>
      <div class="button" onclick="window.location.href='intermediate.php'">
        <a href="#">INTERMEDIATE</a>
      </div>
      <div class="button" onclick="window.location.href='expert.php'">
        <a href="#">EXPERT</a>
      </div>
      <div class="button" onclick="window.location.href='welcome.php'">
        <a href="#">EXIT</a>
      </div>

    </div>
  </body>
</html>