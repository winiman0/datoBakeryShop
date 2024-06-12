<?php
$title = "Service";
include("dbconn.php");
include("custNav.php");
include("font.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="delivery.css"> <!-- Link the external CSS file -->
    <title>Service</title>
</head>
<body>
    <form id="serviceForm" action="delivery.php" method="post">
        <div class="content">
            <div class="box-container">
                <div class="box" id="deliveryBox" onclick="toggleService('delivery')">
                    <img src="deliveryMan.png" alt="DELIVERY" class="comment">
                    <p style="font-size: 35px">DELIVERY</p>
                    <p><centre>*RM 5.00 will apply into your bills.</centre></p>
                    <div class="form-group" id="delivery-address" style="display:none;">
                        <label for="address">Delivery Address:</label>
                        <textarea id="address" name="deliveryAddress" placeholder="Enter delivery address"></textarea>
                    </div>
                </div>
                <div class="box" id="pickupBox" onclick="toggleService('pickup')">
                    <img src="shopLocation.png" alt="PICKUP" class="comment">
                    <p style="font-size: 35px; font-style: ">PICKUP</p>
                    <p><centre>*Pickup Hour: 10am until 6pm only.</centre></p>
                    <div class="form-group" id="pickup-time" style="display:none;">
                        <label for="pickup-time">Pickup Time:</label>
                        <select id="pickup_time" name="pickupTime">
                            <option value="10:30am">10:30am</option>
                            <option value="11:00am">11:00am</option>
                            <option value="11:30am">11:30am</option>
                            <option value="12:00pm">12:00pm</option>
                            <option value="12:30pm">12:30pm</option>
                            <option value="1:00pm">1:00pm</option>
                            <option value="1:30pm">1:30pm</option>
                            <option value="2:00pm">2:00pm</option>
                            <option value="2:30pm">2:30pm</option>
                            <option value="3:00pm">3:00pm</option>
                            <option value="3:30pm">3:30pm</option>
                            <option value="4:00pm">4:00pm</option>
                            <option value="4:30pm">4:30pm</option>
                            <option value="5:00pm">5:00pm</option>
                            <option value="5:30pm">5:30pm</option>
                            <option value="6:00pm">6:00pm</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button class="back-button" type="button" onclick="window.history.back();">Back</button>
                <button type="submit" class="proceed-button">Submit</button>
            </div>
        </div>
        <input type="hidden" id="service" name="service">
        <input type="hidden" id="serviceDesc" name="serviceDesc">
    </form>
    <script>
        function toggleService(service) {
            document.getElementById('service').value = service;

            if (service === "delivery") {
                document.getElementById("delivery-address").style.display = "block";
                document.getElementById("pickup-time").style.display = "none";
                document.getElementById("deliveryBox").classList.add("selected");
                document.getElementById("pickupBox").classList.remove("selected");
            } else if (service === "pickup") {
                document.getElementById("delivery-address").style.display = "none";
                document.getElementById("pickup-time").style.display = "block";
                document.getElementById("pickupBox").classList.add("selected");
                document.getElementById("deliveryBox").classList.remove("selected");
            }
        }

        document.getElementById('serviceForm').onsubmit = function() {
            var service = document.getElementById('service').value;
            var serviceDesc = '';

             // Check if neither delivery nor pickup is selected
            if (service !== 'delivery' && service !== 'pickup') {
                alert('Please select a service.'); // Show error message
                return false; // Prevent form submission
            }

            if (service === 'delivery') {
                serviceDesc = document.getElementById('address').value;
            } else if (service === 'pickup') {
                serviceDesc = document.getElementById('pickup_time').options[document.getElementById('pickup_time').selectedIndex].text;
            }
            document.getElementById('serviceDesc').value = serviceDesc;
        }

    </script>
    <style>
        .box.selected {
            border: 4px solid #088743; /* Change as needed to highlight the selected box */            
        }
    </style>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service'];
    $serviceDesc = $_POST['serviceDesc'];

    // Calculate the service charge based on the selected service
    $serviceCharge = 0;
    if ($service === 'delivery') {
        $serviceCharge = 5.00; // RM 5.00 for delivery
    }

    // Store the service data in the session
    $_SESSION['serviceData'] = [
        'service' => $service,
        'serviceDesc' => $serviceDesc,
        'serviceCharge' => $serviceCharge
    ];

    
    // Output a JavaScript snippet for redirection
    echo '<script type="text/javascript">
    window.location.href = "payment.php";
    </script>';
    exit();
}
?>