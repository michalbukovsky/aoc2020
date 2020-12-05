<?php

class PWChecker extends Runner
{
    protected function runPart1(): string
    {
        // data example: 6-10 p: ctpppjmdpppppp
        $data = $this->getData(__DIR__);
        $correct = 0;

        foreach ($data as $dataLine) {
            preg_match('~^(\d+)-(\d+) (\w+): (.+)$~', $dataLine, $m);
            [1 => $min, 2 => $max, 3 => $character, 4 => $password] = $m;

            $count = substr_count($password, $character);
            if ($count >= $min && $count <= $max) {
                $correct++;
            }
        }
        return $correct;
    }

    protected function runPart2(): string
    {
        // data example: 6-10 p: ctpppjmdpppppp
        $data = $this->getData(__DIR__);
        $correct = 0;

        foreach ($data as $dataLine) {
            preg_match('~^(\d+)-(\d+) (\w+): (.+)$~', $dataLine, $m);
            [1 => $firstPosition, 2 => $secondPosition, 3 => $character, 4 => $password] = $m;

            $firstCorrect = substr($password, (int) $firstPosition - 1, 1) === $character;
            $secondCorrect = substr($password, (int) $secondPosition - 1, 1) === $character;

            if ($firstCorrect xor $secondCorrect) {
                $correct++;
            }
        }
        return $correct;
    }

}
