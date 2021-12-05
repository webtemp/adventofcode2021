<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');
  while (!$file->eof()) {
    $data[] = explode(' ', trim($file->fgets()));
  }

  $file = null;

  return $data;
}

function solve($data) {
  $depth = $pos = $aim = 0;

  foreach ($data as $instruction) {
    switch ($instruction[0]) {
      case 'forward':
        $pos += $instruction[1];
        $depth += $instruction[1] * $aim;
      break;
      case 'down':
        $aim += $instruction[1];
      break;
      case 'up':
        $aim -= $instruction[1];
      break;
    };
  }

  return $depth * $pos;
}

echo solve(readData()) . PHP_EOL;
