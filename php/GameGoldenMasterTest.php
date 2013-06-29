<?php
include_once 'Game.php';

class GameGoldenMasterTest extends \PHPUnit_Framework_TestCase
{
    private $master = 'master.txt';
    private $sample = 10000;

    public function testSeveralThousandsIterationProduceTheSameResultsAsTheGoldStandard()
    {
        $this->output = array();
        srand(0);
        $this->captureOutput($this->sample);
        $this->storeMasterIfNotPresent();
        $this->assertEquals($this->sample, count($this->output));
        $expectedOutput = $this->loadMaster();
        $this->assertEquals($expectedOutput, $this->output);
    }

    private function storeMasterIfNotPresent()
    {
        if (!file_exists($this->master)) {
            $fp = fopen($this->master, 'w');
            foreach ($this->output as $run) {
                fputcsv($fp, explode("\n", $run));
            }
            fclose($fp);
        }
    }

    private function loadMaster()
    {
        $fp = fopen($this->master, 'r');
        while ($run = fgetcsv($fp)) {
            $expectedOutput[] = implode("\n", $run);
        }
        return $expectedOutput;
    }

    private function captureOutput($games)
    {
        for ($i = 1; $i <= $games; $i++) {
            ob_start(function($output) {
                $this->output[] = $output;
            });
            include 'sandbox/GameRunner.php';
            ob_end_clean();
        }
    }
}
