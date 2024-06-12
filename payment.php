<?php
$title = "Payment";
include("custNav.php");
include("dbconn.php");
include("font.php");

$serviceData = isset($_SESSION['serviceData']) ? $_SESSION['serviceData'] : [];
$serviceCharge = $serviceData['serviceCharge'] ?? 0.00;
$grandTotal = isset($_SESSION['grandTotal']) ? $_SESSION['grandTotal'] : 0.00;
$amount= $grandTotal + $serviceCharge;

// Store updated values in session
$_SESSION['amount'] = $amount;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="payment.css">
    <title>Payment</title>
    <style>
        .content {
            width: 60%;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .buttons {
            text-align: center;
        }
        .buttons button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 4px;
            background: #5cb85c;
            color: #fff;
            cursor: pointer;
        }
        .buttons button.back-button {
            background: #d9534f;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Payment</h2>
        <form id="paymentForm" action="processPayment.php" method="post">
            <div class="form-group">
                <label for="paymentType">Choose Payment Type:</label>
                <select id="paymentType" name="paymentType" required>
                    <option value="select">-Select-</option>
                    <option value="transfer">Transfer</option>
                    <option value="cash">Cash</option>
                </select>
            </div>
            <div id="transfer-details" style="display:none;">
                <div class="form-group">
                    <label for="accountNumber">Account Number:</label>
                    <input type="text" id="accountNumber" name="accountNumber" placeholder="Enter your account number">
                </div>
                <div class="form-group">
                    <h3><?php echo 'Amount : RM ' . htmlspecialchars($amount); ?></h3>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                </div>
            </div>
            <div class="buttons">
                <button class="back-button" type="button" onclick="window.history.back();">Back</button>
                <button type="submit" class="proceed-button">Submit</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById("paymentType").addEventListener("change", function() {
            var paymentType = this.value;
            var transferDetails = document.getElementById("transfer-details");
            if (paymentType === "transfer") {
                transferDetails.style.display = "block";
            } else {
                transferDetails.style.display = "none";
            }
        });

        document.getElementById("paymentForm").addEventListener("submit", function(event) {
            var paymentType = document.getElementById("paymentType").value;
            if (paymentType === "select") {
                alert("Please choose a payment type.");
                event.preventDefault(); // Prevent default form submission
            }
        });
    </script>
</body>
</html>
