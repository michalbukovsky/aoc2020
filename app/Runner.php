<?php

abstract class Runner implements IRunner
{
    public function run(int $part): string
    {
        if ($part === 1) {
            return $this->runPart1();
        }
        if ($part === 2) {
            return $this->runPart2();
        }

        return 'Invalid part!';
    }

    abstract protected function runPart1(): string;

    abstract protected function runPart2(): string;

}
