<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Online Library Management System | </title>
  <!-- BOOTSTRAP CORE STYLE  -->
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONT AWESOME STYLE  -->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLE  -->
  <link href="assets/css/style.css" rel="stylesheet" />
  <!-- GOOGLE FONT -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>

<body>
  <!------MENU SECTION START-->
  <?php include('includes/header.php'); ?>
  <!-- MENU SECTION END-->
  <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
            
                    <h2 class="header-line">GUIDE</h2>
                
            </div>
            <div class="row">

            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'register')" id="defaultOpen">How To Register Account</button>
                <button class="tablinks" onclick="openCity(event, 'borrow')">How To Borrow Book</button>
                <button class="tablinks" onclick="openCity(event, 'issue')">How To View Issued Book Details</button>
            </div>

            <!-- Tab content -->
            <div id="register" class="tabcontent">
                <h3>How To Register Account</h3>
                <br>
                <h4><b>Steps:</b></h4>
                <p>1.  Click <b>Register</b> tab at menu bar</p> 
                <p>2.  Fill in all required field</p>
                <p>3.  Upload a proper image of yourself as profile picture</p>
                <p>4.  Fill in verification code based on the 5 digit code</p>
                <p>5.  Click <b>Register</b> button</p>
                <p>6.  Once account registration complete, each student will received a student ID. This student ID is mandatory for issue book process at Library Counter</p>
                
                
            </div>

            <div id="borrow" class="tabcontent">
                <h3>How To Borrow Book</h3>
                <br>
                <h4><b>Steps:</b></h4>
                <p>1.  Choose maximum of 3 books to borrow</p>
                <p>2.  Bring the books at the Library Counter</p>
                <p>3.  Voice out your student ID at the librarian for issue book process. <b>NOTE:</b>  If your student ID has been inactive by librarian due to late/missing/damage of returning books, you cannot proceed to borrow the new books.</p>
            </div>

            <div id="issue" class="tabcontent">
                <h3>How To View Issued Book Details</h3>
                <h5><b>NOTES:</b> Only for Registered Student</h5>
                <br>
                <h4><b>Steps:</b></h4>
                <p>1.  Login into account with registered email and password</p>
                <p>2.  Click <b>Issued Books</b> tab</p>
                <p>3.  Table of issue book details by Book Name, ISBN, Issue Date,Expected Return Date, Return Date and Fine</p>

            </div>    

            <script>
                function openCity(evt, cityName) {
                // Declare all variables
                var i, tabcontent, tablinks;

                // Get all elements with class="tabcontent" and hide them
                 tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                 tabcontent[i].style.display = "none";
                 }

                // Get all elements with class="tablinks" and remove the class "active"
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                // Show the current tab, and add an "active" class to the button that opened the tab
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
                }

                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
            </script>
            </div>
        </div>
    </div>
  <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php'); ?>
  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS  -->
  <script src="assets/js/bootstrap.js"></script>
  <!-- CUSTOM SCRIPTS  -->
  <script src="assets/js/custom.js"></script>

</body>

</html>