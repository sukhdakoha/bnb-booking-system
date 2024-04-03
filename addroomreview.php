<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit/Add Room Review</title>
</head>
<body>
    <h1>Edit/add room review</h1>

<p><a href="currentbooking.php">[Return to the booking listing]</a>||<a href="dashboard.php">[Return to the main page]</a></p>
<form method="POST">
 <?php
require('config.php'); 
         $id=$_GET['id'];
          if(isset($_POST['updatereview']))
        {
              $review=$_POST['review'];
              $booking_id=$_POST['booking_id'];
              $sql = "UPDATE bookings SET review='$review' WHERE booking_id=$booking_id";
            if ($conn->query($sql) === TRUE) {
             echo "Record updated successfully";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            } 
        }
         $sql1 = "SELECT * FROM `bookings` Where booking_id=$id";
         $result1 = $conn->query($sql1);
         if($result1->num_rows > 0) 
          {
            while($row1 = $result1->fetch_assoc()) 
            {
              $customer_id=$row1["customer_id"];
              $sql2 = "SELECT * FROM customers where customerID=$customer_id";
              $result2 = $conn->query($sql2);
              if($result2->num_rows > 0) 
              {
                  $row2 = $result2->fetch_assoc();
                  $customer_name= $row2['firstname'].' '. $row2['lastname'];
              }

                if($row1["review"])
                {
                    $review=$row1["review"];
                }else{
                    $review='no review';
                }
         ?>
<p>Review made by <?=  $customer_name; ?></p>
<input type="hidden" value="<?= $row1["booking_id"];?>" name="booking_id">
<p>Room review: <textarea name="review"><?= $review; ?></textarea></p>
<?php
        
         }
        } 
        $conn->close();
?>
<input type="submit" value="Update" name="updatereview">
</form>
</body>
</html>