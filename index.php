<?php
// Function to generate random data and create CSV file
function generateCSV($variations) {
    $names = ['John', 'Jane', 'Robert', 'Emily', 'Michael', 'Emma', 'William', 'Olivia', 'James', 'Sophia', 'Daniel', 'Ava', 'Christopher', 'Isabella', 'Matthew', 'Mia', 'Andrew', 'Abigail', 'Ethan', 'Charlotte'];
    $surnames = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor', 'Anderson', 'Thomas', 'Jackson', 'White', 'Harris', 'Martin', 'Thompson', 'Garcia', 'Martinez', 'Robinson'];
    $csvFile = fopen('output.csv', 'w');
    fputcsv($csvFile, ['Name', 'Surname', 'Initial', 'Age', 'BirthDate']);
    $data = [];
    for ($i = 0; $i < $variations; $i++) {
        $name = $names[array_rand($names)];
        $surname = $surnames[array_rand($surnames)];
        $initial = strtoupper(substr($name, 0, 1));
        $age = rand(18, 60);
        $birthDate = date('Y-m-d', strtotime('-' . rand(18, 60) . ' years'));
        $data[] = [$name, $surname, $initial, $age, $birthDate];
    }
    // Shuffle data to avoid duplicates
    shuffle($data);
    // Write data to CSV file
    foreach ($data as $row) {
        fputcsv($csvFile, $row);
    }
    fclose($csvFile);
    return "CSV file generated successfully.";
}
// Handle CSV generation and database import
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['recordCount']) && is_numeric($_POST['recordCount'])) {
        $recordCount = (int)$_POST['recordCount'];
        $message = generateCSV($recordCount);
    } else {
        $message = "Invalid input.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Generator & CSV Import to SQLite database HTML Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center">
        <div class="card p-4">
            <div id="result" class="mt-4"><?php if (isset($message)) echo $message; ?></div>
            <h2 id="csv-generator-header" class="text-center mb-4">CSV Generator</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="recordCount" class="label-csv">Please enter number of records to be generated :</label>
                    <input type="number" class="form-control" id="recordCount" name="recordCount" placeholder="10,00,000" required>
                </div>
                <button type="submit" class="btn btn-primary btn-generate-csv btn-block">Generate CSV</button>
            </form>
            <hr class="my-4">
            <h2 class="text-center mb-4" style="color: blue;">CSV Importer</h2>
            <form id="csvForm" enctype="multipart/form-data">
                <div class="custom-file">
                    <label for="csvFile" class="custom-file-label" id="csvFileLabel">Choose a CSV file:</label>
                    <input type="file" class="custom-file-input" id="csvFile" name="csvFile" accept=".csv" required onchange="updateFileNameLabel()">
                </div>
                <button type="button" class="btn btn-secondary btn-import-csv btn-block" onclick="importCSV()">Import CSV</button>
            </form>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
        function updateFileNameLabel() {
            var fileName = document.getElementById("csvFile").files[0].name;
            document.getElementById("csvFileLabel").innerText = fileName;
        }
    </script>
</body>
</html>
