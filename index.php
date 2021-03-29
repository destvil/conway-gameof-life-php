<?php

use destvil\Autoloader;
use destvil\Controller\PlaneLoopDispatcher;
use destvil\Controller\PlaneSupervisor;
use destvil\Entity\Cell;
use destvil\Entity\PlaneCell;
use destvil\Entity\Plane;
use destvil\Entity\PlaneConfig;
use destvil\Entity\PlaneLoopDispatcherConfig;
use destvil\Entity\Position;
use destvil\Service\PlaneBuilder;
use destvil\Service\PlaneService;
use destvil\Service\PlaneViewService;
use destvil\View\Html;


$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__);

require $_SERVER['DOCUMENT_ROOT'] . '/src/destvil/Autoloader.php';

error_reporting(E_ALL);

$loader = new Autoloader();
$loader->register();

$loader->registerPrefix('src');

$planeService = new PlaneService();

$planeDispatcherConfig = new PlaneLoopDispatcherConfig(1);
$planeSupervisor = new PlaneSupervisor($planeService);

$whileLoopDispatcher = new PlaneLoopDispatcher($planeDispatcherConfig, $planeSupervisor);

$planeViewService = new PlaneViewService(new \destvil\View\OutputStream());

$planeConfig = new PlaneConfig(8, 10, array(
    new PlaneCell(new Cell(), new Position(1, 0)),
    new PlaneCell(new Cell(), new Position(2, 1)),
    new PlaneCell(new Cell(), new Position(2, 2)),
    new PlaneCell(new Cell(), new Position(1, 2)),
    new PlaneCell(new Cell(), new Position(0, 2)),
    new PlaneCell(new Cell(), new Position(7, 1)),
));

$planeBuilder = new PlaneBuilder($planeService);
$plane = $planeBuilder->build($planeConfig);

$whileLoopDispatcher->attachPlane($plane);

/** @var Plane $plane */

$outputStream = STDOUT;
foreach ($whileLoopDispatcher->start() as $plane) {
    ob_start();
    echo '<script>document.body.innerHTML = "";</script>';
    echo $planeViewService->render($plane);
    fwrite($outputStream, ob_get_clean());
//    $whileLoopDispatcher->stop();
}