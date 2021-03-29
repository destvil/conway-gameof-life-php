<?php


namespace destvil\Controller;


use destvil\Entity\Plane;
use destvil\Service\PlaneService;

class PlaneSupervisor {
    protected PlaneService $planeService;

    public function __construct(PlaneService $planeService) {
        $this->planeService = $planeService;
    }

    public function update(Plane $plane): void {
        $this->planeService->updateCellCountAliveAdjacent($plane);
        $this->planeService->updateCells($plane);
    }
}