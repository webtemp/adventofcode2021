<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');
  while (!$file->eof()) {
    $data[] = explode(' ', $file->fgets());
  }

  $file = null;

  return $data;
}

function solve($data) {
  $depth = $pos = 0;

  foreach ($data as $instruction) {
    match ($instruction[0]) {
      'forward' => $pos += $instruction[1],
      'backward' => $pos -= $instruction[1],
      'down' => $depth += $instruction[1],
      'up' => $depth -= $instruction[1],
    };
  }

  return $depth * $pos;
}

echo solve(readData()) . PHP_EOL;