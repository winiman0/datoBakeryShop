<?php 
    $title = "Service";
    include("custNav.php");
    include("dbconn.php");
    include("font.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="service.css">
    <title>Select Service</title>
</head>
<body>
    <div class="content">
        <h2>Select Service</h2>
        <form action="receipt2.php" method="post" onsubmit="saveServiceData();">
            <div class="form-group">
                <label for="service">Choose Service:</label>
                <select id="service" name="service" required>
                    <option value="delivery">Delivery</option>
                    <option value="pickup">Pickup</option>
                </select>
            </div>
            <div id="delivery-address" style="display:none;">
                <div class="form-group">
                    <label for="address">Delivery Address:</label>
                    <textarea id="address" name="address" placeholder="Enter delivery address"></textarea>
                </div>
            </div>
            <div id="pickup-time" style="display:none;">
                <div class="form-group">
                    <label for="pickup-time">Pickup Time:</label>
                    <select id="pickupTime" name="pickup_time">
                        <option value="10am">10:00 AM</option>
                        <option value="11am">11:00 AM</option>
                        <option value="12pm">12:00 PM</option>
                        <option value="1pm">1:00 PM</option>
                        <option value="2pm">2:00 PM</option>
                        <option value="3pm">3:00 PM</option>
                        <option value="4pm">4:00 PM</option>
                        <option value="5pm">5:00 PM</option>
                        <option value="6pm">6:00 PM</option>
                    </select>
                </div>
            </div>
            <div class="buttons">
                <button class="back-button" type="button" onclick="window.history.back();">Back</button>
                <button type="submit" class="proceed-button">Payment</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById("service").addEventListener("change", function() {
            var service = this.value;
            if (service === "delivery") {
                document.getElementById("delivery-address").style.display = "block";
                document.getElementById("pickup-time").style.display = "none";
            } else if (service === "pickup") {
                document.getElementById("pickup-time").style.display = "block";
                document.getElementById("delivery-address").style.display = "none";
            }
        });

        function saveServiceData() {
            var service = document.getElementById("service").value;
            var address = document.getElementById("address").value;
            var pickupTime = document.getElementById("pickupTime").value;

            // Store service data in session storage
            var serviceData = {
                service: service,
                serviceDesc: service === "delivery" ? address : pickupTime
            };

            sessionStorage.setItem('serviceData', JSON.stringify(serviceData));
        }
    </script>
</body>
</html>