<?php
// 4.1
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170", "David"=>"180", "Ethan"=>"172", "Frank"=>"168", "George"=>"175", "Harry"=>"182");

echo "height = (";
$indeks_akhir = array_key_last($height);
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '"';
    if ($nama != $indeks_akhir) { echo ", "; }
}
echo ")<br>";

foreach($height as $nama => $tinggi) {
    echo "$nama is $tinggi cm tall.<br>";
}
echo "<br>";

// 4.2
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

echo "weight = (";
$indeks_akhir_weight = array_key_last($weight);
foreach ($weight as $nama => $berat) {
    echo '"' . $nama . '"=>"' . $berat . '"';
    if ($nama !== $indeks_akhir_weight) { echo ", "; }
}
echo ")<br>";

$keys = array_keys($weight); 
$jumlah_data = count($keys);

for ($i = 0; $i < $jumlah_data; $i++) {
    $nama = $keys[$i];
    echo "$nama is " . $weight[$nama] . " kg.<br>";
}
?>