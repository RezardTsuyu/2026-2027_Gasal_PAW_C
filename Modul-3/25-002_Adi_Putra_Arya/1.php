<?php
// 1.1
$fruits = array("Avocado", "Blueberry", "Cherry");
$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo 'fruits = (';
for ($i = 0; $i < count($fruits); $i++) {
    echo '"' . $fruits[$i] . '"';
    if ($i < count($fruits) - 1) { 
        echo ', '; 
    }
}
echo ')<br>';
echo "Nilai dengan indeks tertinggi: " . $fruits[array_key_last($fruits)] . "<br><br>";

// 1.2 
unset($fruits[1]);

echo "Data Blueberry dihapus.<br>";
echo 'fruits = (';
$indeks_terakhir = array_key_last($fruits);
foreach ($fruits as $f => $value) {
    echo '"' . $value . '"';
    if ($f != $indeks_terakhir) { 
        echo ', '; 
    }
}
echo ')<br>';
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeks_terakhir] . "<br>";
?>