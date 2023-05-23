<?php

$databaseCreation = 'database_creation.sql';
$databaseData = 'database_initial_data.sql';
$matchingFiles = glob('*/*');

$matchingFiles = array_merge([ $databaseCreation ], $matchingFiles);
$matchingFiles = array_merge($matchingFiles, [ $databaseData ]);

$outputFile = 'cursotopia.sql';

// Leer el contenido de los archivos y concatenarlos
$combinedContent = '';
foreach ($matchingFiles as $file) {
    $content = file_get_contents($file);
    $combinedContent .= $content;
}

// Guardar el contenido combinado en un nuevo archivo
file_put_contents($outputFile, $combinedContent);

// Leer el contenido del archivo combinado
$combinedContent = file_get_contents($outputFile);

// Eliminar las primeras 5 líneas del archivo combinado
$lines = explode("\n", $combinedContent);
$modifiedContent = implode("\n", array_slice($lines, 5));

// Guardar el contenido modificado en el archivo combinado
file_put_contents($outputFile, $modifiedContent);

echo "Archivos combinados y modificados exitosamente.\n";
