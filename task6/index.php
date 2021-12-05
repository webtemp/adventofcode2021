<?php

function readData() {
  $data = [];

  $file = new SplFileObject('test.in');
  while (!$file->eof()) {
    $data[] = str_split(preg_replace('/\s+/', '', $file->fgets()));
  }

  $file = null;

  return $data;
}

function filterItems($data, $pos, $value) {
  $filter = [];

  foreach($data as $item) {
    if($item[$pos] == $value) {
      $filter[] = $item;
    }
  }

  return $filter;
}

function countItems($data, $pos, $oxygen = true) {
  $zeros = $onse = 0;
  $len = count($data[0]);

  foreach($data as $item) { 
    if ($item[$pos] == 0) {
      $zeros++;
    }
    else {
      $onse++;
    }
  }

  if ($oxygen) {
    return ($onse >= $zeros) ? 1 : 0;
  }

  // CO2
  return ($zeros <= $onse ) ? 0 : 1;
}

function solve($data) {
  $set = [];
  $CO2 = $oxygen = 0;
  $len = count($data[0]);

  for ($i=0; $i < $len; $i++) { 
    $set[$i] = [0 => 0, 1 => 0];
  }

  $oCopy = $data;
  $cCopy = $data;
  $pos = 0;
  $oValue = $cValue = 0;
  do {
    $oValue = countItems($oCopy, $pos, 1);
    $oCopy = filterItems($oCopy, $pos, $oValue);

    $pos++;

    if ($pos > $len) { // Loop over
      $pos = 0;
    }
  } while(count($oCopy) > 1);

  $pos = 0;
  do {
    $cValue = countItems($cCopy, $pos, 0);
    $cCopy = filterItems($cCopy, $pos, $cValue);

    $pos++;

    if ($pos > $len) { // Loop over
      $pos = 0;
    }
  } while(count($cCopy) > 1);


  echo 'Oxygen Copy: ';var_export($oCopy);
  echo 'CO2 Copy: ';var_export($cCopy);

  $CO2 = bindec(implode('', $cCopy[0]));
  $oxygen = bindec(implode('', $oCopy[0]));

  return $CO2 * $oxygen;
}

echo PHP_EOL . 'Answer: ' . solve(readData()) . PHP_EOL;
