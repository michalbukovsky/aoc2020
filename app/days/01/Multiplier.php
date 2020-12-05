<?php

class Multiplier extends Runner
{
    protected function runPart1(): string
    {
        $data = $this->getData(__DIR__);

        $dataCount = count($data);
        for ($i = 0; $i < $dataCount - 1; $i++) {
            for ($j = $i + 1; $j < $dataCount; $j++) {
                $value1 = (int) $data[$i];
                $value2 = (int) $data[$j];
                if ($value1 + $value2 === 2020) {
                    return (string) ($value1 * $value2);
                }
            }
        }

        return "Nothing found :(";
    }

    protected function runPart2(): string
    {
        $data = $this->getData(__DIR__);

        $dataCount = count($data);
        for ($i = 0; $i < $dataCount - 2; $i++) {
            for ($j = $i + 1; $j < $dataCount - 1; $j++) {
                for ($k = $j + 1; $k < $dataCount; $k++) {
                    $value1 = (int) $data[$i];
                    $value2 = (int) $data[$j];
                    $value3 = (int) $data[$k];
                    if ($value1 + $value2 + $value3 === 2020) {
                        return (string) ($value1 * $value2 * $value3);
                    }
                }
            }
        }

        return "Nothing found :(";
    }
}
