<?php

class Seats extends Runner
{
    /** @var array[] */
    protected $seats;

    /** @var int */
    protected $columns;

    public function __construct()
    {
        $data = $this->getData(__DIR__);
        $this->columns = strlen($data[0]);

        $this->seats = [];
        foreach ($data as $line) {
            $row = [];
            $col = 0;
            while (isset($line[$col])) {
                if ($line[$col] === 'L') {
                    $row[$col] = false;
                }
                $col++;
            }

            $this->seats[] = $row;
        }
    }

    protected function runPart1(): string
    {
        $seatsAfter = $this->seats;

        do {
            $occupied = 0;
            $seatsBefore = $seatsAfter;
            $seatsAfter = [];

            foreach ($seatsBefore as $row => $seatsRow) {
                foreach ($seatsRow as $col => $seat) {
                    $isOccipied = $this->isSeatOccupied($seatsBefore, $row, $col);
                    if ($isOccipied) {
                        $occupied++;
                    }
                    $seatsAfter[$row][$col] = $isOccipied;
                }
            }

            $this->dumpSeats($seatsAfter);
        } while ($seatsBefore !== $seatsAfter);

        return $occupied;
    }

    protected function runPart2(): string
    {
        // TODO: Implement runPart2() method.
    }

    protected function isSeatOccupied(array $seatsBefore, int $row, int $col): bool
    {
        $wasOccupiedBefore = $seatsBefore[$row][$col];
        $neighboring = 0;
        for ($myRow = $row - 1; $myRow <= $row + 1; $myRow++) {
            for ($myCol = $col - 1; $myCol <= $col + 1; $myCol++) {
                if ($myRow === $row && $myCol === $col) {
                    continue;
                }

                if (($seatsBefore[$myRow][$myCol] ?? null) === true) {
                    $neighboring++;
                }
            }
        }

        if ($neighboring >= 4) {
            return false;
        }
        if ($neighboring === 0) {
            return true;
        }
        return $wasOccupiedBefore;
    }

    protected function dumpSeats(array $seats): void
    {
        foreach ($seats as $row) {
            for ($myCol = 0; $myCol <= $this->columns; $myCol++) {
                if (!isset($row[$myCol])) {
                    echo '.';
                } else {
                    echo($row[$myCol] ? '#' : 'L');
                }
            }
            echo "\n";
        }
        echo "\n";
    }

}
