<?php
// Database connection
$connection = new mysqli("localhost", "root", "", "hotelthree");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch bookings where CheckPayment equals 0, join with customer, room, room_type
$query = "SELECT b.booking_id, b.room_id, b.check_in, b.check_out, b.total_price, b.remaining_price, b.payment_status, b.payment_proof, c.customer_name, c.contact_no, c.email, c.id_card_no, r.room_no, rt.room_type
          FROM booking b
          JOIN customer c ON b.customer_id = c.customer_id
          JOIN room r ON b.room_id = r.room_id
          JOIN room_type rt ON r.room_type_id = rt.room_type_id
          WHERE b.ckeckPayment = 0"; // Corrected typo in 'checkPayment'

$result = mysqli_query($connection, $query);
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <!-- Display booking records in a table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Contact No</th>
                    <th>Email</th>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Total Price</th>
                    <th>Remaining Amount</th>
                    <th>Payment Status</th>
                    <th>Payment Proof</th> <!-- New column for payment proof -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><input type="checkbox" name="approve_booking" class="approve_booking" data-booking-id="<?php echo $row['booking_id']; ?>"></td>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['contact_no']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['room_no']; ?></td>
                        <td><?php echo $row['room_type']; ?></td>
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo $row['check_out']; ?></td>
                        <td><?php echo $row['total_price']; ?> /-</td>
                        <td><?php echo $row['remaining_price']; ?> /-</td>
                        <td>
                            <button class="btn btn-primary approve-checkpayment" data-booking-id="<?php echo $row['booking_id']; ?>" data-payment-status="<?php echo $row['payment_status']; ?>">
                                <?php echo $row['payment_status'] == 0 ? 'Approve' : 'Approved'; ?>
                            </button>
                        </td>
                        <td>
                            <!-- Display the payment proof -->
                            <?php if ($row['payment_proof']) { ?>
                                <button class="btn btn-info view-proof" data-image="user/<?php echo $row['payment_proof']; ?>" data-toggle="modal" data-target="#imageModal">View Proof</button>
                            <?php } else { ?>
                                No Proof Available
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for displaying the image -->
    <div id="imageModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Payment Proof</h4>
                </div>
                <div class="modal-body">
    <img id="modalImage" src="" alt="Payment Proof" class="img-fluid" style="max-width: 100%; max-height: 800px; height: auto;">
</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Listen for clicks on the "View Proof" button
    document.querySelectorAll('.view-proof').forEach(function(button) {
        button.addEventListener('click', function() {
            var imageUrl = this.getAttribute('data-image');
            console.log(imageUrl);
             // Get the image URL from the button's data-image attribute
            // Set the image URL to the modal image
            document.getElementById('modalImage').src = imageUrl;
        });
    });
</script>

<?php
// Close the connection
mysqli_close($connection);
?>
