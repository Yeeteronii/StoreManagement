<?php

// ================================
// DO NOT DELETE THIS FILE
// ================================


$path = dirname($_SERVER['SCRIPT_NAME']);
//$path = dirname(__DIR__);
include_once "Util/cdebug.php";
cdebug($path,'path');
cdebug(dirname(__DIR__),'DIR');

//include_once dirname(__DIR__) . "/shared/topbar.php";
//include_once dirname(__DIR__) . "/shared/sidebar.php";
?>
<?php
//include_once dirname(__DIR__) . "/shared/topbar.php";
//include_once dirname(__DIR__) . "/shared/sidebar.php";
?> 

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>document.getElementsByTagName("html")[0].className += " js";</script>
  <link rel="stylesheet" href="<?=$path?>/Views/shift/assets/css/style.css">
  <title>Schedule View</title>
</head>
<body>



<div class="main-content">
    <div class="cd-schedule cd-schedule--loading margin-top-lg margin-bottom-lg js-cd-schedule">
        <div class="cd-schedule__timeline">
        <ul>
            <li><span>09:00</span></li>
            <li><span>09:30</span></li>
            <li><span>10:00</span></li>
            <li><span>10:30</span></li>
            <li><span>11:00</span></li>
            <li><span>11:30</span></li>
            <li><span>12:00</span></li>
            <li><span>12:30</span></li>
            <li><span>13:00</span></li>
            <li><span>13:30</span></li>
            <li><span>14:00</span></li>
            <li><span>14:30</span></li>
            <li><span>15:00</span></li>
            <li><span>15:30</span></li>
            <li><span>16:00</span></li>
            <li><span>16:30</span></li>
            <li><span>17:00</span></li>
            <li><span>17:30</span></li>
            <li><span>18:00</span></li>
        </ul>
        </div> <!-- .cd-schedule__timeline -->
        <div class="cd-schedule__events">
        <ul>
            <li class="cd-schedule__group">
            <div class="cd-schedule__top-info"><span>Monday</span></div>
    
            <ul>
                <li class="cd-schedule__event">
                <a data-start="09:30" data-end="10:30" data-content="event-abs-circuit" data-event="event-1" href="#0">
                    <em class="cd-schedule__name">Abs Circuit</em>
                </a>
                </li>
    
                <li class="cd-schedule__event">
                <a data-start="11:00" data-end="12:30" data-content="event-rowing-workout" data-event="event-2" href="#0">
                    <em class="cd-schedule__name">Rowing Workout</em>
                </a>
                </li>
    
                <li class="cd-schedule__event">
                <a data-start="14:00" data-end="15:15"  data-content="event-yoga-1" data-event="event-3" href="#0">
                    <em class="cd-schedule__name">Yoga Level 1</em>
                </a>
                </li>
            </ul>
            </li>
    
            
        </ul>
        </div>
    
        <div class="cd-schedule-modal">
        <header class="cd-schedule-modal__header">
            <div class="cd-schedule-modal__content">
            <span class="cd-schedule-modal__date"></span>
            <h3 class="cd-schedule-modal__name"></h3>
            </div>
    
            <div class="cd-schedule-modal__header-bg"></div>
        </header>
    
        <div class="cd-schedule-modal__body">
            <div class="cd-schedule-modal__event-info"></div>
            <div class="cd-schedule-modal__body-bg"></div>
        </div>
    
        <a href="#0" class="cd-schedule-modal__close text-replace">Close</a>
        </div>
    
        <div class="cd-schedule__cover-layer"></div>
    </div> <!-- .cd-schedule -->
</div> <!-- .main-content -->

    <!-- <script src="<?=$path?>/Views/shift/assets/js/util.js"></script> 
    <script src="<?=$path?>/Views/shift/assets/js/main.js"></script> -->

    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Your JavaScript code here
        var path = "<?=$path?>"; // Access PHP variables inside the listener
        var utilScript = document.createElement('script');
        utilScript.src = path + '/Views/shift/assets/js/util.js';
        document.body.appendChild(utilScript);

        var mainScript = document.createElement('script');
        mainScript.src = path + '/Views/shift/assets/js/main.js';
        document.body.appendChild(mainScript);
    });
    </script>



</body>
</html>