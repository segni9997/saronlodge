<?php
// Database connection
$connection = new mysqli("localhost", "root", "", "hotelthree");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if booking_id is provided via POST
if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Start a transaction
    mysqli_begin_transaction($connection);

    try {
        // Update the CheckPayment to 1 in the booking table
        $updateBookingQuery = "UPDATE booking SET ckeckPayment = 1 WHERE booking_id = '$booking_id'";

        if (!mysqli_query($connection, $updateBookingQuery)) {
            throw new Exception('Error updating CheckPayment.');
        }

        // Fetch the room_id for the given booking_id
        $query = "SELECT room_id FROM booking WHERE booking_id = '$booking_id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $room_id = $row['room_id'];

            // Update the room status to 1 (approved/occupied)
            $updateRoomQuery = "UPDATE room SET status = 1 WHERE room_id = '$room_id'";

            if (!mysqli_query($connection, $updateRoomQuery)) {
                throw new Exception('Error updating room status.');
            }
        } else {
            throw new Exception('Error fetching room details.');
        }

        // Commit the transaction
        mysqli_commit($connection);
        echo 'success'; // Respond success if update is successful
    } catch (Exception $e) {
        // Rollback the transaction if any error occurs
        mysqli_roll_back($connection);
        echo 'Error: ' . $e->getMessage();
    }
}

// Close the connection
mysqli_close($connection);
?>
