<?php
// Mengamankan teks sebelum dicetak ke HTML (mencegah XSS).
function e($nilai) {
	return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

// 24500 -> "Rp 24.500"
function rupiah($angka) {
	return "Rp " . number_format((int)$angka, 0, ",", ".");
}
?>
