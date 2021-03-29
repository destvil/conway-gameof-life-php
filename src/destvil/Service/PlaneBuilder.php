<?php


namespace destvil\Service;


use destvil\Entity\Plane;
use destvil\Entity\PlaneConfig;
use destvil\Entity\Position;

class PlaneBuilder {
    protected PlaneService $planeService;

    public function __construct(PlaneService $planeService) {
        $this->planeService = $planeService;
    }

    public function build(PlaneConfig $config): Plane {
        $plane = new Plane($config->getWidth(), $config->getHeight());

        $planeCells = $plane->getPlaneCells();
        foreach ($config->getCells() as $confCell) {
            $planeCells->set($confCell->getPosition(), $confCell);
        }

        return $plane->withCells($planeCells);
    }
}