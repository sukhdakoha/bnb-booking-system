<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Bookings</title>
</head>
<body>
    <div>
       <h2>Logged in as <?php echo $_SESSION['name']; ?></h2>
        <h2>Current bookings</h2>
        <h2>Edit a booking</h2>
        <a href="currentbooking.php">[Return to the Bookings listing]</a>
        <a href="dashboard.php">[Return to the main page]</a>
        <table>
          <thead>
            <tr>
              <th>Booking (room, dates)</th>
              <th>Customer</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
        <?php
         require('config.php'); 
         $sql1 = "SELECT * FROM `bookings`";
         $result1 = $conn->query($sql1);
          if($result1->num_rows > 0) 
          {
            while($row1 = $result1->fetch_assoc()) 
            {
             $customer_id = $row1['customer_id'];
             $room_id=$row1['room_id'];
              $sql2 = "SELECT * FROM customers where customerID=$customer_id";
              $result2 = $conn->query($sql2);
              if($result2->num_rows > 0) 
              {
                  $row2 = $result2->fetch_assoc();
                  $customer_name= $row2['firstname'];
              }
             $sql3 = "SELECT * FROM rooms where roomID=$room_id";
              $result3 = $conn->query($sql3);
              if($result3->num_rows > 0) 
              {
                  $row3 = $result3->fetch_assoc();
                  $room_name= $row3['room_name'];
              }
              ?>
            <tr>
              <td><?= $room_name; ?>, <?= $row1["checkindate"]; ?>, <?= $row1["checkoutdate"]; ?></td>
              <td><?= $customer_name; ?></td>
              <td>
                <a href="bookingdetails.php?id=<?= $row1["booking_id"]; ?>">[view]</a>
                <a href="editbooking.php?id=<?= $row1["booking_id"]; ?>">[edit]</a>
                <a href="addroomreview.php?id=<?= $row1["booking_id"]; ?>">[manage reviews]</a>
                <a href="bookingpreview.php?id=<?= $row1["booking_id"]; ?>">[delete]</a>
              </td>
            </tr>
            <?php
           }
          } else {
            echo "0 results";
          }
          $conn->close();
          ?>
            <!--  -->
          </tbody>
        </table>
      </div>
</body>
</html>
