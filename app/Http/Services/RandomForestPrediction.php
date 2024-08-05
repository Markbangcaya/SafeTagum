<?php

namespace App\Http\Services;

use Rubix\ML\Classifiers\ClassificationTree;
use Rubix\ML\Classifiers\RandomForest;
use Rubix\ML\Datasets\Labeled;

class RandomForestPrediction
{
    public $filename, $input, $samples = [], $targets = [];

    public function __construct($filename, $input)
    {
        $this->filename = $filename;
        $this->input = $input;
    }

    public function predictResult()
    {
        // $this->readFile();
        // $model = new RandomForest(new classificationTree(10), 300, 0.1, true);

        // $dataset = new Labeled($this->samples, $this->targets);
        // info($dataset);
    }

    public function readFile()
    {
        $file = fopen($this->filename, 'r');
    }
}
