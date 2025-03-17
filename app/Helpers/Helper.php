<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        return "Rp. " . number_format($angka, 0, decimal_separator: ',', thousands_separator: '.');
    }
}






?>