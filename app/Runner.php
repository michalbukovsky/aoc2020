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
     * @param bool $filterLines
     * @param string $separator
     * @return string[]
     */
    protected function getData(string $folder, bool $filterLines = true, string $separator = "\n"): array
    {
        $data = explode($separator, file_get_contents($folder . '/data.txt'));
        return ($filterLines === true ? array_filter($data) : $data);
    }

    /**
     * @param string[] $data
     * @return int[]
     */
    protected function intifyData(array $data): array
    {
        return array_map('intval', $data);
    }

    abstract protected function runPart1(): string;

    abstract protected function runPart2(): string;

}
