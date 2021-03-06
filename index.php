<?php

error_reporting(E_ALL);

use Tracy\Debugger;

require_once __DIR__ . '/vendor/autoload.php';

$loader = new Nette\Loaders\RobotLoader;

$loader->addDirectory(__DIR__ . '/app');
Debugger::enable(null, __DIR__ . '/log');
Debugger::$strictMode = true;

$loader->setTempDirectory(__DIR__ . '/temp');
$loader->register();


$day = ($argv[1] ?? null);
$part = (int) ($argv[2] ?? 1);

if ($day === null) {
    die("No day specified\n");
}
if (!preg_match('~^\d{1,2}$~', $day)) {
    die("Only positive numbers, please\n");
}

$folderName = __DIR__ . '/app/days/' . str_pad($day, 2, '0', STR_PAD_LEFT);
if (!file_exists($folderName)) {
    die("Day not yet implemented\n");
}

$filesInFolder = scandir($folderName);

foreach ($filesInFolder as $filename) {
    if (substr($filename, -3) === 'php') {
        $className = substr($filename, 0, -4);
        /** @var IRunner $day */
        $day = new $className();
        echo "Result: " . $day->run($part) . "\n";
        die;
    }
}

die("No class found\n");
