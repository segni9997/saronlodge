<?php
// Database connection
$connection = new mysqli("localhost", "root", "", "hotelthree");

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $contact_no = mysqli_real_escape_string($connection, $_POST['contact_no']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $id_card_id = mysqli_real_escape_string($connection, $_POST['id_card_id']);
    $id_card_no = mysqli_real_escape_string($connection, $_POST['id_card_no']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $check_in_date = mysqli_real_escape_string($connection, $_POST['check_in_date']);
    $check_out_date = mysqli_real_escape_string($connection, $_POST['check_out_date']);
    $room_id = mysqli_real_escape_string($connection, $_POST['room_id']);
    $remaining_price = mysqli_real_escape_string($connection, $_POST['remaining_price']);

    // File upload validation
    $target_dir = "uploads/";
    $payment_image = $target_dir . basename($_FILES['payment_image']['name']);
    $payment_image_file_type = strtolower(pathinfo($payment_image, PATHINFO_EXTENSION));

    // Check if the uploaded file is an image
    $check = getimagesize($_FILES['payment_image']['tmp_name']);
    if ($check === false) {
        die("File is not an image.");
    }

    // Allow only certain file formats
    if (!in_array($payment_image_file_type, ['jpg', 'png', 'jpeg', 'gif'])) {
        die("Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move uploaded file to the target directory
    move_uploaded_file($_FILES['payment_image']['tmp_name'], $payment_image);

    // Insert the customer into the `customer` table
    $customer_sql = "INSERT INTO customer (customer_name, contact_no, email, id_card_type_id, id_card_no, address) 
                     VALUES ('$first_name $last_name', '$contact_no', '$email', '$id_card_id', '$id_card_no', '$address')";

    if (mysqli_query($connection, $customer_sql)) {
        // Get the generated customer_id
        $customer_id = mysqli_insert_id($connection);

        // Calculate total days
        $check_in = new DateTime($check_in_date);
        $check_out = new DateTime($check_out_date);
        $days = $check_in->diff($check_out)->days;

        // Fetch room price
        $room_query = "SELECT price FROM room NATURAL JOIN room_type WHERE room_id = '$room_id'";
        $room_result = mysqli_query($connection, $room_query);
        $room = mysqli_fetch_assoc($room_result);
        $price_per_night = $room['price'];
        $total_price = $days * $price_per_night;

        // Insert booking data into the `booking` table using the customer_id
        $sql = "INSERT INTO booking (customer_id, room_id, check_in, check_out, total_price,remaining_price, payment_proof, CkeckPayment) 
                VALUES ('$customer_id', '$room_id', '$check_in_date', '$check_out_date', '$total_price','$remaining_price', '$payment_image', 0)";

        if (mysqli_query($connection, $sql)) {
            echo "<script>alert('Booking submitted successfully! Waiting for approval.'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Fetch room details if `room_id` is passed
if (isset($_GET['room_id'])) {
    $get_room_id = $_GET['room_id'];
    $get_room_sql = "SELECT * FROM room NATURAL JOIN room_type WHERE room_id = '$get_room_id'";
    $get_room_result = mysqli_query($connection, $get_room_sql);
    $get_room = mysqli_fetch_assoc($get_room_result);

    $get_room_type_id = $get_room['room_type_id'];
    $get_room_type = $get_room['room_type'];
    $get_room_no = $get_room['room_no'];
    $get_room_price = $get_room['price'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
    <h2>Book Room</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="room_id" value="<?php echo $get_room_id; ?>">

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>

        <div class="mb-3">
            <label for="contact_no" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_no" name="contact_no" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="id_card_id" class="form-label">ID Card Type</label>
            <select class="form-control" id="id_card_id" name="id_card_id" required>
                <option selected disabled>Select ID Card Type</option>
                <?php
                $id_card_query = "SELECT * FROM id_card_type";
                $id_card_result = mysqli_query($connection, $id_card_query);
                while ($id_card = mysqli_fetch_assoc($id_card_result)) {
                    echo '<option value="'.$id_card['id_card_type_id'].'">'.$id_card['id_card_type'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_card_no" class="form-label">ID Card Number</label>
            <input type="text" class="form-control" id="id_card_no" name="id_card_no" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>

        <div class="mb-3">
    <label for="check_in_date" class="form-label">Check-in Date</label>
    <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
</div>

<div class="mb-3">
    <label for="check_out_date" class="form-label">Check-out Date</label>
    <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
</div>

<div class="mb-3">
    <label for="total_price" class="form-label">Total Price</label>
    <input type="text" class="form-control" id="total_price" name="total_price" readonly>
</div>

<div class="mb-3">
    <label class="form-label">Minimum Pre-payment (25%):</label>
    <div id="pre_payment_display" style="font-weight: bold; color: #007bff;">0.00</div>
</div>

<div class="mb-3">
    <label for="remaining_price" class="form-label">Pre-payment</label>
    <input type="text" class="form-control" id="remaining_price" name="remaining_price" required>
</div>

        <div class="mb-3">
            <label for="payment_image" class="form-label">Payment Proof  <span style="color:red" >screenshot, bank statement is valid </span></label>
            <input type="file" class="form-control" id="payment_image" name="payment_image" required>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Set today's date as the minimum date for check-in
    const today = new Date().toISOString().split('T')[0];
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');
    const totalPriceInput = document.getElementById('total_price');
    const prePaymentDisplay = document.getElementById('pre_payment_display');
    const roomPrice = <?php echo $get_room_price; ?>; // Get room price from PHP

    checkInDate.min = today;

    // Ensure check-out date is after check-in date
    checkInDate.addEventListener('change', function () {
        checkOutDate.min = checkInDate.value;
        calculateTotalPrice(); // Recalculate total price
    });

    checkOutDate.addEventListener('change', function () {
        calculateTotalPrice(); // Recalculate total price
    });

    function calculateTotalPrice() {
        if (checkInDate.value && checkOutDate.value) {
            const checkIn = new Date(checkInDate.value);
            const checkOut = new Date(checkOutDate.value);
            const days = Math.max((checkOut - checkIn) / (1000 * 60 * 60 * 24), 0); 
            const totalPrice = days * roomPrice;
            totalPriceInput.value = totalPrice.toFixed(2);

            // Calculate and display 25% of the total price
            const minPrePayment = totalPrice * 0.25;
            prePaymentDisplay.textContent = minPrePayment.toFixed(2);
        }
    }
});
</script>

</body>
</html>
