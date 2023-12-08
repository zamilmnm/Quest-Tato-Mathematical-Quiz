<!-- logout while click the user img -->
<?php
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
