<?php
// 3.1
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height = (";
$indeks_akhir = array_key_last($height);
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '"';
    if ($nama != $indeks_akhir) { echo ", "; }
}
echo ")<br>";
echo "Nilai dengan indeks terakhir: " . $height[$indeks_akhir] . "<br><br>";

unset($height["Barry"]);

echo "height = (";
$indeks_akhir_baru = array_key_last($height);
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '"';
    if ($nama != $indeks_akhir_baru) { echo ", "; }
}
echo ")<br>";
echo "Nilai dengan indeks terakhir setelah dihapus: " . $height[$indeks_akhir_baru] . "<br><br>";

// 3.2
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

echo "weight = (";
$indeks_akhir_weight = array_key_last($weight);
foreach ($weight as $nama => $berat) {
    echo '"' . $nama . '"=>"' . $berat . '"';
    if ($nama != $indeks_akhir_weight) { echo ", "; }
}
echo ")<br>";

$data_kedua = array_values($weight);
echo "Data kedua: " . $data_kedua[1] . "<br>";
?>