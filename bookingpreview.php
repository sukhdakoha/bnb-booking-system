<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking preview before deletion</title>
    <style>
        .box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
        }
    </style>
</head>
<?php
require('config.php'); 
if(isset($_GET['action']))
{
   $id= $_GET['id'];
 $sql = "DELETE FROM `bookings` Where booking_id=$id";

if ($conn->query($sql) === TRUE) {
  $msg = "Record deleted successfully";
} else {
  $msg = "Error deleting record: " . $conn->error;
}
}
?>
<body>

    <div>
        <h2>Logged in as <?php echo $_SESSION['name']; ?></h2>
        <h2>Booking preview before deletion</h2>
        <h2>Edit a booking</h2>
        <a href="currentbooking.php">[Return to the Bookings listing]</a>
        <a href="makebooking.php">[Return to the main page]</a>
       <?php
         
         $id=$_GET['id'];
         $sql1 = "SELECT * FROM `bookings` Where booking_id=$id";
         $result1 = $conn->query($sql1);
         $i=1;
          if($result1->num_rows > 0) 
          {
            while($row1 = $result1->fetch_assoc()) {
              $customer_id =  $row1["customer_id"];
                $sql2 = "SELECT * FROM customers where customerID=$customer_id";
              $result2 = $conn->query($sql2);
              if($result2->num_rows > 0) 
              {
                  $row2 = $result2->fetch_assoc();
                  $customer_name= $row2['firstname'];
              }
         ?>
        <div class="box">
            <h3>Booking detail #<?= $row1["booking_id"]; ?></h3>
            <p>Room name: <?= $customer_name; ?></p>
            <p>Check-in date: <?= $row1["checkindate"]; ?></p>
            <p>Checkout date: <?= $row1["checkoutdate"]; ?></p>
        </div>
      
        <p>Are you sure you want to delete this Booking?</p>
        <form>
            <a type="submit" value="Delete" href="bookingpreview.php?id=<?= $id ?>&action=delete">Delete</a>
            <input type="submit" value="Cancel" formaction="currentbooking.php">
        </form>
         <?php
        $i++;
         }
} else {
  echo $msg;
}
$conn->close();
?>
    </div>
</body>
</html>

