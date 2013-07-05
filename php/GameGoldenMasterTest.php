<?php
include_once 'Game.php';

class GameGoldenMasterTest extends \PHPUnit_Framework_TestCase
{
    private $master = 'master.txt';
    private $expectedOutput = array();
    private $sample = 100;
    private $generation;

    public function setUp()
    {
        $original = __DIR__ . '/GameRunner.php';
        $inSandbox = __DIR__ . '/sandbox/GameRunner.php';
        if (!file_exists($inSandbox)) {
            exec("ln $original $inSandbox", $output, $returnCode);
            $this->assertEquals(0, $returnCode, "Linking the GameRunner in the sandbox to avoid multiple include() calls failed.");
        }
        if (!file_exists($this->master)) {
            $this->fp = fopen($this->master, 'a');
            $this->generation = true;
        } else {
            $this->fp = fopen($this->master, 'r');
            $this->generation = false;
        }
    }

    public function tearDown()
    {
        fclose($this->fp);
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
            $this->assertEquals($this->loadMasterRun(), $output);
        }
    }

    private function storeInMaster($run)
    {
        fputcsv($this->fp, explode("\n", $run));
    }

    private function loadMasterRun()
    {
        $run = fgetcsv($this->fp);
        return implode("\n", $run);
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
