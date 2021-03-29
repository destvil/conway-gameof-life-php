<?php

namespace destvil\Controller;


use destvil\Entity\Plane;
use destvil\Entity\PlaneLoopDispatcherConfig;
use destvil\Service\PlaneService;


class PlaneLoopDispatcher {
    /** @var Plane */
    protected Plane $plane;
    protected PlaneLoopDispatcherConfig $config;
    protected PlaneSupervisor $planeSupervisor;
    protected bool $loopStatus;

    public function __construct(PlaneLoopDispatcherConfig $config, PlaneSupervisor $planeSupervisor) {
        $this->config = $config;
        $this->planeSupervisor = $planeSupervisor;
        $this->loopStatus = false;
    }

    public function attachPlane(Plane $plane): void {
        $this->plane = $plane;
    }

    public function getStatus(): bool {
        return $this->loopStatus;
    }

    public function start(): \Generator {
        if (is_null($this->plane)) {
            throw new \Exception('No attached plane');
        }

        $firstCycle = true;
        $this->loopStatus = true;
        while ($this->loopStatus) {
            if (!$firstCycle) {
                $this->planeSupervisor->update($this->plane);
            }

            if (!$this->getStatus()) {
                break;
            }

            yield $this->plane;
            sleep($this->config->getTickTime());
            $firstCycle = false;
        }
    }

    public function stop(): void {
        $this->loopStatus = false;
    }
}