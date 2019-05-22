<?php
require_once("includes/config.php");
if (!empty($_POST["bookid"])) {
  $bookid = $_POST["bookid"];

  $sql = "SELECT BookName,id,quantity FROM tblbooks WHERE (ISBNNumber=:bookid) || (BookName LIKE :bookid) AND quantity > 0";
  $query = $dbh->prepare($sql);
  $bookid = "%{$bookid}%";
  $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  $cnt = 1;
  if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>
      <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->BookName); ?></option>
      <b>Book Name :</b>
      <?php
      echo htmlentities($result->BookName);
      echo "<script>$('#submit').prop('disabled',false);</script>";
    }
  } else { ?>

    <option class="others"> Invalid ISBN Number OR Book out of stock</option>
    <?php
    echo "<script>$('#submit').prop('disabled',true);</script>";
  }
}



?>