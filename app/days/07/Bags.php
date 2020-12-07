<?php

class Bags extends Runner
{
    protected const NO_BAGS = 'no other bags';
    protected const GOLD_BAG = 'shiny gold';

    /**
     * @var array
     * Bag contents in this form:
     * [
     *   color => null,
     *   color => [
     *     color => 1,
     *     color => 2,
     *   ],
     * ]
     */
    protected $bags;

    public function __construct()
    {
        // wavy bronze bags contain 5 striped gold bags, 5 light tomato bags.
        $this->initBags();
    }

    protected function runPart1(): string
    {
        $canContainGold = [];

        foreach ($this->bags as $name => $contents) {
            if ($this->canContainGoldBag($name)) {
                $canContainGold[$name] = true;
            }
        }

        return count($canContainGold);
    }

    protected function runPart2(): string
    {
        return (string) $this->containsHowMany(self::GOLD_BAG);
    }

    protected function initBags(): void
    {
        $data = $this->getData(__DIR__);

        foreach ($data as $item) {
            preg_match('~^(.+) bags contain (.+)\.$~', $item, $m);
            [1 => $name, 2 => $contents] = $m;

            if ($contents === self::NO_BAGS) {
                $this->bags[$name] = null;
                continue;
            }

            $bagContents = [];
            $this->bags[$name] = preg_match_all('~(\d) ([a-z ]+) bags?(?:, )?~', $contents, $m, PREG_SET_ORDER);
            foreach ($m as $bagMatch) {
                $bagContents[$bagMatch[2]] = $bagMatch[1];
            }
            $this->bags[$name] = $bagContents;
        }
    }

    protected function canContainGoldBag(string $name): bool
    {
        $contents = $this->bags[$name];
        if ($contents === null) {
            return false;
        }
        if (array_key_exists(self::GOLD_BAG, $contents)) {
            return true;
        }

        foreach ($contents as $bagInsideName => $count) {
            if ($this->canContainGoldBag($bagInsideName)) {
                return true;
            }
        }

        return false;
    }

    protected function containsHowMany(string $name): int
    {
        $contents = $this->bags[$name];
        if ($contents === null) {
            return 0;
        }

        $containsCount = 0;
        foreach ($contents as $bagInsideName => $count) {
            $containsCount += $count + $count * $this->containsHowMany($bagInsideName);
        }

        return $containsCount;
    }

}
