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
                <div class="col-md-12">
                    <h2 class="header-line">ABOUT US</h2>
                </div>
            <div class="row">

            <div class="text-justify" style="text-align:center">
                <p>Established in 2019, this library was initially set up to serve students community around Kuala Lumpur. At the moment, we are serving more than 2,500 students.</p>
                <br>
                <center>
                <button class="button1" type="button" disabled><h4><b>MISSION</b></h4></button>
                <br>
                <br>
                <p>To provide inclusive, responsive and accessible library and information services which will supports the academic needs and demands of student’s communities.</p>
                <br>
                <button class="button1" type="button" disabled><h4><b>VISION</b></h4></button>
                <br>
                <br>
                <p><h5>This library will be an excellent hub for learning resources and facilities that will greatly improve the student information and knowledge experience</p></h5>
                </center>
            </div>
           
            <br>

            <h3><b>POLICIES</b></h3>
            
            <br>
            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'loanpolicy')" id="defaultOpen">LOAN POLICY</button>
                <button class="tablinks" onclick="openCity(event, 'rulesnregulations')">RULES AND REGULATIONS</button>
            </div>

            <!-- Tab content -->
            <div id="loanpolicy" class="tabcontent">
                <center><h3><b>Loan Eligibility</b></h3></center>
                <br>

                <div class = "table">

                    <table id="table" class="table" align="center">
                        <thead>
                            <tr>
                                <th width="350px">Number of Books</th>
                                <td>Maximum 3 books</td>
                                
                            </tr>
                        </thead>
                            <tr>
                                <th width="350px">Duration</th>
                                <td>Maximum 14 days (2 weeks)</td>
                            </tr>
                    </table>
                 </div>
                 <br>

                <div class="text-justify" style="justify-content: center">

                    <h4><b>Responsibility for Borrowers</b></h4>
                    <ul>
                        <p><li>Borrowers are responsible for recalls at all times, they should make arrangements for responding to the recall and the prompt return of the book(s) to the Library.</p></li>
                        <p><li>Borrowers are responsible for returning books on time and in good condition, without evidence of defacement, mutilation, or water damage.</p></li>
                        <p><li>Book(s) are overdue/ lost/ damage , fines and penalty will be imposed to the respective borrower.</p></li>
                    </ul>

                    <br>

                    <h4><b>Fines Imposed for the Late Return Book</b></h4>
                    <ul>
                        <p><li>RM0.50 per book per day late</p></li>
                    </ul>

                    <br>

                    <h4><b>Fines Imposed for the Lost Book</b></h4>
                    <ul>
                        <p><li>Cost of replacement (current price of books) fee plus late fee for each book</p></li>
                    </ul>

                    <br>

                    <h4><b>Damage Book</b></h4>
                    <ul>
                        <p><li>Librarian will determine the extent of an book’s damage. Damage can include, but is not limited to, water damage, stains, writing or highlighting, burns, missing pages, broken spine, or scratches</p></li>
                        <p><li>Borrowers will be charged a RM30.00 fee for each badly damaged book needing repairs.</p></li>
                    </ul>

                </div>
            </div>

            <div id="rulesnregulations" class="tabcontent">

            <div class="text-justify" style="justify-content: center">
            <ol>
                <p><li>All students are allowed to enter the library. <b>NOTES:</b> Only registered student are allowed for login into Online Library Management System</p></li>
                <p><li>Silence will be strictly observed in the library. Hand phones must be switched off before entering the library. Students can bring in their hand phones but not permitted to receive and make any calls</p></li>
                <p><li>Students who are not properly attire (with slippers, sleeveless shirts, round neck t-shirt, short pants/Bermudas, jeans) are not allowed into the Library</p></li>
                <p><li>Students are not allowed to make heavy noise, sleeping and doing something that may attract attentions and affecting the learning environment of the library</p></li>
                <p><li>Eating, drinking and smoking are not permitted within library premises.</p></li>
                <p><li>Anything of value should not be left unattended in the Library. The Library does not take responsibility for the loss or damaged of such items</p></li>
                <p><li>Bag excluding handbag; helmet and umbrella are not allowed to be brought into the library. Patrons may put those things at the baggage storage room outside the library.</p></li>
                <p><li>Librarian have the right to ask anyone causing disturbances to leave the library.</p></li>
                <p><li>Students may be required to show all books and items they carry for inspection at the exit gate before leaving the Library. ( Especially when the alarm triggered)</p></li>
                <p><li>Patrons found breaking library rules will have their library privileges suspended</p></li>
            </ol>
            *All students must follow all the rules issued for this library.
            </div>
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