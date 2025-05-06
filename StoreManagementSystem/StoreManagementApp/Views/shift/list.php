<?php
$path = $_SERVER['SCRIPT_NAME'];
include_once "Util/cdebug.php";
cdebug('test');

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
cdebug(array_search('Tuesday', $daysOfWeek));

// Helper function to convert time to an hour index (e.g., "1:00 AM" => 1, "2:00 PM" => 14)
function timeToIndex($time) {
    $hour = date("H", strtotime($time)); // Get the hour in 24-hour format
    return (int)$hour;
}

// Function to render the table with shifts
function renderSchedule($shifts) {
    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    
    // Initialize a 2D array for the schedule: [day][timeSlot]
    $schedule = array_fill(0, 7, array_fill(0, 24, null)); // 7 days, 24 hours
    
    // Loop through shifts and populate the schedule array
    foreach ($shifts as $shift) {
        $dayIndex = array_search($shift->day, $daysOfWeek); // Find the corresponding day index
        $startIndex = timeToIndex($shift->startTime); // Convert start time to index (hour)
        $endIndex = timeToIndex($shift->endTime); // Convert end time to index (hour)
        
        // Mark the cells for the shift
        for ($i = $startIndex; $i < $endIndex; $i++) {
            $schedule[$dayIndex][$i] = $shift;
        }
    }

    // Start rendering the table
    echo '<table>';
    echo '<thead><tr><th>Time</th>';
    
    foreach ($daysOfWeek as $day) {
        echo "<th>$day</th>";
    }
    echo '</tr></thead>';
    
    echo '<tbody>';
    for ($i = 0; $i < 24; $i++) {
        echo "<tr><td>" . date("g:i A", strtotime("$i:00")) . "<br><br>" . "</td>";
        for ($j = 0; $j < 7; $j++) {
            $shift = $schedule[$j][$i];
            if ($shift) {
                // Display the shift with a background color (you can customize this further)
                echo "<td style='background-color: #76c7c0;'>{$shift->userId}</td>";
            } else {
                echo "<td class='empty'></td>";
            }
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}



?>

<html>
<head>
    <title>Schedule - Store Management System</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        td.empty {
            background-color: #fafafa;
        }
    </style>

</head>
<body>

<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>


<h2>Weekly Schedule</h2>

<?php renderSchedule($data); ?>



</body>
</html>