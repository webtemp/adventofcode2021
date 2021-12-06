<?php

function readData() {
  $data = '';

  $file = new SplFileObject('test.in');
  $i = 0;

  $maxX = $maxY = 0;
  while (!$file->eof()) {
    $data = explode(',', trim($file->fgets()));
  }

  $file = null;
  return $data;
}

function solve($data) {

  for ($i=0; $i < 80; $i++) {
    $toAdd = 0;

    foreach ($data as $key => $value) {
      $data[$key]--;
      if ($data[$key] < 0) {
        $data[$key] = 6;
        $toAdd++;
      }
    }

    if ($toAdd > 0) {
      for ($j=0; $j < $toAdd; $j++) { 
        $data[] = 8;
      }
    }
  }

  return count($data);
}

echo PHP_EOL . 'Answer: ' . solve(readData()) . PHP_EOL;
