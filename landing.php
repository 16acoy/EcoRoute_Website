<?php
        session_start();
        if (isset($_SESSION['logout']) || empty($_SESSION)) {
          unset($_SESSION['name']);
          unset($_SESSION['logout']);
          unset($_SESSION['csticket']);
          $style1 = "style='display:none;'";
          $style2 = "style='display:block;'";
        }
        else{
          $style2 = "style='display:none;'";
          $style1 = "style='display:block;'";
        }

    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRouteMCR</title>
    <link rel="stylesheet" href="styles/landing.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="scripts/api.js"></script>
</head>

<header>
    <h1>EcoRouteMCR</h1>
    <div class="dropdown">
        <input type = "image" class="dropbtn" src = "usericon.png">
        <div class="dropdown-content">
          <a <?php echo $style1;?> href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/profilepage.php">Profile Page</a>
          <a <?php echo $style1;?> href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/logout.php" onclick="window.open('http://studentnet.cs.manchester.ac.uk/systemlogout.php')">Log out</a>
          <a <?php echo $style2;?> href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/authentication.php">Log in</a>
          <a href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/contact.php">Contact Us</a>
        </div>
      </div>
  </header>
<body>
    <div class="text">
    <b>Travel Evergreen</b>
    <p>EcoRoute MCR aims to empower the individual when it comes to deciding their journey.</p>
    <p>Click "Start a journey" to see your potential carbon footprint and alternatives.</p>
		<form action="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/authentication.php" method = "POST">
      <span class="buttoncontainer"><input class = "button" type="submit" value="Start a journey"></span>
		</form>
    </div>
</body>
</html>