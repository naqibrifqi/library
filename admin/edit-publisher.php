<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['update'])) {
        $publisher = $_POST['publisher'];
        $address = $_POST['address'];
        $pubid = intval($_GET['pubid']);
        $sql = "update tblpublisher set PublisherName=:publisher, address=:address where id=:pubid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':publisher', $publisher, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':pubid', $pubid, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['updatemsg'] = "Publisher info updated successfully";
        header('location:manage-publisher.php');
    }
    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library Management System | Edit Categories</title>
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
            <div class="content-wrapper">
                <div class="container">
                    <div class="row pad-botm">
                        <div class="col-md-12">
                            <p><a href="dashboard.php">Dashboard</a> > <a href="manage-categories.php">Manage publisher</a> > <a href="javascript:window.location.href=window.location.href">Edit Categories</a></p>
                            <h4 class="header-line">Edit Publisher</h4>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <div class=" panel panel-info">
                                <div class="panel-heading">
                                    Publisher Info
                                </div>

                                <div class="panel-body">
                                    <form role="form" method="post">
                                        <?php
                                        $pubid = intval($_GET['pubid']);
                                        $sql = "SELECT * from tblpublisher where id=:pubid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':pubid', $pubid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                                ?>
                                                <div class="form-group">
                                                    <label>Publisher Name</label>
                                                    <input class="form-control" type="text" name="publisher" value="<?php echo htmlentities($result->PublisherName); ?>" required />
                                                </div>
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input class="form-control" type="text" name="address" value="<?php echo htmlentities($result->address); ?>" required />
                                                </div>
                                                <!--<div class="form-group">
                                                                <label>Status</label>
                                                                <?php if ($result->Status == 1) { ?>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="status" id="status" value="1" checked="checked">Active
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="status" id="status" value="0">Inactive
                                                                            </label>
                                                                        </div>
                                                                <?php } else { ?>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="status" id="status" value="0" checked="checked">Inactive
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label>
                                                                                <input type="radio" name="status" id="status" value="1">Active
                                                                            </label>
                                                                        </div <?php
                                                                        } ?> 
                                                                </div> <?php
                                                                }
                                                            } ?> 
                                                        -->
                                        <button type="submit" name="update" class="btn btn-info">Update </button>

                                    </form>
                                </div>
                            </div>
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
            <!-- CUSTOM SCRIPTS  -->
            <script src="assets/js/custom.js"></script>
    </body>

    </html>
<?php } ?>