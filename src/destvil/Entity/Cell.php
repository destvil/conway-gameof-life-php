<?php


namespace destvil\Entity;


class Cell {
    public const ALIVE = 'ALIVE';
    public const DEAD = 'DEAD';

    protected string $name;

    protected string $color;

    protected string $state;

    public function __construct(string $state = self::ALIVE) {
        $this->state = $state;
    }

/*    public function __construct(string $name, string $color, string $state) {
        $this->name = $name;
        $this->color = $color;
        $this->state = $state;
    }*/

    public function isAlive(): bool {
        return $this->state === self::ALIVE;
    }

    protected function getState(): string {
        return $this->state;
    }

    public function setState(string $state): Cell {
        $this->state = $state;
        return $this;
    }
}