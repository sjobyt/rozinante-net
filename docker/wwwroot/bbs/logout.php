<?

// logout.php destroys session and returns to login form
// destroy all session variables

session_start();
 session_destroy();
// redirect browser back to login page

header("Location: ../index.php");

?>