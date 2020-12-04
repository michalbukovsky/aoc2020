<?php

class Multiplier extends Runner
{
    private $data;

    public function __construct()
    {
        $this->data = file_get_contents(__DIR__ . '/data.txt');
    }

    protected function runPart1(): string
    {
        $dataItems = array_filter(explode("\n", $this->data));
        $dataCount = count($dataItems);
        for ($i = 0; $i < $dataCount - 1; $i++) {
            for ($j = $i + 1; $j < $dataCount; $j++) {
                $value1 = (int) $dataItems[$i];
                $value2 = (int) $dataItems[$j];
                if ($value1 + $value2 === 2020) {
                    return "Result: " . ($value1 * $value2);
                }
            }
        }

        return "Nothing found :(";
    }

    protected function runPart2(): string
    {
        $dataItems = array_filter(explode("\n", $this->data));
        $dataCount = count($dataItems);
        for ($i = 0; $i < $dataCount - 2; $i++) {
            for ($j = $i + 1; $j < $dataCount - 1; $j++) {
                for ($k = $j + 1; $k < $dataCount; $k++) {
                    $value1 = (int) $dataItems[$i];
                    $value2 = (int) $dataItems[$j];
                    $value3 = (int) $dataItems[$k];
                    if ($value1 + $value2 + $value3 === 2020) {
                        return "Result: " . ($value1 * $value2 * $value3);
                    }
                }
            }
        }

        return "Nothing found :(";
    }
}
