<?php

class Ferry extends Runner
{
    protected const FORWARD = 'F';
    protected const LEFT = 'L';
    protected const RIGHT = 'R';
    protected const EAST = 'E';
    protected const WEST = 'W';
    protected const NORTH = 'N';
    protected const SOUTH = 'S';

    protected const HEADING_INDEXES = [
        self::NORTH => 0,
        self::EAST => 1,
        self::SOUTH => 2,
        self::WEST => 3,
    ];

    protected const INDEX_MOVE = [
        0 => [0, -1],
        1 => [1, 0],
        2 => [0, 1],
        3 => [-1, 0],
    ];

    /** @var array [dir, number] */
    private $data;


    public function __construct()
    {
        foreach ($this->getData(__DIR__) as $line) {
            $this->data[] = [$line[0], substr($line, 1)];
        }
    }

    protected function runPart1(): string
    {
        $x = 0;
        $y = 0;
        $headingIndex = self::HEADING_INDEXES[self::EAST];

        foreach ($this->data as $line) {
            [$instruction, $distance] = $line;
            $distance = (int) $distance;

            switch ($instruction) {
                case self::FORWARD:
                    $move = self::INDEX_MOVE[$headingIndex];
                    $x += $move[0] * $distance;
                    $y += $move[1] * $distance;
                    break;
                case self::LEFT:
                    $headingIndex = $this->rotate($headingIndex, -$distance);
                    break;
                case self::RIGHT:
                    $headingIndex = $this->rotate($headingIndex, $distance);
                    break;
                default:
                    $directIndexMove = self::HEADING_INDEXES[$instruction];
                    $directMove = self::INDEX_MOVE[$directIndexMove];
                    $x += $directMove[0] * $distance;
                    $y += $directMove[1] * $distance;
            }
        }

        return abs($x) + abs($y);
    }

    protected function runPart2(): string
    {
        $x = 0;
        $y = 0;
        $xWay = 10;
        $yWay = -1;

        foreach ($this->data as $line) {
            [$instruction, $distance] = $line;
            $distance = (int) $distance;

            switch ($instruction) {
                case self::FORWARD:
                    $x += $xWay * $distance;
                    $y += $yWay * $distance;
                    break;
                case self::LEFT:
                    [$xWay, $yWay] = $this->rotateWaypoint($xWay, $yWay, -$distance);
                    break;
                case self::RIGHT:
                    [$xWay, $yWay] = $this->rotateWaypoint($xWay, $yWay, $distance);
                    break;
                default:
                    $directIndexMove = self::HEADING_INDEXES[$instruction];
                    $directMove = self::INDEX_MOVE[$directIndexMove];
                    $xWay += $directMove[0] * $distance;
                    $yWay += $directMove[1] * $distance;
            }
        }

        return abs($x) + abs($y);
    }

    /**
     * @param int $headingIndex
     * @param int $degrees
     * @return int
     */
    protected function rotate(int $headingIndex, int $degrees): int
    {
        $headingIndex += (int) ($degrees / 90);
        if ($headingIndex < 0) {
            $headingIndex += 4;
        }
        if ($headingIndex >= 4) {
            $headingIndex -= 4;
        }

        return $headingIndex;
    }

    private function rotateWaypoint(int $xWay, int $yWay, int $distance): array
    {
        $steps = (int) (abs($distance) / 90);
        $direction = ($distance >= 0 ? 1 : -1);
        do {
            $xWayOriginal = $xWay;
            $yWayOriginal = $yWay;
            $yWay = (int) ($direction * $xWayOriginal);
            $xWay = (int) (-$direction * $yWayOriginal);
        } while (--$steps);
        
        return [$xWay, $yWay];
    }

}
