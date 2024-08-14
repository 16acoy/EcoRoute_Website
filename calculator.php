<?php
        session_start();
        if (isset($_GET['fullname'])) {
          $_SESSION['name'] = $_GET['fullname'];}

        if (isset($_SESSION['name'])) {
            $style = "style='display:block;'";
        }
        else {
            $style = "style='display:none;'";
        }

        $styleJourney = "style='display:block;'";
        if (isset($_GET['trees'])) {
          $styleJourney = "style='display:block;'";
          $styleJourneyOpposite = "style='display:none;'";
          $disabled = "disabled";
          $grey= "style=color: dimgrey;";

          if (isset($_GET['carCarbon'])) {
            $carSavingNum = $_GET['carbonSelected'] - $_GET['carCarbon'];
            $carSavingNum = round($carSavingNum, 2);
            if ($carSavingNum < 0) {
                $carSaving = "NO";
            } else {
                $carSaving = $carSavingNum;
            }
        } else {
            $carSaving = 0;
            $carSavingNum = 0;
        }


          if (isset($_GET['boatCarbon'])) {
            $boatSavingNum = $_GET['carbonSelected'] - $_GET['boatCarbon'];
            $boatSavingNum = round($boatSavingNum, 2);
            if ($boatSavingNum < 0) {
                $boatSaving = "NO";
            } else {
                $boatSaving = $boatSavingNum;
            }
        } else {
            $boatSaving = 0;
            $boatSavingNum = 0;
        }



          if (isset($_GET['planeCarbon'])) {
            $planeSavingNum = $_GET['carbonSelected'] - $_GET['planeCarbon'];
            $planeSavingNum = round($planeSavingNum, 2);
            if ($planeSavingNum < 0){
              $planeSaving = "NO";
            }
            else{
              $planeSaving = $planeSavingNum;
            }
          }
          else{
            $planeSaving = 0;
            $planeSavingNum = 0;
          }

          if (isset($_GET['trainCarbon'])) {
            $trainSavingNum = $_GET['carbonSelected'] - $_GET['trainCarbon'];
            $trainSavingNum = round($trainSavingNum, 2);
            if ($trainSavingNum < 0) {
                $trainSaving = "NO";
            } else {
                $trainSaving = $trainSavingNum;
            }
        } else {
            $trainSaving = 0;
            $trainSavingNum = 0;
        }




        }
        else{
          $styleJourney = "style='display:none;'";
          $styleJourneyOpposite = "style='display:block;'";
          $disabled = "";
          $grey = "";
        }




?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRouteMCR</title>
    <link rel="stylesheet" href="styles/calc.css">
    <script src="scripts/api.js"></script>
</head>

