<?php
$path = $_SERVER['SCRIPT_NAME'];
include_once "Util/cdebug.php";
//cdebug('test');
?>

<html>
<head>
    <title>Schedule - Store Management System</title>
</head>
<body>

<?php include_once "Views/shared/sidebar.php"; ?>
<?php include_once "Views/shared/topbar.php"; ?>


<h2>Weekly Schedule</h2>

<div class="schedule">
    <!-- Time Headers (Rows) -->
    <div class="time-header"></div>
    <div class="time-header">Monday</div>
    <div class="time-header">Tuesday</div>
    <div class="time-header">Wednesday</div>
    <div class="time-header">Thursday</div>
    <div class="time-header">Friday</div>
    <div class="time-header">Saturday</div>
    <div class="time-header">Sunday</div>

    <!-- Time Slots -->
    <div class="time">12:00 AM</div>
    <div class="time">1:00 AM</div>
    <div class="time">2:00 AM</div>
    <div class="time">3:00 AM</div>
    <div class="time">4:00 AM</div>
    <div class="time">5:00 AM</div>
    <div class="time">6:00 AM</div>
    <div class="time">7:00 AM</div>
    <div class="time">8:00 AM</div>
    <div class="time">9:00 AM</div>
    <div class="time">10:00 AM</div>
    <div class="time">11:00 AM</div>
    <div class="time">12:00 PM</div>
    <div class="time">1:00 PM</div>
    <div class="time">2:00 PM</div>
    <div class="time">3:00 PM</div>
    <div class="time">4:00 PM</div>
    <div class="time">5:00 PM</div>
    <div class="time">6:00 PM</div>
    <div class="time">7:00 PM</div>
    <div class="time">8:00 PM</div>
    <div class="time">9:00 PM</div>
    <div class="time">10:00 PM</div>
    <div class="time">11:00 PM</div>

    <!-- Example shifts (time-based) -->
    <div class="shift" style="top: 2%; left: 20%; width: 100%; height: 6%;">Shift 1: 12:00 AM - 4:00 AM</div>
    <div class="shift" style="top: 20%; left: 40%; width: 100%; height: 6%;">Shift 2: 9:00 AM - 1:00 PM</div>
    <div class="shift" style="top: 28%; left: 60%; width: 100%; height: 6%;">Shift 3: 10:00 AM - 2:00 PM</div>
    <div class="shift" style="top: 60%; left: 80%; width: 100%; height: 6%;">Shift 4: 5:00 PM - 9:00 PM</div>
</div>

</body>
</html>