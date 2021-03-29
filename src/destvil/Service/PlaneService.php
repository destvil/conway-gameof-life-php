<?php


namespace destvil\Service;


use destvil\Entity\Cell;
use destvil\Entity\PlaneCell;
use destvil\Entity\Plane;
use destvil\Entity\Position;


class PlaneService {
    public function updateCells(Plane $plane): Plane {
        /** @var Position $pos */
        $planeCells = $plane->getPlaneCells();
        foreach ($planeCells as $pos) {
            $planeCell = $planeCells->get($pos);
            $countLivingAdjacentCells = $planeCell->getLivingAdjacentCount();

            $cell = $planeCell->getCell();
            if ((is_null($cell) || !$cell->isAlive()) && $countLivingAdjacentCells === 3) {
                $cell = is_null($cell) ? new Cell() : $cell->setState(Cell::ALIVE);
                $planeCells->set($pos, $planeCell->widthCell($cell));
            } elseif (
                !(in_array($countLivingAdjacentCells, array(2,3)))
                && !is_null($cell) && $cell->isAlive()
            ) {
                $cell = $cell->setState(Cell::DEAD);
                $planeCells->set($pos, $planeCell->widthCell($cell));
            }
        }
        return $plane;
    }

    public function updateCellCountAliveAdjacent(Plane $plane): Plane {
        /** @var Position $pos */
        $planeCells = $plane->getPlaneCells();
        foreach ($planeCells as $pos) {
            $adjacentPlaneCells = $this->getAdjacentCellsByPosition($plane, $pos);

            $livingAdjacentCells = array_filter($adjacentPlaneCells, static function ($adjacentPlaneCell) {
                /** @var PlaneCell $adjacentPlaneCell */
                $cell =$adjacentPlaneCell->getCell();
                return !is_null($cell) && $cell->isAlive();
            });

            $planeCell = $planeCells->get($pos);
            $planeCell = $planeCell->withAdjacentCount(count($livingAdjacentCells));
            $planeCells->set($pos, $planeCell);
        }

        return $plane->withCells($planeCells);
    }

    public function getAdjacentCellsByPosition(Plane $plane, Position $position): array {
        $planeCells = $plane->getPlaneCells();

        $xPos = $position->getX();
        $yPos = $position->getY();

        $adjacentCellsPositions = array(
            new Position($xPos - 1, $yPos - 1),
            new Position($xPos, $yPos - 1),
            new Position($xPos + 1, $yPos - 1),
            new Position($xPos - 1, $yPos),
            new Position($xPos + 1, $yPos),
            new Position($xPos - 1, $yPos + 1),
            new Position($xPos, $yPos + 1),
            new Position($xPos + 1, $yPos + 1)
        );

        $adjacentCells = array();
        foreach ($adjacentCellsPositions as $pos) {
            if (!$planeCells->has($pos)) {
                continue;
            }

            $adjacentCells[] = $planeCells->get($pos);
        }

        return array_filter($adjacentCells, static function ($cell) {
            return !is_null($cell);
        });
    }
}