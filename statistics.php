<?php
include_once "db.php";
include_once "header.php";
include_once "sidebar.php";
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Employee', 'Count'],
          ['Manager',     2],
          ['Cleaning',      14],
          ['Receptions',  4],
          ['Cook', 5],
        
        ]);

        var options = {
          title: 'Employees According To Positions',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
<style>
#piechart_3d{
		width: 400px; 
		height: 400px;
	        margin-left : 300px;
            }
#barchart_values{
		width: 400px; 
		height: 400px;
	        margin-left : 800px;
		margin-top :-400px;
            }
#calendar_basic{
		width: 1000px; 
		height: 250px;
	        margin-left : 300px;
            }


</style>
 <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Type", "Expense", { role: "style" } ],
        ["Maintanence", 8.94, "#b87333"],
        ["Salary", 10.49, "silver"],
        ["Electric Bills", 19.30, "gold"],
        ["External Services", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Hotel Expense",
        width: 410,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>


<?php
$bookingData = [];
$query = "SELECT DATE(booking_date) as booking_date, COUNT(*) as count FROM booking GROUP BY DATE(booking_date)";
$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $date = explode('-', $row['booking_date']); // Format: [Year, Month, Day]
    $bookingData[] = [intval($date[0]), intval($date[1]) - 1, intval($date[2]), (int)$row['count']];
}
?>

<script type="text/javascript">
google.charts.load("current", {packages:["calendar"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'date', id: 'Date' });
    dataTable.addColumn({ type: 'number', id: 'Room Booked' });
    dataTable.addRows([
        <?php
        foreach ($bookingData as $data) {
            echo "[new Date({$data[0]}, {$data[1]}, {$data[2]}), {$data[3]}],";
        }
        ?>
    ]);

    var options = {
        title: "Reserved Room on Different Day",
        height: 350,
        calendar: {
            cellSize: 15,
        },
        colorAxis: {
            colors: ['#e0f7fa', '#006064'], // Gradient from light blue to dark teal
        },
    };

    var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));
    chart.draw(dataTable, options);
}
</script>


  </head>
  <body>
  <?php
  if ($_SESSION['role_name'] == "Manager") {
    echo '<div id="piechart_3d"></div>';
 
  }
  ?>
  <style>
    .calendars {
      width: 100%;
      height: 100vh;
      overflow: auto;
      }
  </style>
  <div id="calendar_basic" class ="calendars" ></div>
  
</body>

</html>
<?php
include_once "footer.php";
?>
