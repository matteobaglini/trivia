<?php
include_once 'Game.php';

class GameGoldenMasterTest extends \PHPUnit_Framework_TestCase
{
    private $master = 'master.txt';
    private $expectedOutput = array();
    private $sample = 10000;
    private $generation = false;

    public function setUp()
    {
        if (!file_exists($this->master)) {
            $this->generation = true;
        } else {
            $this->loadMaster();
        }
    }

    public function testSeveralThousandsIterationProduceTheSameResultsAsTheGoldStandard()
    {
        $this->output = array();
        srand(0);
        for ($i = 0; $i < $this->sample; $i++) {
            $output = $this->runAndCaptureOutput();
            $this->assertEqualToMaster($i, $output);
        }
    }

    private function assertEqualToMaster($i, $output)
    {
        if ($this->generation) {
            $this->storeInMaster($output);
        } else {
            $this->assertEquals($this->expectedOutput[$i], $output);
        }
    }

    private function storeInMaster($run)
    {
        $fp = fopen($this->master, 'a');
        fputcsv($fp, explode("\n", $run));
        fclose($fp);
    }

    private function loadMaster()
    {
        $fp = fopen($this->master, 'r');
        while ($run = fgetcsv($fp)) {
            $this->expectedOutput[] = implode("\n", $run);
        }
        return $this->expectedOutput;
    }

    private function runAndCaptureOutput()
    {
        $self = $this;
        $self->output = null;
        ob_start(function($output) use ($self) {
            $self->output = $output;
        });
        include 'sandbox/GameRunner.php';
        ob_end_clean();
        return $self->output;
    }
}
