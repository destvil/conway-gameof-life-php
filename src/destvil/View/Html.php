<?php


namespace destvil\View;


use destvil\Entity\Cell;
use destvil\Entity\Plane;
use destvil\Entity\Position;


class Html extends ViewEngine {

    public function create(Plane $plane) {
        $planeCells = $plane->getPlaneCells();
        ob_start();

        $planeCells->rewind();

        $currentY = $planeCells->current()->getY();
        /** @var Position $pos */
        foreach ($planeCells as $pos) {
            if ($pos->getY() !== $currentY) {
                echo PHP_EOL; echo '<br>';
                $currentY = $pos->getY();
            }

            $planeCell = $planeCells->get($pos);
            $cell = $planeCell->getCell();
            echo ($cell instanceof Cell) && $cell->isAlive() ? "\u{2B1B}" : "\u{2B1C}";
        }

        return ob_get_clean();
    }
}