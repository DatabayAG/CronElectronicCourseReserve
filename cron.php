<?php

require_once './Services/Cron/classes/class.ilCronStartUp.php';

if ($_SERVER['argc'] < 4) {
    echo "Usage: cron.php username password client\n";
    exit(1);
}
try {
    $cron = new ilCronStartUp($_SERVER['argv'][3], $_SERVER['argv'][1], $_SERVER['argv'][2]);
    $cron->initIlias();
    $cron->authenticate();

    require_once dirname(__FILE__) . '/classes/class.ilCronElectronicCourseReservePlugin.php';
    $instance = ilCronElectronicCourseReservePlugin::getInstance();
    $instance->getCronJobInstance(0)->run();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    exit(1);
}

