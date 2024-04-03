<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit a Booking</title>
</head>
<body>
    <div>
        <h2>Edit a booking</h2>
        <a href="currentbooking.php">[Return to the Bookings listing]</a>
        <a href="makebooking.php">[Return to the main page]</a>
       <?php
         require('config.php'); 
          if(isset($_POST['update']))
        {
               $room=$_POST['room'];
              $booking_id=$_POST['booking_id'];
              $checkinDate=$_POST['checkinDate'];
              $checkoutDate=$_POST['checkoutDate'];
              $contactNumber=$_POST['contactNumber'];
               $bookingExtras=$_POST['bookingExtras'];
               $review=$_POST['roomReview'];
              $sql = "UPDATE bookings SET room_id=$room,checkindate='$checkinDate',checkoutdate='$checkoutDate',contactno=$contactNumber,extra='$bookingExtras',review='$review' WHERE booking_id=$booking_id";
           // print_r($checkinDate);die();
            if ($conn->query($sql) === TRUE) {
             echo "Record updated successfully";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }

            //$conn->close();
             
        }


         $id=$_GET['id'];
         $sql1 = "SELECT * FROM `bookings` Where booking_id=$id";
         $result1 = $conn->query($sql1);
         $i=1;
          if($result1->num_rows > 0) 
          {
            while($row1 = $result1->fetch_assoc()) {
         ?>
        <form method="POST" >
          <label for="room">Room (name,type,beds):</label>
          <select id="room" name="room" required>
           <?php 
            $sql = "SELECT * FROM `rooms`";
             $result = $conn->query($sql);
            
              if($result->num_rows > 0) 
              {
                while($row = $result->fetch_assoc()) 
                {
                    if($row["roomID"] == $row1["room_id"]){ $selected = "selected"; }else { $selected= ""; }
                    ?>
                  <option value="<?= $row["roomID"]; ?>" <?= $selected ?> ><?= $row["room_name"]?> <?= $row["roomtype"]?> <?= $row["beds"]?></option>
                  <?php
              } 
            }
          ?>
          </select>
          <br><br>
          <label for="checkinDate">Check-in date:</label>
          <input type="text" id="checkinDate" name="checkinDate" value="<?= $row1["checkindate"]; ?>" readonly required>
          <br><br>
          <label for="checkoutDate">Checkout date:</label>
          <input type="text" id="checkoutDate" name="checkoutDate" value="<?= $row1["checkoutdate"]; ?>" readonly required>
          <br><br>
          <label for="contactNumber">Contact number:</label>
          <input type="tel" id="contactNumber" name="contactNumber" value="<?= $row1["contactno"]; ?>"  required>
          <br><br>
          <label for="bookingExtras">Booking extras:</label>
          <textarea id="bookingExtras" name="bookingExtras" ><?= $row1["extra"]; ?></textarea>
          <br>
          <br>
          <label for="roomReview">Room review:</label>
          <textarea id="roomReview" name="roomReview" ><?= $row1["review"]; ?></textarea>
          <br>
          <input type="hidden" name="booking_id" value="<?= $id ?>">
          <input type="submit" value="Update" name="update">
          <input type="button" value="Cancel">
        </form>
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
