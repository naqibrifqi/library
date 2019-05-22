<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
$target_dir = "studentdp/";
$target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if(isset($_POST['change']))
{
    $check = getimagesize($_FILES["profilepic"]["tmp_name"]);
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
    if ($_FILES["profilepic"]["size"] > 500000) {
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
        if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["profilepic"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            $uploadOk = 0;
            $errMsg = "move error";
        }
    }    
if ($uploadOk != 0) {  
$sid=$_SESSION['stdid'];  
$profilepic = basename($_FILES["profilepic"]["name"]);

$sql="update tblstudents set profilepic=:profilepic where StudentId=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':sid',$sid,PDO::PARAM_STR);
$query->bindParam(':profilepic', $profilepic, PDO::PARAM_STR);
$query->execute();

echo '<script>alert("Your profile has been updated")</script>';
} else
echo "<script>alert('Something went wrong. Please try again [IMAGE_ERR]');</script>";
}



if(isset($_POST['update']))
{
    
$sid=$_SESSION['stdid'];  
$fname=$_POST['fullanme'];
$mobileno=$_POST['mobileno'];

$sql="update tblstudents set FullName=:fname,MobileNumber=:mobileno where StudentId=:sid";
$query = $dbh->prepare($sql);
$query->bindParam(':sid',$sid,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->execute();

echo '<script>alert("Your profile has been updated")</script>';
} 

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Student Signup</title>
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
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <p><a href="dashboard.php">Dashboard</a> > <a href="my-profile.php">My Profile</a></p>
                <h4 class="header-line">My Profile</h4>
                
                            </div>

        </div>
             <div class="row">
           
<div class="col-md-9 col-md-offset-1">
               <div class="panel panel-danger">
                        <div class="panel-heading">
                           My Profile
                        </div>
                        <div class="panel-body">

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Profile Picture</h4>
        </div>
        <form name="changedp" method="post" enctype="multipart/form-data">
        <div class="modal-body">
        <input type="file" name="profilepic" id="profilepic">
        </div>
        <div class="modal-footer">
        <button type="submit" name="change" class="btn btn-default">Submit</button>
          <button  type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
                            <form name="signup" method="post" enctype="multipart/form-data">
<?php 
$sid=$_SESSION['stdid'];
$sql="SELECT StudentId,FullName,EmailId,MobileNumber,RegDate,UpdationDate,Status,profilepic from  tblstudents  where StudentId=:sid ";
$query = $dbh -> prepare($sql);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  

<div class="form-group">

<img src="studentdp/<?php echo htmlentities($result->profilepic);?>" height="160" width="120">

<!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Change Picture</button>

</div>

<div class="form-group">
<label>Student ID : </label>
<?php echo htmlentities($result->StudentId);?>
</div>

<div class="form-group">
<label>Reg Date : </label>
<?php echo htmlentities($result->RegDate);?>
</div>
<?php if($result->UpdationDate!=""){?>
<div class="form-group">
<label>Last Updation Date : </label>
<?php echo htmlentities($result->UpdationDate);?>
</div>
<?php } ?>


<div class="form-group">
<label>Profile Status : </label>
<?php if($result->Status==1){?>
<span style="color: green">Active</span>
<?php } else { ?>
<span style="color: red">Blocked</span>
<?php }?>
</div>


<div class="form-group">
<label>Enter Full Name</label>
<input class="form-control" type="text" name="fullanme" value="<?php echo htmlentities($result->FullName);?>" autocomplete="off" required />
</div>


<div class="form-group">
<label>Mobile Number :</label>
<input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo htmlentities($result->MobileNumber);?>" autocomplete="off" required />
</div>
                                        
<div class="form-group">
<label>Enter Email</label>
<input class="form-control" type="email" name="email" id="emailid" value="<?php echo htmlentities($result->EmailId);?>"  autocomplete="off" required readonly />
</div>
<?php }} ?>
                              
<button type="submit" name="update" class="btn btn-primary" id="submit">Update Now </button>

                                    </form>
                            </div>
                        </div>
                            </div>
        </div>
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
