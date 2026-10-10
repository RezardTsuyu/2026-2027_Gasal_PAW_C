<?php
// 6.1
$arr1 = array("A");
array_push($arr1, "B");
echo 'Array awal: ("A")<br>';
echo 'Hasil array_push: ';
foreach($arr1 as $val) { echo $val . " "; }
echo '<br><br>';

$merged = array_merge(array("A", "B"), array("C"));
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo 'Hasil array_merge: ';
foreach($merged as $val) { echo $val . " "; }
echo '<br><br>';

$vals = array_values(array("x"=>1, "y"=>2));
echo 'Array awal: ("x"=>1, "y"=>2)<br>';
echo 'Hasil array_values: ';
foreach($vals as $val) { echo $val; }
echo '<br><br>';

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo 'Hasil array_search: ' . array_search("B", array("A", "B", "C")) . '<br><br>';

$filtered = array_filter(array(0, 1, false, 2, "", 3, "array"));
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo 'Hasil array_filter: ';
foreach($filtered as $val) { echo $val . " "; }
echo '<br><br>';

$arr_sort = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
sort($arr_sort);
echo 'Hasil sort: '; foreach($arr_sort as $val) { echo $val; } echo '<br>';
rsort($arr_sort);
echo 'Hasil rsort: '; foreach($arr_sort as $val) { echo $val; } echo '<br><br>';

$arr_asort = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';
asort($arr_asort);
echo 'Hasil asort: '; foreach($arr_asort as $k=>$v) { echo "$k=>$v, "; } echo "<br>";
ksort($arr_asort);
echo 'Hasil ksort: '; foreach($arr_asort as $k=>$v) { echo "$k=>$v, "; } echo "<br>";
arsort($arr_asort);
echo 'Hasil arsort: '; foreach($arr_asort as $k=>$v) { echo "$k=>$v, "; } echo "<br>";
krsort($arr_asort);
echo 'Hasil krsort: '; foreach($arr_asort as $k=>$v) { echo "$k=>$v, "; } echo "<br>";
?>