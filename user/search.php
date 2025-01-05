<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hotelthree");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize filters
$filter_room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';

// SQL query with filters
$sql = "SELECT room.room_id, room.room_no, room.status, room_type.room_type 
        FROM room 
        JOIN room_type ON room.room_type_id = room_type.room_type_id 
        WHERE (room.status IS NULL OR room.status != 1)";

if ($filter_room_type) {
    $sql .= " AND room_type.room_type = '" . $conn->real_escape_string($filter_room_type) . "'";
}

$result = $conn->query($sql);

// Fetch room types for the filter dropdown
$room_types = $conn->query("SELECT DISTINCT room_type FROM room_type");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin: 16px;
            padding: 16px;
            text-align: center;
        }
        .room-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container my-4">
    <h1 class="text-center">Available Rooms</h1>

    <!-- Filter Form -->
    <form class="row g-3 my-4" method="GET" action="">
        <div class="col-md-6">
            <label for="room_type" class="form-label">Room Type</label>
            <select id="room_type" name="room_type" class="form-select">
                <option value="">All</option>
                <?php
                if ($room_types->num_rows > 0) {
                    while ($type = $room_types->fetch_assoc()) {
                        $selected = $type['room_type'] === $filter_room_type ? "selected" : "";
                        echo "<option value='" . $type['room_type'] . "' $selected>" . $type['room_type'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- Room List -->
    <div class="room-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card border shadow-sm' style='width: 18rem;'>";
                echo "<img src='path/to/image.jpg' class='card-img-top' alt='Room Image'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>Room " . $row['room_no'] . "</h5>";
                echo "<p class='card-text'><strong>Type:</strong> " . $row['room_type'] . "</p>";
                echo "<a href='bookroom.php?room_id=" . $row['room_id'] . "' class='btn btn-success'>Book Now</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center'>No rooms available.</p>";
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
