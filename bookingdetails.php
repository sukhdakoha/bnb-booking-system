<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <style>
        .box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div>
        <h2>Logged in as <?php echo $_SESSION['name']; ?></h2>
        <h3>Booking Details View</h3>
        <h2>Edit a booking</h2>
        <a href="currentbooking.php">[Return to the Bookings listing]</a>
        <a href="makebooking.php">[Return to the main page]</a>
        <?php
         require('config.php'); 
         $id=$_GET['id'];
         $sql1 = "SELECT * FROM `bookings` Where booking_id=$id";
         $result1 = $conn->query($sql1);
         $i=1;
          if($result1->num_rows > 0) 
          {
            while($row1 = $result1->fetch_assoc()) {
              $room_id = $row1["room_id"];
                $sql3 = "SELECT * FROM rooms where roomID=$room_id";
              $result3 = $conn->query($sql3);
              if($result3->num_rows > 0) 
              {
                  $row3 = $result3->fetch_assoc();
                  $room_name= $row3['room_name'];
              }
         ?>
        <div class="box">
            <h4>Room detail #<?= $row1["booking_id"]; ?></h4>
            <p>Room name: <?= $room_name; ?></p>
            <p>Check-in date: <?= $row1["checkindate"]; ?></p>
            <p>Checkout date: <?= $row1["checkoutdate"]; ?></p>
            <p>Contact number: <?= $row1["contactno"]; ?></p>
            <p>Extras: <?= $row1["extra"]; ?></p>
            <p>Room review: <?= $row1["review"]; ?></p>
        </div>
        <?php
        $i++;
         }
        } else {
          echo "0 results";
        }
        $conn->close();
?>


    </div>
</body>
</html>
