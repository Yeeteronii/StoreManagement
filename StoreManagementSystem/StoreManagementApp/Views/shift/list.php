<?php
if (!isset($_SESSION['token'])) {
    header("Location: ../login/login");
    exit;
}

$path = $_SERVER['SCRIPT_NAME'];
$dirname = dirname($path);
$shifts = $data['shifts'] ?? [];
$username = $_SESSION['username'];
$weekDays = ['monday'=>1, 'tuesday'=>2, 'wednesday'=>3, 'thursday'=>4, 'friday'=>5, 'saturday'=>6, 'sunday'=>7];

$canAdd = $data['canAdd'] ?? false;
$canUpdate = $data['canUpdate'] ?? false;
$canDelete = $data['canDelete'] ?? false;

function idToColor($id) {
    $hash = md5($id);
    $r = hexdec(substr($hash, 0, 2));
    $g = hexdec(substr($hash, 2, 2));
    $b = hexdec(substr($hash, 4, 2));
    return sprintf("#%02x%02x%02x", $r, $g, $b);
}
?>
<?php include_once dirname(__DIR__) . "/shared/topbar.php"; ?>
<?php include_once dirname(__DIR__) . "/shared/sidebar.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Schedule</title>
    <link rel="stylesheet" href="<?= $dirname ?>/Views/styles/shifts.css">
    <style>
        .time-labels {
            height: 100%;
            display: grid;
            grid-template-rows: 40px repeat(14, 60px);
        }
        .schedule-grid {
            height: fit-content;
            overflow: hidden;
            display: grid;
            grid-template-columns: repeat(7, minmax(180px, 1fr));
            grid-template-rows: 40px repeat(14, 60px);
            background: white;
            max-width: calc(7 * 180px);
        }
    </style>
</head>
<body>
<div class="content">
    <div class="schedule-container">
        <div class="time-labels">
            <div class="header-cell"></div>
            <?php
            $startHour = 9;
            $endHour = 23;
            for ($hour = $startHour; $hour < $endHour; $hour++) {
                echo "<div class='time-label'>" . sprintf("%02d:00 - %02d:00", $hour, $hour+1) . "</div>";
            }
            ?>
        </div>

        <div class="schedule-grid">
            <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day): ?>
                <div class="day"><?= $day ?></div>
            <?php endforeach; ?>

            <?php for ($hour = 9; $hour <= 22; $hour++): ?>
                <?php for ($day = 1; $day <= 7; $day++): ?>
                    <div class="time-cell"></div>
                <?php endfor; ?>
            <?php endfor; ?>

            <?php foreach ($shifts as $shift): ?>
                <?php
                $shiftStartHour = intval(explode(':', $shift->startTime)[0]);
                $shiftEndHour = intval(explode(':', $shift->endTime)[0]);
                $duration = $shiftEndHour - $shiftStartHour;
                $dayIndex = $weekDays[strtolower($shift->day)];

                $colStart = $dayIndex;
                $rowStart = ($shiftStartHour - 9) + 2;
                $rowSpan = $duration;
                $color = idToColor($shift->userId);
                ?>
                <div class="shift-block"
                     style="
                             grid-column: <?= $colStart ?>;
                             grid-row: <?= $rowStart ?> / span <?= $rowSpan ?>;
                             background: <?= $color ?>;
                             ">
                    <?= htmlspecialchars($shift->username) ?>
                    <div class="shift-actions">
                        <?php if ($canUpdate && $canDelete): ?>
                            <a href="<?= dirname($path); ?>/shift/update/<?= $shift->shiftId ?>">
                                <img src="<?= $dirname ?>/images/update-light.png" alt="Edit" style="width:20px; height:20px;">
                            </a>
                            <a href="<?= dirname($path); ?>/shift/delete/<?= $shift->shiftId ?>" onclick="return confirm('Are you sure?');">
                                <img src="<?= $dirname ?>/images/delete-light.png" alt="Delete" style="width:20px; height:20px;">
                            </a>
                        <?php else: ?>
                            <p>No Rights To Edit or Update</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="add-shift-container">
        <?php if ($canAdd): ?>
            <a href="<?= dirname($path); ?>/shift/add">
                <button class="add-shift-btn">
                    <img src="<?= $dirname ?>/images/add-light.png">
                </button>
            </a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
