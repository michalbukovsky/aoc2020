<?php

class Answers extends Runner
{
    protected function runPart1(): string
    {
        $data = $this->getData(__DIR__, false, "\n\n");
        $yesAnswers = 0;    // sum of all yes answers (for every group)

        foreach ($data as $group) {
            $yesAnswersGroup = [];
            $people = explode("\n", $group);
            foreach ($people as $person) {
                $i = 0;
                while (isset($person[$i])) {
                    $yesAnswersGroup[$person[$i++]];
                }
            }

            $yesAnswers += count($yesAnswersGroup);
        }

        return (string) $yesAnswers;
    }

    protected function runPart2(): string
    {
        $data = $this->getData(__DIR__, false, "\n\n");
        $yesAnswers = 0;    // sum of all yes answers (for every group)

        foreach ($data as $group) {
            $yesAnswersGroup = [];
            $people = explode("\n", $group);
            foreach ($people as $person) {
                $i = 0;
                while (isset($person[$i])) {
                    $yesAnswersGroup[$person[$i++]]++;
                }
            }

            $yesAnswers += $this->getAllYesFromGroupCount($yesAnswersGroup, count($people));
        }

        return (string) $yesAnswers;
    }

    protected function getAllYesFromGroupCount(array $yesAnswersGroup, int $countPeople): int
    {
        $yes = 0;
        foreach ($yesAnswersGroup as $answer => $count) {
            if ($count === $countPeople) {
                $yes++;
            }
        }

        return $yes;
    }
}