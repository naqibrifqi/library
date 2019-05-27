<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["bookcover"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST['change'])) {
        $check = getimagesize($_FILES["bookcover"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
            $errMsg = "not image";
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
            $errMsg = "alr exists";
        }
        // Check file size
        if ($_FILES["bookcover"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
            $errMsg = "too big";
        }
        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "PNG"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            $errMsg = "format";
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {

            $temp = explode(".", $_FILES["bookcover"]["name"]);
            $newfilename = round(microtime(true)) . "." . end($temp);

            if (move_uploaded_file($_FILES["bookcover"]["tmp_name"], $target_dir . $newfilename)) {
                echo "The file " . basename($_FILES["bookcover"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
                $errMsg = "move error";
            }
        }
        if ($uploadOk != 0) {
            $bookid = intval($_GET['bookid']);
            $bookcover = basename($newfilename);

            $sql = "update tblbooks set bookcover=:bookcover where id=:bookid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query->bindParam(':bookcover', $bookcover, PDO::PARAM_STR);
            $query->execute();

            echo '<script>alert("Book info has been updated")</script>';
        } else
            echo "<script>alert('Something went wrong. Please try again [IMAGE_ERR]');</script>";
    }

    if (isset($_POST['update'])) {
        $bookname = $_POST['bookname'];
        $category = $_POST['category'];
        $publisher = $_POST['publisher'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $bookdesc = $_POST['bookdesc'];
        $shelf = $_POST['shelf'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $shelf = $_POST['shelf'];
        $bookid = intval($_GET['bookid']);
        $sql = "update tblbooks set BookName=:bookname,CatId=:category,pubId=:publisher,AuthorId=:author,ISBNNumber=:isbn,bookdesc=:bookdesc,quantity=:quantity,BookPrice=:price,shelf=:shelf where id=:bookid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':publisher', $publisher, PDO::PARAM_STR);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $query->bindParam(':bookdesc', $bookdesc, PDO::PARAM_STR);
        $query->bindParam(':quantity', $quantity, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':shelf', $shelf, PDO::PARAM_STR);
        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['msg'] = "Book info updated successfully";
        header('location:manage-books.php');
    }
    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library Management System | Edit Book</title>
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
                            <p><a href="dashboard.php">Dashboard</a> > <a href="manage-books.php">Manage Books</a> > <a href="javascript:window.location.href=window.location.href">Edit Book</a></p>
                            <h4 class="header-line">Edit Book</h4>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Book Info
                                </div>
                                <div class="panel-body">
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Change Book Cover</h4>
                                                </div>
                                                <form name="changecover" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="file" name="bookcover" id="bookcover">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="change" class="btn btn-default">Submit</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form role="form" method="post">
                                        <?php
                                        $bookid = intval($_GET['bookid']);
                                        $sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblpublisher.PublisherName,tblpublisher.id as pubId,tblcategory.id as cid,tblauthors.AuthorName,tblauthors.id as athrid,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.bookcover,tblbooks.bookdesc,tblbooks.shelf,tblbooks.quantity,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId JOIN tblPublisher ON tblPublisher.id = tblBooks.pubId where tblbooks.id=:bookid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {               ?>

                                                <div class="form-group">
                                                    <img src="uploads/<?php echo htmlentities($result->bookcover) ?>" height="160" width="120">
                                                    <!-- Trigger the modal with a button -->
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Change Book Cover</button>

                                                </div>

                                                <div class="form-group">
                                                    <label>Book Name<span style="color:red;">*</span></label>
                                                    <input class="form-control" type="text" name="bookname" value="<?php echo htmlentities($result->BookName); ?>" required />
                                                </div>

                                                <div class="form-group">
                                                    <label> Category<span style="color:red;">*</span></label>
                                                    <select class="form-control" name="category" required="required">
                                                        <option value="<?php echo htmlentities($result->cid); ?>"> <?php echo htmlentities($catname = $result->CategoryName); ?></option>
                                                        <?php
                                                        $status = 1;
                                                        $sql1 = "SELECT * from  tblcategory where Status=:status";
                                                        $query1 = $dbh->prepare($sql1);
                                                        $query1->bindParam(':status', $status, PDO::PARAM_STR);
                                                        $query1->execute();
                                                        $resultss = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query1->rowCount() > 0) {
                                                            foreach ($resultss as $row) {
                                                                if ($catname == $row->CategoryName) {
                                                                    continue;
                                                                } else {
                                                                    ?>
                                                                    <option value="<?php echo htmlentities($row->id); ?>"><?php echo htmlentities($row->CategoryName); ?></option>
                                                                <?php }
                                                        }
                                                    } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label> Publisher<span style="color:red;">*</span></label>
                                                    <select class="form-control" name="publisher" required="required">
                                                        <option value="<?php echo htmlentities($result->pubId); ?>"> <?php echo htmlentities($publishername = $result->PublisherName); ?></option>
                                                        <?php
                                                        $sql1 = "SELECT * from  tblPublisher";
                                                        $query1 = $dbh->prepare($sql1);
                                                        $query1->execute();
                                                        $resultss = $query1->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query1->rowCount() > 0) {
                                                            foreach ($resultss as $row) {
                                                                if ($publishername == $row->PublisherName) {
                                                                    continue;
                                                                } else {
                                                                    ?>
                                                                    <option value="<?php echo htmlentities($row->id); ?>"><?php echo htmlentities($row->PublisherName); ?></option>
                                                                <?php }
                                                        }
                                                    } ?>
                                                    </select>
                                                </div>
                                                


                                                <div class="form-group">
                                                    <label> Author<span style="color:red;">*</span></label>
                                                    <select class="form-control" name="author" required="required">
                                                        <option value="<?php echo htmlentities($result->athrid); ?>"> <?php echo htmlentities($athrname = $result->AuthorName); ?></option>
                                                        <?php

                                                        $sql2 = "SELECT * from  tblauthors ";
                                                        $query2 = $dbh->prepare($sql2);
                                                        $query2->execute();
                                                        $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query2->rowCount() > 0) {
                                                            foreach ($result2 as $ret) {
                                                                if ($athrname == $ret->AuthorName) {
                                                                    continue;
                                                                } else {

                                                                    ?>
                                                                    <option value="<?php echo htmlentities($ret->id); ?>"><?php echo htmlentities($ret->AuthorName); ?></option>
                                                                <?php }
                                                        }
                                                    } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>ISBN Number<span style="color:red;">*</span></label>
                                                    <input class="form-control" type="text" name="isbn" value="<?php echo htmlentities($result->ISBNNumber); ?>" required="required" />
                                                    <p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
                                                </div>

                                                <div class="form-group">
                                                    <label>Book Synopsis<span style="color:red;">*</span></label>
                                                    <input class="form-control" type="text" name="bookdesc" value="<?php echo htmlentities($result->bookdesc); ?>" required="required" />
                                                    <p class="help-block">A brief synopsis about the book</p>
                                                </div>

                                                <div class="form-group">
                                                    <label>Quantity<span style="color:red;">*</span></label>
                                                    <input class="form-control" type="text" name="quantity" value="<?php echo htmlentities($result->quantity); ?>" required="required" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Price in RM<span style="color:red;">*</span></label>
                                                    <input class="form-control" type="text" name="price" value="<?php echo htmlentities($result->BookPrice); ?>" required="required" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Shelf<span style="color:red;">*</span></label>
                                                    <input class="form-control" type="text" name="shelf" value="<?php echo htmlentities($result->shelf); ?>" required="required" />
                                                </div>
                                            <?php }
                                    } ?>
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