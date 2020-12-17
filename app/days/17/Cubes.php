<?php

class Cubes extends Runner
{
    /** @var bool[][][] */
    protected $grid = [];

    public function __construct()
    {
        foreach ($this->getData(__DIR__) as $line) {
            $i = 0;
            $row = [];
            while (isset($line[$i])) {
                $row[] = ($line[$i++] === '#');
            }

            $this->grid[0][] = $row;
        }
    }

    protected function runPart1(): string
    {
        $a = 0;
        // TODO: Implement runPart1() method.
    }

    protected function runPart2(): string
    {
        // TODO: Implement runPart2() method.
    }

}
