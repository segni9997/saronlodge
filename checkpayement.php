<?php
// Database connection
$connection = new mysqli("localhost", "root", "", "hotelthree");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch bookings where CheckPayment equals 0, join with customer, room, and room_type
$query = "SELECT b.booking_id, b.room_id, b.check_in, b.check_out, b.total_price, b.remaining_price, b.payment_status, c.customer_name, c.contact_no, c.email, c.id_card_no, r.room_no, rt.room_type
          FROM booking b
          JOIN customer c ON b.customer_id = c.customer_id
          JOIN room r ON b.room_id = r.room_id
          JOIN room_type rt ON r.room_type_id = rt.room_type_id
          WHERE b.ckeckPayment = 0"; // Fix the typo `ckeckPayment` to `checkPayment`

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
                        <!-- Display a button or icon for CheckPayment status -->
                        <button class="btn btn-primary approve-checkpayment" data-booking-id="<?php echo $row['booking_id']; ?>" data-payment-status="<?php echo $row['payment_status']; ?>">
                            <?php echo $row['payment_status'] == 0 ? 'Approve' : 'Approved'; ?>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal for approval -->
<div id="approvalModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Approve Booking</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to approve this booking?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="approveBookingBtn">Approve</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Listen for the button click event to approve CheckPayment
    document.querySelectorAll('.approve-checkpayment').forEach(function(button) {
        button.addEventListener('click', function() {
            var bookingId = this.getAttribute('data-booking-id');
            var paymentStatus = this.getAttribute('data-payment-status');
            
            // Only show the modal if payment status is pending (0)
            if (paymentStatus == 0) {
                // Store the booking ID for later use
                document.getElementById('approveBookingBtn').setAttribute('data-booking-id', bookingId);
                // Show the modal
                $('#approvalModal').modal('show');
            }
        });
    });

    // Handle the approval button click
    document.getElementById('approveBookingBtn').addEventListener('click', function() {
        var bookingId = this.getAttribute('data-booking-id');
        
        // Send the request to approve the booking and update CheckPayment
        $.ajax({
            url: 'approve_booking.php', // The PHP script that will handle approval
            type: 'POST',
            data: { booking_id: bookingId },
            success: function(response) {
                // If the update was successful, close the modal and update the UI
                if (response === 'success') {
                    $('#approvalModal').modal('hide');
                    alert('Booking approved successfully!');
                    location.reload(); // Reload the page to update the status
                } else {
                    alert('Error: ' + response);
                }
            }
        });
    });
</script>

<?php
// Close the connection
mysqli_close($connection);
?>
