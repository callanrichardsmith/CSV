<?php

$names =    [
    'Bill', 
    'John', 
    'Gary', 
    'Michael', 
    'Johan', 
    'Alan', 
    'Geoff', 
    'William', 
    'Archie', 
    'Bismarck', 
    'Henry', 
    'Lancelot', 
    'Sebastian', 
    'Cale', 
    'Jacques', 
    'Luke', 
    'Paul', 
    'Moses', 
    'Ziba', 
    'Thando'
];

$surnames = [
    'Johnson',
    'Smith',
    'Williams',
    'Brown',
    'Taylor',
    'Miller',
    'Wilson',
    'Moore',
    'Anderson',
    'Thomas',
    'Jackson',
    'White',
    'Harris',
    'Martin',
    'Thompson',
    'Garcia',
    'Martinez',
    'Robinson',
    'Clark',
    'Rodriguez'
];

$batch_size = 10000;

function create_csv($num_records, $batch_size) {
    global $names, $surnames;
    $data = [];
    $file = fopen('./output/output.csv', 'w');
    fputcsv($file, ['Id', 'Name', 'Surname', 'Initials', 'Age', 'DateOfBirth']);
    for ($i = 0; $i < $num_records; $i++) {
        $name = $names[array_rand($names)];
        $surname = $surnames[array_rand($surnames)];
        $age = rand(20, 60);
        $dob = date('d/m/Y', strtotime("-$age years"));
        $data[] = [$i+1, $name, $surname, $name[0], $age, $dob];
        if (($i+1) % $batch_size == 0 || $i+1 == $num_records) {
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            $data = []; 
        }
    }
    fclose($file);
}

if (isset($_POST['submit'])) {
    create_csv($_POST['num_records'], $batch_size);
    $num_records = '';
}

if (file_exists("./output/output.csv")) {
    $db = new SQLite3('./test.db');
    $db->exec('CREATE TABLE IF NOT EXISTS csv_import (Id INTEGER, Name TEXT, Surname TEXT, Initials TEXT, Age INTEGER, DateOfBirth TEXT)');
    $file = fopen('./output/output.csv', 'r');
    fgetcsv($file);
    $data = [];
    while (($row = fgetcsv($file)) !== FALSE) {
        $data[] = "('$row[0]', '$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]')";
        if (count($data) == $batch_size) {
            $db->exec("INSERT INTO csv_import (Id, Name, Surname, Initials, Age, DateOfBirth) VALUES " . implode(',', $data));
            $data = [];
        }
    }
    if (!empty($data)) {
        $db->exec("INSERT INTO csv_import (Id, Name, Surname, Initials, Age, DateOfBirth) VALUES " . implode(',', $data));
    }
    fclose($file);
    $result = $db->query('SELECT COUNT(*) AS count FROM csv_import');
    $row = $result->fetchArray();
    echo "Imported {$row['count']} records.";
}
?>

<form method="post">
    <label for="num_records">Number of records:</label>
    <input type="number" id="num_records" name="num_records" min="1" required>
    <br>
    <input name="submit" type="submit" value="Submit">
</form>
