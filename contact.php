<?php
        session_start();

        if (isset($_SESSION['name'])) {
                $style1 = "style='display:none;'";
                $style2 = "style='display:block;'";
            }
            else {
                $style2 = "style='display:none;'";
                $style1 = "style='display:block;'";
            }

?>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/landing.css">
    <link rel="stylesheet" href="styles/contact.css">
    <script src="https://static.filestackapi.com/filestack-js/3.x.x/filestack.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<section id="contact">

    <head>
    <h1><a style = "color:#FFFFFF; text-decoration: none;"href = "https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/landing.php">EcoRouteMCR</a></h1>
      <div class="dropdown">
        <input type = "image" class="dropbtn" src = "usericon.png">
        <div class="dropdown-content">
          <a <?php echo $style2;?> href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/profilepage.php">Profile Page</a>
          <a <?php echo $style2;?> href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/logout.php" onclick="window.open('http://studentnet.cs.manchester.ac.uk/systemlogout.php')">Log out</a>
          <a <?php echo $style1;?> href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/authentication.php">Log in</a>
          <a href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/contact.php">Contact Us</a>
        </div>
      </div>


    </head>>

    <div class="contact-wrapper">

    <!-- Left contact page -->

      <form id="contact-form" class="form-horizontal" role="form" action="https://api.web3forms.com/submit" method="POST">
        <input type="hidden" name="access_key" value="dbd9ddb4-4f8c-49c2-98d7-7aec6802b854">

        <div class="form-group">
          <div class="col-sm-12">
            <input type="text" class="form-control" id="name" placeholder="NAME" name="name" value="" required>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-12">
            <input type="email" class="form-control" id="email" placeholder="EMAIL" name="email" value="" required>
          </div>
        </div>

        <textarea class="form-control" rows="10" placeholder="MESSAGE" name="message" required></textarea>

        <button class="btn btn-primary send-button" id="submit" type="submit" value="SEND">
          <div class="alt-send-button">
            <span class="send-text">SEND</span>
            <i style="padding-top: 10px;" class="fa fa-paper-plane"></i>
          </div>

        </button>

      </form>

    <!-- Left contact page -->

        <div class="direct-contact-container">

          <ul class="contact-list">
            <li class="list-item"><i class="fa fa-map-marker fa-2x"><span class="contact-text place">Manchester, United Kingdom</span></i></li>

            <li class="list-item"><i class="fa fa-phone fa-2x"><span class="contact-text phone"><a href="tel:0-712-555-5555" title="Give me a call">(212) 555-2368</a></span></i></li>

            <li class="list-item"><i class="fa fa-envelope fa-2x"><span class="contact-text gmail"><a href="mailto:#" title="Send me an email">EcoRouteMCR@gmail.com</a></span></i></li>

          </ul>

          <hr>

          <div class="copyright">&copy; ALL OF THE RIGHTS RESERVED</div>

        </div>

    </div>

  </section>
</html>



