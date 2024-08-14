<?php
    session_start();
    $database_host = "dbhost.cs.man.ac.uk";
    $database_user = "";
    $database_pass = "";
    $database_name = "2023_comp10120_y5";

    try{
        $conn = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        echo ("Connected to $database_host successfully.");
    }
    catch(PDOException $pe){
        die("Could not connect to $database_host :" . $pe->getMessage());
    }


    //call this function once 'save journey' button is pressed
    function saveJourney($conn){

        $transportChosen = $_POST['radio2'];
        $sourceChosen = $_POST['from'];
        $destinationChosen = $_POST['to'];
        if ($_POST['round'] == 'one-way'){
            $roundTripChosen = 'N';
        }
        else if ($_POST['round'] == 'round-trip'){
            $roundTripChosen = 'Y';
        }


        if ($_POST['radio2'] == 'Train'){
            $savingForTrip = $_POST['trainSaving'] * 0.037;
            if(isset($_POST['trainCarbon'])) {
                $carbonFootprintForTrip = $_POST['trainCarbon'];}
            else{
                $carbonFootprintForTrip = $_POST['carbonSelected'];}
        }
        if ($_POST['radio2'] == 'Plane'){
            $savingForTrip = $_POST['planeSaving'] * 0.037;
            if(isset($_POST['planeCarbon'])) {
                $carbonFootprintForTrip = $_POST['planeCarbon'];}
            else {
                $carbonFootprintForTrip = $_POST['carbonSelected'];}}
        if ($_POST['radio2'] == 'Car'){
            $savingForTrip = $_POST['carSaving'] * 0.037;
            if(isset($_POST['carCarbon'])) {
                $carbonFootprintForTrip = $_POST['carCarbon'];}
            else{
                $carbonFootprintForTrip = $_POST['carbonSelected'];}}
        if ($_POST['radio2'] == 'Boat'){
            $savingForTrip = $_POST['boatSaving'] * 0.037;
            if(isset($_POST['boatCarbon'])) {
                $carbonFootprintForTrip = $_POST['boatCarbon'];}
            else{
                $carbonFootprintForTrip = $_POST['carbonSelected'];}}

                $sql = "SELECT destinationID FROM distances WHERE destination = :destinationChosen";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['destinationChosen' => $destinationChosen]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $destinationID = $row['destinationID'];
                if ($destinationID == null){
                //add new destination to distances table and get ID

                $sql = "INSERT INTO distances (destination) VALUES (:destinationChosen)";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['destinationChosen' => $destinationChosen]);

                $sql = "SELECT destinationID FROM distances WHERE destination = :destinationChosen";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['destinationChosen' => $destinationChosen]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $destinationID = $row['destinationID'];

                }


                $sql = "SELECT destinationID FROM distances WHERE destination = :sourceChosen";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['sourceChosen' => $sourceChosen]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $sourceID = $row['destinationID'];
                if ($sourceID == null){
                //add new source to distances table and get ID

                $sql = "INSERT INTO distances (destination) VALUES (:destinationChosen)";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['destinationChosen' => $sourceChosen]);

                $sql = "SELECT destinationID FROM distances WHERE destination = :destinationChosen";
                $stmt = $conn->prepare($sql);
                $stmt->execute(['destinationChosen' => $sourceChosen]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $sourceID = $row['destinationID'];

                }



                $sql = "INSERT INTO journeys (user, destinationID, roundTrip, transport, treeSaving, carbonFootprint, sourceID)
                VALUES (:user, :destinationID, :roundTrip, :transport, :saving, :carbonFootprint, :sourceID)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'user' => $_SESSION['name'],
                    'destinationID' => $destinationID,
                    'roundTrip' => $roundTripChosen,
                    'transport' => $transportChosen,
                    'saving' => $savingForTrip,
                    'carbonFootprint' => $carbonFootprintForTrip,
                    'sourceID' => $sourceID,]);
          }


          /////////// main code




            try {
                saveJourney($conn);
                //If the exception is thrown, this text will not be shown
                echo 'If you see this, it worked';
              }

              //catch exception
              catch(PDOException $e) {
                echo 'Message: ' .$e->getMessage();
              }

              header('Location: '."https://web.cs.manchester.ac.uk/f23103ac/comp10120_project/profilepage.php");



?>