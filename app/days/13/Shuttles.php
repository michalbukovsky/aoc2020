<?php

class Shuttles extends Runner
{
    /** @var string[] */
    private $data;

    /** @var int */
    protected $timestamp;

    /** @var int[] */
    protected $shuttles;

    public function __construct()
    {
        $this->data = $this->getData(__DIR__);
        $this->timestamp = $this->data[0];
    }

    protected function runPart1(): string
    {
        $this->shuttles = array_filter(explode(',', $this->data[1]), static function ($item) {
            return $item !== 'x';
        });
        $this->shuttles = $this->intifyData($this->shuttles);

        $closestTime = INF;
        $closestShuttle = null;

        foreach ($this->shuttles as $shuttle) {
            $shuttleTime = 0;
            do {
                $shuttleTime += $shuttle;
            } while ($shuttleTime < $this->timestamp);

            if ($shuttleTime < $closestTime) {
                $closestTime = $shuttleTime;
                $closestShuttle = $shuttle;
            }
        }

        return ($closestTime - $this->timestamp) * $closestShuttle;
    }

    protected function runPart2(): string
    {
    }

}
