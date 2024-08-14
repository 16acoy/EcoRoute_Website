function toRadians(degrees) {
    return degrees * (Math.PI / 180);
}

function getDistance(lat1, lon1, lat2, lon2) {
    var R = 6371; // Radius of the earth in km
    lat1 = toRadians(lat1);
    lon1 = toRadians(lon1);
    lat2 = toRadians(lat2);
    lon2 = toRadians(lon2);

    var dLat = lat2 - lat1;
    var dLon = lon2 - lon1;

    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1) * Math.cos(lat2) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var distance = R * c; // Distance in km
    return distance;
}


async function getCoordinates(city) {
    const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${city}&format=json`);

    if (!response.ok) {
        return null;
    } else {
        const data = await response.json();
        if (data.length > 0) {
            const { lat, lon } = data[0];
            return { lat, lon };
        } else {
            return null;
        }
    }
}

async function calculateDistance(city1, city2) {
    const coordinates1 = await getCoordinates(city1);
    const coordinates2 = await getCoordinates(city2);
    if ((coordinates1 == null) || (coordinates2 == null)){
        return null;
    }
    else{
        const distance = getDistance(coordinates1.lat, coordinates1.lon, coordinates2.lat, coordinates2.lon);
        return distance;
    }

    
}




document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        var fromCity = document.getElementById('From').value;
        var toCity = document.getElementById('To').value;
        var selectedMode = document.querySelector('input[name="radio"]:checked').value;
        var roundTrip = document.querySelector('input[name="trip-type"]:checked').value;
        console.log(selectedMode);

        calculateDistance(fromCity, toCity).then(distanceSelected => {
            if (distanceSelected != null){

            
            if (roundTrip == 'round-trip'){
                distanceSelected = distanceSelected * 2;
            }
            planeCarbon = distanceSelected * 0.225;
            planeTime = distanceSelected * 0.00069400;
            carCarbon = distanceSelected * 0.176;
            carTime = distanceSelected * 0.00940000;
            trainCarbon = distanceSelected * 0.042;
            trainTime = distanceSelected * 0.00333000;
            boatCarbon = distanceSelected * 0.023;
            boatTime = distanceSelected * 0.03400000;


            // You can now use distanceSelected in your calculations
            if (selectedMode == "Plane"){
                carbonSelected = planeCarbon;
                timeSelected = planeCarbon;
                var theurl = "calculator.php?carbonSelected=" + carbonSelected + "&timeSelected=" + timeSelected + "&trainCarbon=" + trainCarbon + "&trainTime=" + trainTime + "&carCarbon=" + carCarbon + "&carTime=" + carTime + "&boatCarbon=" + boatCarbon + "&boatTime=" + boatTime;
                
            }
            else if (selectedMode == "Car"){
                carbonSelected = carCarbon;
                timeSelected = carCarbon;
                var theurl = "calculator.php?carbonSelected=" + carbonSelected + "&timeSelected=" + timeSelected + "&trainCarbon=" + trainCarbon + "&trainTime=" + trainTime + "&planeCarbon=" + planeCarbon + "&planeTime=" + planeTime + "&boatCarbon=" + boatCarbon + "&boatTime=" + boatTime;

                
            }
            else if (selectedMode == "Train"){
                carbonSelected = trainCarbon;
                timeSelected = trainCarbon;
                var theurl = "calculator.php?carbonSelected=" + carbonSelected + "&timeSelected=" + timeSelected + "&planeCarbon=" + planeCarbon + "&planeTime=" + planeTime + "&carCarbon=" + carCarbon + "&carTime=" + carTime + "&boatCarbon=" + boatCarbon + "&boatTime=" + boatTime;

            }
            else if (selectedMode == "Boat"){
                carbonSelected = boatCarbon;
                timeSelected = boatCarbon;
                var theurl = "calculator.php?carbonSelected=" + carbonSelected + "&timeSelected=" + timeSelected + "&planeCarbon=" + planeCarbon + "&planeTime=" + planeTime + "&carCarbon=" + carCarbon + "&carTime=" + carTime + "&trainCarbon=" + trainCarbon + "&trainTime=" + trainTime;

            }

            var treesSelected = carbonSelected * 0.037;
            theurl += "&trees=" + treesSelected;
            theurl += "&from=" + fromCity;
            theurl += "&to=" + toCity;
            theurl += "&round=" + roundTrip;
            window.location.href = theurl;
            return false;}

        });
    });
});

//carbon footprint conversion values 
//Plane = 0.225kg per km travelled - 0.00069400hours per km 
//Car = 0.176kg per km travelled - 0.00940000hours per km
//Train = 0.042kg per km travelled - 0.00333000hours per km
//Boat = 0.023kg per km travelled - 0.03400000hours per km

//Trees = 0.037trees per kg of CO2
