<?php


namespace destvil\Entity;


class PlaneConfig {
    protected int $width;

    protected int $height;

    /** @var PlaneCell[] */
    protected array $cells;

    public function __construct(int $width, int $height, array $cells) {
        $this->width = $width;
        $this->height = $height;
        $this->cells = $cells;
    }

    public function getWidth(): int {
        return $this->width;
    }

    public function getHeight(): int {
        return $this->height;
    }

    public function getCells(): array {
        return $this->cells;
    }
}