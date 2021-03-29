<?php


namespace destvil\View;


use destvil\Entity\Plane;


abstract class ViewEngine {
    abstract public function create(Plane $plane);
}