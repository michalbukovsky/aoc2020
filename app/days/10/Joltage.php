<?php

class Joltage extends Runner
{
    // :)
    protected const POSSIBILITIES_PER_GROUP_SIZE = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 4,
        5 => 7,
    ];

    /** @var int[] */
    private $data;

    public function __construct()
    {
        $this->data = $this->intifyData($this->getData(__DIR__));
        sort($this->data);
    }

    protected function runPart1(): string
    {
        $differences = [];
        $lastJoltage = 0;
        foreach ($this->data as $joltage) {
            $diff = $joltage - $lastJoltage;
            $differences[$diff]++;
            $lastJoltage = $joltage;
        }

        $differences[3]++;
        return $differences[1] * $differences[3];
    }

    protected function runPart2(): string
    {
        $data = $this->data;
        $dataCount = count($data);
        array_unshift($data, 0);

        $possibilities = 1;
        $i = 0;
        $groupSize = 0;
        foreach ($data as $item) {
            $groupSize++;
            if ($data[$i + 1] - $item > 1 || $i === $dataCount) {
                $possibilities *= self::POSSIBILITIES_PER_GROUP_SIZE[$groupSize];
                echo $groupSize . "\n";
                $groupSize = 0;
            }
            $i++;
        }


        return $possibilities;
    }

}