<body>
  <h1><a style = "color:#FFFFFF; text-decoration: none;"href = "https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/landing.php">EcoRouteMCR</a></h1>
  <div class="dropdown">
      <input type = "image" class="dropbtn" src = "usericon.png">
      <div class="dropdown-content">
      <a <?php echo $style;?> href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/profilepage.php">Profile Page</a>
      <a href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/logout.php" onclick="window.open('http://studentnet.cs.manchester.ac.uk/systemlogout.php')">Log out</a>
      <a href="https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/contact.php">Contact Us</a>
    </div>
  </div>

  <form id = "myForm" class="container" action="" method = "POST">
    <label for="car" id="radio-label">Choose your preferred mode of transport:</label>
    <br>

     <div class="radio-tile-group">
      <div class="input-container">
        <input id="car" type="radio" name="radio" value = "Car" <?php echo $disabled;?>>
        <div class="radio-tile">
          <ion-icon name="car-sport" ></ion-icon>
          <label for="car">Car</label>
        </div>
      </div>

        <div class="input-container">
          <input id="plane" type="radio" name="radio" value = "Plane" <?php echo $disabled;?>>
          <div class="radio-tile">
            <ion-icon name="airplane" <?php echo $grey;?>></ion-icon>
            <label for="plane">Plane</label>
          </div>
        </div>

        <div class="input-container">
          <input id="train" type="radio" name="radio" value = "Train" <?php echo $disabled;?>>
          <div class="radio-tile">
            <ion-icon name="train"></ion-icon>
            <label for="train">Train</label>
          </div>
        </div>

        <div class="input-container">
          <input id="boat" type="radio" name="radio" value = "Boat" <?php echo $disabled;?>>
          <div class="radio-tile">
            <ion-icon name="boat"></ion-icon>
            <label for="boat">Boat</label>
          </div>
        </div>

      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
      </div>

    <div class="non-icons">
      <div class="style-input">
        <input type="text" id="From" name="From" placeholder="From" value="<?php if ($disabled == 'disabled') {echo $_GET['from'];} ?>" <?php echo $disabled;?> />
      </div>

      <div class="style-input">
        <input type="text" id="To" name="To" placeholder="To" value="<?php if ($disabled == 'disabled') {echo $_GET['to'];} ?>" <?php echo $disabled;?> />
      </div>
      <span class="journey-type">
        <input type="radio" name="trip-type" id="round-trip" checked="checked" value="round-trip"/>
        <label for="round-trip">Round trip</label>


        <input type="radio" name="trip-type" id="one-way" value="one-way"/>
        <label for="one-way">One way</label>
      </span>

      <br>

        <br>
      <div class="submit-container"> <input <?php echo $styleJourneyOpposite;?> type="submit" value="Calculate", id="submit-button"></div>
    </div>
    <br>


  </form>
<footer>

  <form id = "saveForm" method = "POST" action = 'processJourney.php'>

      <div class="after-submission" <?php echo $styleJourney;?>>
        <!-- radio buttons to change journey selection-->
        <p> Your current selection has a carbon footprint of <?php $carbon = round($_GET['carbonSelected'], 2); echo $carbon;?>kg. </p>
        <p> This equates to <?php $tree = round($_GET['trees'], 2); echo $tree;?> trees. </p>
        <p> Could you do better? </p>

      <div class="radio-tile-group">
      <div class="input-container">
        <input id="car2" type="radio" name="radio2" value = "Car">
        <div class="radio-tile">
          <ion-icon name="car-sport"></ion-icon>
          <label for="car2">Car</label>
        </div>
        <br>Save <?php echo $carSaving;?>kg</br>
      </div> <!--  disable old buttons-->

        <div class="input-container">
          <input id="plane2" type="radio" name="radio2" value = "Plane">
          <div class="radio-tile">
            <ion-icon name="airplane"></ion-icon>
            <label for="plane2">Plane</label>
          </div>
          <br>Save <?php echo $planeSaving;?>kg</br>
        </div>

        <div class="input-container">
          <input id="train2" type="radio" name="radio2" value = "Train">
          <div class="radio-tile">
            <ion-icon name="train"></ion-icon>
            <label for="train2">Train</label>
          </div>
        <br>Save <?php echo $trainSaving;?>kg</br>
        </div>

        <div class="input-container">
          <input id="boat2" type="radio" name="radio2" value = "Boat">
          <div class="radio-tile">
            <ion-icon name="boat"></ion-icon>
            <label for="boat2">Boat</label>
          </div>
          <br>Save <?php echo $boatSaving;?>kg</br>
        </div>

      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
      </div>

      <br><br><br>

      <input type="submit" value="Save Trip", id="submit-button2">

      </div>

      <?php
        foreach ($_GET as $key => $val) {
        echo "<input type='hidden' name='{$key}' value='{$val}' />";

        echo "<input type='hidden' name='carSaving' value='{$carSavingNum}' />";
        echo "<input type='hidden' name='planeSaving' value='{$planeSavingNum}' />";
        echo "<input type='hidden' name='trainSaving' value='{$trainSavingNum}' />";
        echo "<input type='hidden' name='boatSaving' value='{$boatSavingNum}' />";
}
?>


  </form>
</footer>
</body>

</html>