<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');

  while (!$file->eof()) {
    $data = explode(',', trim($file->fgets()));
  }

  $file = null;
  return $data;
}
function solve($data) {
  sort($data);
  $count = count($data)-1;
  $halfCount = $count / 2;
  $sum = array_sum($data);

  $median = $count % 2 == 0 ? ($data[$halfCount] + $data[$halfCount+1]) / 2 : $data[ceil($halfCount)];

  $sum = 0;
  foreach ($data as $pos) {
    $sum += abs($median - $pos);
  }

  return $sum;
}

echo PHP_EOL . 'Answer: ' . solve(readData()) . PHP_EOL;
