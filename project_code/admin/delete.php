<?php
$command = 'rm /var/www/html/web/uploaded_files/POI.json';

// Execute the command
exec($command, $output, $returnVar);

// Check the output and return value
if ($returnVar === 0) {
    // Command executed successfully
    echo "Command executed successfully. Output:\n";
    echo implode("\n", $output);
} else {
    // Command execution failed
    echo "Command execution failed. Return value: $returnVar";
}
?>
