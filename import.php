<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['csvFile']['name']);

    if (move_uploaded_file($_FILES['csvFile']['tmp_name'], $uploadFile)) {
        // Read CSV file and import data into SQLite database
        $csvData = array_map('str_getcsv', file($uploadFile));
        error_log('$_FILES: ' . json_encode($_FILES));
        error_log('Debug information: ' . json_encode(['count' => count($csvData) - 1]));

        // ... Perform SQLite import logic

        $db = new SQLite3('csv_import_data.db');

        // Create the 'basic_details' table if it doesn't exist
        $tableName = 'csv_import_data';
        $db->exec("DELETE FROM $tableName");
        $db->exec('CREATE TABLE IF NOT EXISTS csv_import_data (Name TEXT, Surname TEXT, Initial TEXT, Age INTEGER, BirthDate DATE)');
        $csvPath = 'output.csv';
        // Open the CSV file for reading
        $csvFile = fopen($csvPath, 'r');

        // Prepare the INSERT statement
        $stmt = $db->prepare("INSERT INTO csv_import_data (Name, Surname, Initial, Age, BirthDate) VALUES (:name, :surname, :initial, :age, :birthdate)");

        while (($row = fgetcsv($csvFile)) !== false) {
            // Bind parameters and execute the statement
            $stmt->bindValue(':name', $row[0], SQLITE3_TEXT);
            $stmt->bindValue(':surname', $row[1], SQLITE3_TEXT);
            $stmt->bindValue(':initial', $row[2], SQLITE3_TEXT);
            $stmt->bindValue(':age', $row[3], SQLITE3_INTEGER);
            $stmt->bindValue(':birthdate', $row[4], SQLITE3_TEXT); // Assuming BirthDate is a string in the CSV

            $stmt->execute();
        }

        // Close the CSV file
        fclose($csvFile);

        // Close the database connection
        $db->close();

        $response = ['count' => count($csvData) - 1];
        error_log('Debug information: ' . json_encode(['count' => count($csvData) - 1]));

        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'File upload failed.']);
    }
}
?>
