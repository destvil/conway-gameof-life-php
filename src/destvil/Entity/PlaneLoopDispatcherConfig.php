<?php


namespace destvil\Entity;


class PlaneLoopDispatcherConfig {
    protected float $tickTime;

    public function __construct(float $tickTime) {
        $this->tickTime = $tickTime;
    }

    public function getTickTime(): float {
        return $this->tickTime;
    }
}