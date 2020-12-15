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
        $shuttles = explode(',', $this->data[1]);
        $shuttlesOrdered = [];
        foreach ($shuttles as $index => $shuttle) {
            if ($shuttle === 'x') {
                continue;
            }
            $shuttlesOrdered[$index] = (int) $shuttle;
        }
        asort($shuttlesOrdered);
        end($shuttlesOrdered);
        $maxIndex = key($shuttlesOrdered);
        reset($shuttlesOrdered);

        $timestamp = 1;
        $step = 1;
        $nowSolvingIndex = 0;
        while (true) {
            echo "$nowSolvingIndex $timestamp\n";
            $lastSolved = $this->isSolvedIndex($timestamp, $shuttlesOrdered);
            if ($lastSolved === $maxIndex) {
                return $timestamp;
            }
            if ($lastSolved === $nowSolvingIndex) {
                next($shuttlesOrdered);
                $nowSolvingIndex = key($shuttlesOrdered);
                $step *= $shuttlesOrdered[$lastSolved];
            }

            $timestamp += $step;
        }
    }

    /**
     * Highest solved index, null if all
     *
     * @param int $timestamp
     * @param array $shuttles
     * @return int|null
     */
    protected function isSolvedIndex(int $timestamp, array $shuttles): ?int
    {
        $lastSolved = null;
        foreach ($shuttles as $index => $shuttle) {
            if (($timestamp + $index) % $shuttle === 0) {
                $lastSolved = $index;
            } else {
                return $lastSolved;
            }
        }

        return $lastSolved;
    }

}
