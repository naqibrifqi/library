<?php
session_start();
error_reporting(0);
include('includes/config.php');

    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "delete from tblbooks  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Category deleted successfully ";
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
        <title>Online Library Management System | Manage Books</title>
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
                        <p><a href="catelouge.php">Catelouge</a> </p>
                        <h4 class="header-line">Book Details</h4>
                    </div>
                


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Books Details
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                <?php 
       $id = $_GET['id'];
       $sql = "SELECT tblbooks.id,tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.bookdesc,tblbooks.quantity,tblbooks.BookPrice,tblbooks.shelf,tblbooks.bookcover,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId where tblbooks.id=$id";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {    
                                                   
                                                    
                                                    ?>
                                    <center><table class="table table-bordered table-hover">
                                                    <td width="350"> <img src="admin/uploads/<?php echo htmlentities($result->bookcover) ?>" height="440" width="400">
                                                    <br><center><p><?php echo htmlentities($result->quantity); ?> Books Available</p></center>
                                                    </td>
                                                    <td><h5> <b>Title: <?php echo htmlentities($result->BookName); ?></b></h5>
                                                    <p><b>ISBN:</b> <?php echo htmlentities($result->ISBNNumber); ?> </P>
                                                    <p><b>Category:</b> <?php echo htmlentities($result->CategoryName); ?> </P>
                                                    <p><b>Author:</b> <?php echo htmlentities($result->AuthorName); ?> </P>
                                                    <p><b>Synopsis:</b> <?php echo htmlentities($result->bookdesc); ?> </P>
                                                    <p><b>Shelf:</b> <?php echo htmlentities($result->shelf); ?> </P>
                                    </table></center>
                                    <?php $cnt = $cnt + 1;
                                                }
                                            } ?>   
                                           
			</div>
			</div>
		</div>
                                                  
                                                
                                       
                                </div>

                            </div>
                        </div>
                        <!--End Advanced Tables -->
                    </div>
                </div>



            </div>
        </div>

         <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>This is a large modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <!-- DATATABLE SCRIPTS  -->
        <script src="assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS  -->
        <script src="assets/js/custom.js"></script>
    </body>

    </html>
