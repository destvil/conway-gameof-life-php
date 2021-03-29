<?php


namespace destvil\Entity;


class PlaneCell {
    protected ?Cell $cell;
    protected Position $position;
    protected int $livingAdjacentCount;

    public function __construct(?Cell $cell, Position $position, int $livingAdjacentCount = 0) {
        $this->cell = $cell;
        $this->position = $position;
        $this->livingAdjacentCount = $livingAdjacentCount;
    }

    public function getCell(): ?Cell {
        return $this->cell;
    }

    public function getPosition(): Position {
        return $this->position;
    }

    public function getLivingAdjacentCount(): int {
        return $this->livingAdjacentCount;
    }

    public function widthCell(Cell $val): PlaneCell {
        $instance = clone $this;
        $instance->cell = $val;
        return $instance;
    }

    public function withAdjacentCount(int $val): PlaneCell {
        $instance = clone $this;
        $instance->livingAdjacentCount = $val;
        return $instance;
    }
}