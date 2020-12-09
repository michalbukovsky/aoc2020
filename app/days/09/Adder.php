<?php

class Adder extends Runner
{
    private const PREAMBLE = 25;

    /** @var string[] */
    private $data;

    public function __construct()
    {
        $this->data = $this->intifyData($this->getData(__DIR__));
    }

    protected function runPart1(): string
    {
        $pointer = self::PREAMBLE;

        do {
            $theNumber = $this->data[$pointer];
            for ($i = $pointer - self::PREAMBLE; $i < $pointer - 1; $i++) {
                for ($j = $i + 1; $j < $pointer; $j++) {
                    if ($this->data[$i] + $this->data[$j] === $theNumber) {
                        $pointer++;
                        continue 3;
                    }
                }
            }

            return $theNumber;
        } while (isset($this->data[$pointer]));

        return 'Nothing found.';
    }

    protected function runPart2(): string
    {
        $theNumber = (int) $this->runPart1();
        $dataCount = count($this->data);

        for ($i = 0; $i < $dataCount - 1; $i++) {
            $sum = $min = $max = $this->data[$i];

            for ($j = $i + 1; $j < $dataCount; $j++) {
                $sum += $this->data[$j];
                $min = min($min, $this->data[$j]);
                $max = max($max, $this->data[$j]);

                if ($sum > $theNumber) {
                    continue 2;
                }
                if ($sum === $theNumber) {
                    return $min + $max;
                }
            }
        }

        return 'Nothing found.';
    }

}
