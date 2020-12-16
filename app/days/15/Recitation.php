<?php

declare(strict_types=1);

class Recitation extends Runner
{
    protected $data = [
        16 => [1],
        11 => [2],
        15 => [3],
        0 => [4],
        1 => [5],
        7 => [6],
    ];

    public function __construct()
    {
        ini_set('memory_limit', '4G');
    }

    protected function runPart1(): string
    {
        return $this->play(2020);
    }

    protected function runPart2(): string
    {
        return $this->play(30000000);
    }

    protected function play(int $end): string
    {
        end($this->data);
        $lastSpoken = key($this->data);
        $time = count($this->data);

        while (true) {
            $time++;
            if (isset($this->data[$lastSpoken][1])) {
                $lastSpoken = $this->data[$lastSpoken][1] - $this->data[$lastSpoken][0];
            } else {
                $lastSpoken = 0;
            }

            $this->data[$lastSpoken][] = $time;
            if (isset($this->data[$lastSpoken][2])) {
                array_shift($this->data[$lastSpoken]);
            }

            if ($time % 10000 === 0) {
                echo "$time: $lastSpoken\n";
            }

            if ($time === $end) {
                return (string) $lastSpoken;
            }
        }
    }

}
