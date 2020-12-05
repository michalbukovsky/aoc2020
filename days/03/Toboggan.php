<?php

class Toboggan extends Runner
{

    protected function runPart1(): string
    {
        $data = $this->getData(__DIR__);
        $dataCount = count($data);
        $hitTrees = 0;

        // top left is 0,0
        $x = 3;
        for ($y = 1; $y < $dataCount; $y++) {
            if ($this->isTreeHit($x, $y, $data)) {
                $hitTrees++;
            }
            $x += 3;
        }

        return $hitTrees;
    }

    protected function runPart2(): string
    {
        // TODO: Implement runPart2() method.
        return '';
    }

    protected function isTreeHit(int $x, int $y, array $data): bool
    {
        $maxWidth = strlen($data[0]);
        $x %= $maxWidth;

        return substr($data[$y], $x, 1) === '#';
    }

}
