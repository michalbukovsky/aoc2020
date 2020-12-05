<?php

class Toboggan extends Runner
{
    private const INCREMENTS_2 = [
        ['x' => 1, 'y' => 1],
        ['x' => 3, 'y' => 1],
        ['x' => 5, 'y' => 1],
        ['x' => 7, 'y' => 1],
        ['x' => 1, 'y' => 2],
    ];

    protected function runPart1(): string
    {
        $data = $this->getData(__DIR__);

        return $this->getTreesHit($data, 3, 1);
    }

    protected function runPart2(): string
    {
        $data = $this->getData(__DIR__);

        $treesHitMultiplied = 1;
        foreach (self::INCREMENTS_2 as $increments) {
            $treesHitMultiplied *= $this->getTreesHit($data, $increments['x'], $increments['y']);
        }
        return $treesHitMultiplied;
    }

    protected function getTreesHit(array $data, int $xIncrement, int $yIncrement): int
    {
        $dataCount = count($data);
        $hitTrees = 0;

        // top left is 0,0
        $x = $xIncrement;
        for ($y = $yIncrement; $y < $dataCount; $y += $yIncrement) {
            if ($this->isTreeHit($x, $y, $data)) {
                $hitTrees++;
            }
            $x += $xIncrement;
        }

        return $hitTrees;
    }

    protected function isTreeHit(int $x, int $y, array $data): bool
    {
        $maxWidth = strlen($data[0]);
        $x %= $maxWidth;

        return substr($data[$y], $x, 1) === '#';
    }

}
