<?php
use PHPMailer\PHPMailer\PHPMailer;

session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    /*if (isset($_POST['sendmail'])) {

        $sql = "SELECT tblStudents.EmailId from tblissuedbookdetails JOIN tblStudents ON tblissuedbookdetails.StudentId = tblStudents.StudentId WHERE tblissuedbookdetails.fine IS NOT NULL";
        $query = $dbh->prepare($sql);
        if ($query->execute()) {
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            if ($query->rowCount() > 0) {
                foreach ($results as $result) {

                    $rec = $result->EmailId;

                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->SMTPAuth();
                    $mail->SMTPSecure = 'ssl';
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = '465';
                    $mail->isHTML();
                    $mail->Username = 'naqibrifqi@gmail.com';
                    $mail->Password = 'Skyrifqi2019';
                    $mail->SetFrom('naqibrifqi@gmail.com');
                    $mail->Subject = 'Hello World';
                    $mail->Body = 'Test email';
                    $mail->addAddress('skyrifqius@gmail.com');

                    $mail->Send();
                }
            } else {
                $_SESSION['error'] = "error";
                header('location:bbooks.php');
            }
        } else {
            $_SESSION['msg'] = "Email try updated";
            header('location:b-books.php');
        }
        //$query->execute();
        /*$results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {

                $_SESSION['msg'] = "Email try updated";
                header('location:manage-issued-books.php');
            }
        }else{
            $_SESSION['error'] = "error";
            header('location:manage-issued-books.php');
        }
    }*/

    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library Management System | Manage Issued Books</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- DATATABLE STYLE  -->
        <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
                    <div class="col-md-12">
                        <p><a href="dashboard.php">Dashboard</a> > <a href="manage-issued-books.php">Manage Issued Books</a></p>
                        <h4 class="header-line">Manage Issued Books</h4>
                        <h3><?php
                            /*//$date1 = date("Y-m-d");
                            $date1 = new DateTime("2019-05-19");
                            $date2 = new DateTime("2019-05-20");
                            //echo $date1 . ", " . $date2;
                            $diff = date_diff($date1, $date2); 
                            echo $diff->format("%a");*/
                            ?></h3>

                        <?php

                        $currDate = date("Y-m-d");
                        $sql = "SELECT IssuesDate, expectedReturnDate, ReturnDate, id from tblissuedbookdetails";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) {
                                /* FOR DEBUG USE -NaqibRifqi
                            echo "<br />";
                            echo $currDate;
                            echo "| |";
                            echo $expectedDate;*/
                                $expectedDate = $result->expectedReturnDate;

                                $date1 = new DateTime($currDate);
                                $date2 = new DateTime($expectedDate);

                                $diff = date_diff($date1, $date2);
                                //echo $diff->format(" |Different %a days|");

                                if ($currDate > $expectedDate) {
                                    /* FOR DEBUG USE -NaqibRifqi
                                echo " |exceeded yes|";
                                echo " fine: " . $fine;
                                echo " |ID: " . $result->id;
                                echo "|update tblissuedbookdetails set fine=" . $fine . " where id= " . $result->id;*/
                                    $fine = $diff->format("%a") * 0.5;

                                    $sql2 = "update tblissuedbookdetails set fine=:fine where id=:bookid";
                                    $query2 = $dbh->prepare($sql2);
                                    $query2->bindParam(':fine', $fine, PDO::PARAM_STR);
                                    $query2->bindParam(':bookid', $result->id, PDO::PARAM_STR);
                                    $query2->execute();
                                }
                            }
                        }

                        /*$sqlFine = "SELECT IssuesDate, expectedReturnDate, ReturnDate, id from tblissuedbookdetails";
                    $queryFine = $dbh->prepare($sqlFine);
                    $queryFine->execute();
                    $results = $queryFine->fetchAll(PDO::FETCH_OBJ);
                    $cnt = 1;
                    if ($queryFine->rowCount() > 0) {
                        foreach ($results as $result) {
                            /*$expect = new DateTime($result->expectedReturnDate);
                            if($currDate > $expect){
                                // update if exceeded
                                /*$date1 = new DateTime($result->ExpectedReturnDate);
                                $date2 = new DateTime("Y-m-d");
                                $ddiff = date_diff($date1, $date2); // calculate days late
                                $diffDate = $ddiff->format("%a");
                                //$fine = $diffDate * 0.50; //calculate fine by multiplying number of days and 50 cent*/

                        //echo "<h1>Pass1: " + $result->ExpectedReturnDate + "</h1>";

                        /*$sqlUpdate = "update tblissuedbookdetails set fine=:fine where id=:bookid";
                                $queryUpdate = $dbh->prepare($sqlUpdate);
                                $queryUpdate->bindParam(':fine', $fine, PDO::PARAM_STR);
                                $queryUpdate->bindParam(':id', $result->id, PDO::PARAM_STR);
                                $queryUpdate->execute();
                                $count = $queryUpdate->rowCount();
                                if($count == '0'){
                                    $_SESSION['error'] = "Something went wrong. Please try again";
                                    header('location:manage-issued-books.php');
                                }else{
                                    $_SESSION['msg'] = "Fine updated";
                                    header('location:manage-issued-books.php');
                                }
                            }
                            echo $result->expectedReturnDate . ", ";
                            $cnt = $cnt + 1;
                        }
                    }*/
                        ?>
                    </div>
                    <div class="row">
                        <?php if ($_SESSION['error'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-danger">
                                    <strong>Error :</strong>
                                    <?php echo htmlentities($_SESSION['error']); ?>
                                    <?php echo htmlentities($_SESSION['error'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['msg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['msg']); ?>
                                    <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>



                        <?php if ($_SESSION['delmsg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['delmsg']); ?>
                                    <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Issued Books
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Book Name</th>
                                                <th>ISBN </th>
                                                <th>Issued Date</th>
                                                <th>Expected Return Date</th>
                                                <th>Fine</th>
                                                <th>Return Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sql = "SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.ISBNNumber,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ExpectedReturnDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.fine,tblissuedbookdetails.id as rid from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId order by tblissuedbookdetails.id desc";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->FullName); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->BookName); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->ISBNNumber); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->IssuesDate); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->ExpectedReturnDate); ?></td>
                                                        <td class="center"><?php
                                                                            if ($result->fine != "" || $result->fine != null) {
                                                                                echo '<span style="color:red">RM ' . htmlentities($result->fine) . '</span>';
                                                                            } else {
                                                                                echo '<span style="color:green">None</span>';
                                                                            }

                                                                            ?></td>
                                                        <td class="center"><?php if ($result->ReturnDate == "") {
                                                                                echo htmlentities("Not Return Yet");
                                                                            } else {


                                                                                echo htmlentities($result->ReturnDate);
                                                                            }
                                                                            ?></td>
                                                        <td class="center">

                                                            <a href="update-issue-bookdeails.php?rid=<?php echo htmlentities($result->rid); ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>

                                                        </td>
                                                    </tr>
                                                    <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
        <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
        <!-- CORE JQUERY  -->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS  -->
        <script src="assets/js/bootstrap.js"></script>
        <!-- DATATABLE SCRIPTS  -->
        <script src="assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS  -->
        <script src="assets/js/custom.js"></script>
    </body>

    </html>
<?php } ?>