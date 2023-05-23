<?php

$expectedDirectory = __DIR__;

if (getcwd() !== $expectedDirectory) {
    die('Error: This script can only be executed from the "database" folder.');
}

$databaseCreation = "database_creation.sql";
$databaseData = "database_initial_data.sql";
$matchingFiles = glob("*/*");

$matchingFiles = array_merge([ $databaseCreation ], $matchingFiles);
$matchingFiles = array_merge($matchingFiles, [ $databaseData ]);

$outputFile = "cursotopia.sql";

$combinedContent = '';
foreach ($matchingFiles as $file) {
    $content = file_get_contents($file);
    $combinedContent .= $content;
}

file_put_contents($outputFile, $combinedContent);

$combinedContent = file_get_contents($outputFile);

$lines = explode("\n", $combinedContent);
$modifiedContent = implode("\n", array_slice($lines, 0));

file_put_contents($outputFile, $modifiedContent);

echo "Cursotopia.sql was created successfully.\n";
