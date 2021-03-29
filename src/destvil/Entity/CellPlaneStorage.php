<?php


namespace destvil\Entity;


use SplObjectStorage;


class CellPlaneStorage implements \Iterator, \Countable {
    protected $data;

    public function __construct() {
        $this->data = new class extends SplObjectStorage {
            public function getHash($object): string {
                /** @var Position $object */
                return get_class($object) . $object->getX() . $object->getY();
            }
        };
    }

    public function get(Position $pos): ?PlaneCell {
        $cellExists = $this->data->offsetExists($pos);
        if (!$cellExists) {
            return null;
        }

        return $this->data->offsetGet($pos);
    }

    public function has(Position $pos): bool {
        return $this->data->offsetExists($pos);
    }

    public function set(Position $pos, ?PlaneCell $cell): CellPlaneStorage {
        $this->data->offsetSet($pos, $cell);
        return $this;
    }

    public function current(): object {
        return $this->data->current();
    }

    public function next(): void {
        $this->data->next();
    }

    public function key() {
        return $this->data->key();
    }

    public function valid(): bool {
        return $this->data->valid();
    }

    public function rewind(): void {
        $this->data->rewind();
    }

    public function count(): int {
        return $this->data->count();
    }
}