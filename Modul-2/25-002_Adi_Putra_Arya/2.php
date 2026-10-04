<?php
$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];

foreach ($matkul as $mk) {
    switch ($mk) {
        case "PTI":
        case "ALPRO":
        case "DPW":
        case "STRUKDAT":
        case "JARKOM":
        case "PAW":
            echo "Saya suka " . $mk . "<br>";
            break;
        default:
            echo "Saya tidak mengambil matkul " . $mk . "<br>";
            break;
    }
}
?>