<?php

declare(strict_types=1);

class Bits extends Runner
{
    protected const BITS = 36;

    protected function runPart1(): string
    {
        $data = $this->getData(__DIR__);
        $memory = [];
        $posMask = 0;
        $negMask = 0;

        foreach ($data as $line) {
            if (substr($line, 0, 4) === 'mask') {
                $mask = strrev(substr($line, 7));
                $posMask = 0;
                $negMask = 0;
                for ($i = 0; $i < self::BITS; $i++) {
                    if ($mask[$i] === '1') {
                        $posMask += 2 ** $i;
                    } elseif ($mask[$i] === '0') {
                        $negMask += 2 ** $i;
                    }
                }
            } else {
                preg_match('~^mem\[(\d+)] = (\d+)$~', $line, $m);
                [1 => $address, 2 => $value] = $m;
                $memory[$address] = ($value | $posMask) & ~$negMask;
            }
        }

        return (string) array_sum($memory);
    }

    protected function runPart2(): string
    {
        // TODO: Implement runPart2() method.
    }

}
