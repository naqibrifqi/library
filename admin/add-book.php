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
    /*
    // Check if image file is a actual image or fake image
    if(isset($_POST["add"])) {
        $check = getimagesize($_FILES["bookcover"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }*/

    if (isset($_POST['add'])) {

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
            //move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $newfilename);

            if (move_uploaded_file($_FILES["bookcover"]["tmp_name"], $target_dir . $newfilename)) {
                echo "The file " . $newfilename . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
                $errMsg = "move error";
            }
        }

        if ($uploadOk != 0) {

            $bookname = $_POST['bookname'];
            $category = $_POST['category'];
            $publisher = $_POST['publisher'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $bookdesc = $_POST['bookdesc'];
            $quantity = $_POST['quantity'];
            $shelf = $_POST['shelf'];
            $price = $_POST['price'];
            $bookcover = basename($newfilename);
            $sql = "INSERT INTO  tblbooks(BookName,CatId,PubId,AuthorId,ISBNNumber, bookdesc, quantity, BookPrice, shelf, bookcover) VALUES(:bookname,:category,:publisher,:author,:isbn,:bookdesc,:quantity,:price,:shelf,:bookcover)";
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
            $query->bindParam(':bookcover', $bookcover, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $_SESSION['msg'] = "Book Listed successfully";
                header('location:manage-books.php');
            } else {
                $_SESSION['error'] = "Something went wrong. Please try again";
                header('location:manage-books.php');
            }
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
            header('location:manage-books.php');
        }
    }
    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library Management System | Add Book</title>
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
                            <p><a href="dashboard.php">Dashboard</a> > <a href="manage-books.php">Manage Books</a> > <a href="add-book.php">Add Book</a></p>
                            <h4 class="header-line">Add Book</h4>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
    <div class=" panel panel-info">
                            <div class="panel-heading">
                                Book Info
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Book Name<span style="color:red;">*</span></label>
                                        <input class="form-control" type="text" name="bookname" autocomplete="off" required value="<?php if(isset($_POST['bookname'])) echo $_POST['bookname']; ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label> Category<span style="color:red;">*</span></label>
                                        <select class="form-control" name="category" required="required" value="<?php if(isset($_POST['category'])) echo $_POST['category']; ?>">
                                            <option value=""> Select Category</option>
                                            <?php
                                            $status = 1;
                                            $sql = "SELECT * from  tblcategory where Status=:status";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':status', $status, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->CategoryName); ?></option>
                                                <?php }
                                        } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label> Publisher<span style="color:red;">*</span></label>
                                        <select class="form-control" name="publisher" required="required" value="<?php if(isset($_POST['publisher'])) echo $_POST['publisher']; ?>">
                                            <option value=""> Select Publisher</option>
                                            <?php
                                            $status = 1;
                                            $sql = "SELECT * from  tblpublisher";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->PublisherName); ?></option>
                                                <?php }
                                        } ?>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label> Author<span style="color:red;">*</span></label>
                                        <select class="form-control" name="author" required="required" value="<?php if(isset($_POST['author'])) echo $_POST['author']; ?>">
                                            <option value=""> Select Author</option>
                                            <?php

                                            $sql = "SELECT * from  tblauthors ";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->AuthorName); ?></option>
                                                <?php }
                                        } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Book Synopsis<span style="color:red;">*</span></label>
                                        <input class="form-control" type="text" name="bookdesc" required="required" autocomplete="off" value="<?php if(isset($_POST['bookdesc'])) echo $_POST['bookdesc']; ?>"/>
                                        <p class="help-block">Brief synopsis about the book</p>
                                    </div>

                                    <div class="form-group">
                                        <label>ISBN Number<span style="color:red;">*</span></label>
                                        <input class="form-control" type="text" name="isbn" required="required" autocomplete="off" value="<?php if(isset($_POST['isbn'])) echo $_POST['isbn']; ?>"/>
                                        <p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Quantity<span style="color:red;">*</span></label>
                                        <input class="form-control" type="text" name="quantity" required="required" autocomplete="off" value="<?php if(isset($_POST['quantity'])) echo $_POST['quantity']; ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label>Price<span style="color:red;">*</span></label>
                                        <input class="form-control" type="text" name="price" autocomplete="off" required="required" value="<?php if(isset($_POST['price'])) echo $_POST['price']; ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label>Shelf<span style="color:red;">*</span></label>
                                        <input class="form-control" type="text" name="shelf" autocomplete="off" required="required" value="<?php if(isset($_POST['shelf'])) echo $_POST['shelf']; ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label>Book Cover<span style="color:red;">*</span></label>
                                        <input type="file" name="bookcover" id="bookcover">
                                    </div>

                                    <button type="submit" name="add" class="btn btn-info">Add </button>

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