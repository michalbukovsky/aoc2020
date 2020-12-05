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

    /**
     * @param string $folder
     * @return string[]
     */
    protected function getData(string $folder): array
    {
        return array_filter(explode("\n", file_get_contents($folder . '/data.txt')));
    }

    abstract protected function runPart1(): string;

    abstract protected function runPart2(): string;

}
