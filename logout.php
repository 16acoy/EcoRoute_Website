<?php
        session_start();
        $_SESSION['logout'] = true;
        header("Location: https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/landing.php");
        die();
  
?>

