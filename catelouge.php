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
                        <h4 class="header-line">Book Catelouge</h4>
                    </div>
                


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Books Catelouge
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    
                                            <?php $sql = "SELECT tblbooks.id,tblbooks.BookName,tblcategory.CategoryName,tblauthors.AuthorName,tblbooks.ISBNNumber,tblbooks.bookdesc,tblbooks.quantity,tblbooks.BookPrice,tblbooks.shelf,tblbooks.bookcover,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {    
                                                   
                                                    
                                                    ?>
                                                    <div class="col-sm-6 col-md-4 wow fadeInUp">
			<div class="products">				
	<div class="product">		
		<div class="product-image">
			<div class="image">
            <img src="admin/uploads/<?php echo htmlentities($result->bookcover) ?>" height="260" width="220">
			</div><!-- /.image -->			                      		   
		</div><!-- /.product-image -->
			
		
		<div class="product-info text-left">
        <b><?php echo htmlentities($result->BookName); ?></b>
			<div class="rating rateit-small"></div>
			<div class="description"></div>

			<div class="product-category">	
				<span class="price">
					Category: <?php echo htmlentities($result->CategoryName); ?>			</span>
		
									
			</div><!-- /.product-category -->

            <div class="product-category">	
				<span class="price">
					<?php echo htmlentities($result->quantity); ?> Books Available			</span>
		
									
			</div><!-- /.product-category -->
			
		</div><!-- /.product-info -->
					<div class="cart clearfix animate-effect">
				<div class="action">
					<ul class="list-unstyled">
						<li class="add-cart-button btn-group">
						
                        <a href='viewCatelouge.php?id=<?php echo htmlentities($result->id); ?>'  
							<button class="btn btn-primary" type="button">View Book</button></a>
													
						</li>
                        <li>
                        </li>
					</ul>
				</div><!-- /.action -->
                <div>
                
                </div>
			</div><!-- /.cart -->
			</div>
			</div>
		</div>
                                                  
                                                    <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                       
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
