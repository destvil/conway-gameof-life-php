<?php


namespace destvil\Service;


use destvil\Entity\Plane;
use destvil\View\ViewEngine;

class PlaneViewService {
    protected ViewEngine $engine;

    public function __construct(ViewEngine $engine) {
        $this->engine = $engine;
    }

    public function render(Plane $plane) {
        return $this->engine->create($plane);
    }
}