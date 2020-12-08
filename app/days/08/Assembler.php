<?php

class Assembler extends Runner
{
    protected const ACC = 'acc';
    protected const JMP = 'jmp';
    protected const NOP = 'nop';

    protected $commands;

    public function __construct()
    {
        foreach ($this->getData(__DIR__) as $line) {
            preg_match('~^(nop|acc|jmp) \+?(-?\d+)$~', $line, $m);
            $this->commands[] = [$m[1], (int) $m[2]];
        }
    }

    protected function runPart1(): string
    {
        try {
            return (string) $this->runProgram($this->commands);
        } catch (InvalidStateException $e) {
            return $e->getMessage();
        }
    }

    protected function runPart2(): string
    {
        foreach ($this->commands as $pointer => $command) {
            $commands = $this->commands;
            if ($command[0] === self::JMP) {
                $commands[$pointer][0] = self::NOP;
            } elseif ($command[0] === self::NOP) {
                $commands[$pointer][0] = self::JMP;
            } else {
                continue;
            }

            try {
                return (string) $this->runProgram($commands);
            } catch (InvalidStateException $e) {
                continue;
            }
        }

        return 'nothing found.';
    }

    /**
     * @param array $commands
     * @return int
     * @throws \InvalidStateException
     */
    protected function runProgram(array $commands): int
    {
        $commandsUsed = [];
        $pointer = 0;
        $accumulator = 0;
        do {
            if ($commandsUsed[$pointer] === true) {
                throw new InvalidStateException($accumulator);
            }
            $commandsUsed[$pointer] = true;

            [$command, $argument] = $commands[$pointer];
            if ($command === self::JMP) {
                $pointer += $argument;
                continue;
            }

            if ($command === self::ACC) {
                $accumulator += $argument;
            }

            $pointer++;
        } while (isset($commands[$pointer]));

        return $accumulator;
    }

}
