<?php
    session_start();
    $style = "display:none;"; // Default style

    if (isset($_SESSION['name'])) {
        $style = "display:block;";
    }


    $database_host = "dbhost.cs.man.ac.uk";
    $database_user = "";
    $database_pass = "";
    $database_name = "2023_comp10120_y5";

    try {
        $conn = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $pe) {
        die("Could not connect to $database_host :" . $pe->getMessage());
    }

    function getJourneys($conn) {
        $sql = "SELECT transport, roundTrip, treeSaving, distances.destination, carbonFootprint FROM journeys JOIN distances ON journeys.destinationID = distances.destinationID WHERE user = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $_SESSION['name']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sql = "SELECT distances.destination FROM journeys JOIN distances ON journeys.sourceID = distances.destinationID WHERE user = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $_SESSION['name']]);
        $rows2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array($rows, $rows2);

    }


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRouteMCR</title>
    <link rel="stylesheet" href="styles/profilepage.css">
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
    <div class="table-title">
    <h3><?php echo $_SESSION['name'];?>'s Journeys</h3>
    </div>
    <table class="table-fill">
    <thead>
    <tr>
<th class="text-left">Your Trips</th>
<th class="text-left">Carbon Footprint(kg)</th>
<th class="text-left">Trees saved from this tool</th>
</tr>
    <?php

        list($journeys, $sources) = getJourneys($conn);
        $i = -1;
        $totalCarbon = 0;
        $totalTrees = 0;
        foreach ($journeys as $journey) {
            $i= $i+1;

            $transportType = $journey['transport'];
            $roundTrip = $journey['roundTrip'];
            if ($roundTrip == "Y"){
                $roundTrip = "Round Trip";
            }
            else{
                $roundTrip = "One Way";
            }
            $saving = $journey['treeSaving'];
            $treeSaving = round($saving, 2);
            $totalTrees = $totalTrees + $treeSaving;
            $destination = $journey['destination'];
            $carbonFootprint = round($journey['carbonFootprint'], 2);
            $totalCarbon = $totalCarbon + $carbonFootprint;
            $from = $sources[$i]['destination'];

            echo "<tr>";
            echo "<td class='text-left'>{$from} to {$destination} - {$roundTrip}</td>";
            echo "<td class='text-left'>{$carbonFootprint}</td>";
            echo "<td class='text-left'>{$treeSaving}</td>";
            echo "</tr>";


        }

        $totalCarbon = round($totalCarbon,2);
        $totalTrees = round($totalTrees,2);
        echo "<tr>";
        echo "<td class='text-left'>Total</td>";
        echo "<td class='text-left'>{$totalCarbon}</td>";
        echo "<td class='text-left'>{$totalTrees}</td>";
        echo "</tr>";

    ?>
    </tbody>
    </table>

    <footer id="footer">
    <p>Disclaimer: This figure only represents the carbon footprints of your journeys estimated by this tool. Your total carbon footprint takes into account other activties.</p>
    </footer>
</body>
</html>