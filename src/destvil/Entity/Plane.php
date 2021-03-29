<?php


namespace destvil\Entity;


class Plane {
    protected int $width;
    protected int $height;

    protected CellPlaneStorage $cells;

    public function __construct(int $width, int $height) {
        $this->width = $width;
        $this->height = $height;

        $this->cells = new CellPlaneStorage();

        for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x < $this->width; $x++) {
                $position = new Position($x, $y);
                $planeCell = new PlaneCell(null, $position);
                $this->cells->set($position, $planeCell);
            }
        }
    }

    public function withCells(CellPlaneStorage $cells): Plane {
        $instance = clone $this;
        $instance->cells = $cells;
        return $instance;
    }

    public function getPlaneCells(): CellPlaneStorage {
        return $this->cells;
    }
}