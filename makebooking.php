<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Make a Booking</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script>
$(function() {
   $("#checkinDate").datepicker({ dateFormat: "dd-m-yy" ,minDate: new Date()});
    $("#checkoutDate").datepicker({ dateFormat: "dd-m-yy",minDate: new Date()});
      $("#searchAvailability").click(function() {
        var checkinDate = $("#checkinDate").val();
        var checkoutDate = $("#checkoutDate").val();
        $.ajax({
          type: "POST",
          url: "search_available_rooms.php",
          data: { checkinDate: checkinDate, checkoutDate: checkoutDate },
          success: function(response) {
            $("#availableRooms").html(response);
          },
          error: function() {
            alert("Error searching for available rooms.");
          }
        });
      });
    });
  </script>
  <?php 
require('config.php'); 
if(isset($_POST['add']))
{
  $room=$_POST['room'];
  $customer_id=$_POST['customer_id'];
  $checkinDate=$_POST['checkinDate'];
  $checkoutDate=$_POST['checkoutDate'];
  $contactNumber=$_POST['contactNumber'];
  $bookingExtras=$_POST['bookingExtras'];
  $review=$_POST['review'];
  $sql = "INSERT INTO bookings (customer_id, room_id,checkindate,checkoutdate,contactno,extra,review) VALUES ($customer_id, $room, '$checkinDate','$checkoutDate',$contactNumber,'$bookingExtras','$review')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
 
}
 ?>
</head>
<body>
  <div>
    <h2>Make a booking</h2>
    <a href="currentbooking.php">[Return to the Bookings listing]</a>
    <a href="dashboard.php">[Return to the main page]</a>
    <br>
    <p>Booking for <?php echo  $_SESSION['name']; ?></p>
    <br>
    <form method="POST" accept="makebooking.php">
      <label for="room">Room (name,type,beds):</label>
      <select id="room" name="room" required>
        <option value="">Select a room</option>
        <?php 
        $sql = "SELECT * FROM `rooms`";
         $result = $conn->query($sql);
        
          if($result->num_rows > 0) 
          {
            while($row = $result->fetch_assoc()) 
            {
              echo '<option value="'.$row["roomID"].'">'.$row["room_name"].' '.$row["roomtype"].' '.$row["beds"].'</option>';
          } 
        }
      ?>
 </select>
 <br><br>
 <label for="room">Customer:</label>
      <select id="customer" name="customer_id" required>
        <option value="">Select a customer</option>
        <?php 
        $sql = "SELECT * FROM `customers`";
         $result = $conn->query($sql);
        
          if($result->num_rows > 0) 
          {
            while($row = $result->fetch_assoc()) 
            {
              echo '<option value="'.$row["customerID"].'">'.$row["firstname"].' '.$row["lastname"].'</option>';
          } 
        }
      ?>
 </select>
 <br><br>
      <label for="dateRange">Check-in and Check-out Dates:</label>
      <input type="text" id="checkinDate" name="checkinDate" required>
      <input type="text" id="checkoutDate" name="checkoutDate" required>
      <br><br>

      <label for="contactNumber">Contact number:</label>
      <input type="tel" id="contactNumber" name="contactNumber"  placeholder="(###) ### ####" required>
      <br><br>
      <label for="bookingExtras">Booking extras:</label>
      <textarea id="bookingExtras" name="bookingExtras"></textarea>
       <br><br>
      <label for="bookingExtras">review:</label>
      <textarea id="bookingExtras" name="review"></textarea>
      <br><br>
      <input type="button" id="searchAvailability" value="Search Availability">
      <div id="availableRooms"></div>
      <br><br>
      <input type="submit" value="Add" name="add">
      <input type="button" value="Cancel">
    </form>
  </div>
</body>
</html>