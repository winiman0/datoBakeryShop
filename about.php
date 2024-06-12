<?php
    session_start();
    if (!isset($title)) {
        $title = "About";
    }
    include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="about.css">
</head>
<body>
    <!-- Main content section -->
    <!-- About text -->
    <div class="about-text">
        ABOUT US
    </div>
    <div class="main-container">
        <div class="left-body">
            <div class="logo-center"><img src="logo.png" alt="Company Logo"></div>
        </div>
        <div class="vertical-line"></div>
        <div class="right-body">
            <div class="box">
                <p>Dato's Bakery Shop is a highly prestigious company that is well-known throughout Malaysia. 
                   This company has four shareholders, and they are also the main leaders of this company. 
                   This company was first established in 2016 when one of the owners of this company began to 
                   dabble in the field of entrepreneurship. Now, Dato's Bakery Shop has already 30 branches throughout Malaysia.</p>
            </div>
            <p class="below-box-text"><b>MISSION: </b>To serve desserts that use premium ingredients that all sections of society can 
                                      afford and study new dessert preparations so that all walks of life can get our products according 
                                      to their tastes nowadays.
                                      <br><br><b>VISSION: </b>To expand the company's legacy to the world level where all countries will recognize 
                                      this company by giving good performance, producing quality products and becoming the first choice of 
                                      the world community.</p></br></br>
        </div>
    </div>
    
<div id="footer">For any inquiries and concerns, please email: dbsSales@gmail.com</br>&copy 2024 | Dato’s Bakery Ordering System</div> 
</body>
</html>
