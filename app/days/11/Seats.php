<?php

class Seats extends Runner
{
    /** @var array[] */
    protected $seats;

    /** @var int */
    protected $columns;

    /** @var string[] */
    private $data;

    public function __construct()
    {
        $this->data = $this->getData(__DIR__);
        $this->columns = strlen($this->data[0]);

        $this->seats = [];
        foreach ($this->data as $line) {
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
        $that = $this;
        return $this->getOccupiedSeats(static function (array $seatsBefore, int $row, int $col) use ($that) {
            return $that->isSeatOccupiedNeighboring($seatsBefore, $row, $col);
        });
    }

    protected function runPart2(): string
    {
        $that = $this;
        return $this->getOccupiedSeats(static function (array $seatsBefore, int $row, int $col) use ($that) {
            return $that->isSeatOccupiedAcross($seatsBefore, $row, $col);
        });
    }

    protected function getOccupiedSeats(callable $isOccupiedFn): int
    {
        $seatsAfter = $this->seats;

        do {
            $occupied = 0;
            $seatsBefore = $seatsAfter;
            $seatsAfter = [];

            foreach ($seatsBefore as $row => $seatsRow) {
                foreach ($seatsRow as $col => $seat) {
                    $isOccupied = $isOccupiedFn($seatsBefore, $row, $col);
                    if ($isOccupied) {
                        $occupied++;
                    }
                    $seatsAfter[$row][$col] = $isOccupied;
                }
            }

            $this->dumpSeats($seatsAfter);
        } while ($seatsBefore !== $seatsAfter);

        return $occupied;
    }

    protected function isSeatOccupiedNeighboring(array $seatsBefore, int $row, int $col): bool
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

    protected function isSeatOccupiedAcross(array $seats, int $rowOrigin, int $colOrigin): bool
    {
        $wasOccupiedBefore = $seats[$rowOrigin][$colOrigin];
        $neighboring = 0;
        $rowsTotal = count($this->data);
        $colsTotal = strlen($this->data[0]);

        for ($rowDir = -1; $rowDir <= 1; $rowDir++) {
            for ($colDir = -1; $colDir <= 1; $colDir++) {
                if ($rowDir === 0 && $colDir === 0) {
                    continue;
                }

                $rowLook = $rowOrigin;
                $colLook = $colOrigin;
                while (min($rowLook + $rowDir, $colLook + $colDir) >= 0 && $rowLook + $rowDir < $rowsTotal && $colLook + $colDir < $colsTotal) {
                    $rowLook += $rowDir;
                    $colLook += $colDir;
                    if (!isset($seats[$rowLook][$colLook])) {
                        continue;
                    }
                    if ($seats[$rowLook][$colLook] === true) {
                        $neighboring++;
                        break;
                    }

                    break;  // empty seat found
                }
            }
        }

        if ($neighboring >= 5) {
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
