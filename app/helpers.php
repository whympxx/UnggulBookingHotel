<?php

if (! function_exists('rupiah')) {
    /** Format angka ke Rupiah, contoh: 688750 -> "Rp. 688.750". */
    function rupiah(int|float|null $amount): string
    {
        return 'Rp. '.number_format((float) $amount, 0, ',', '.');
    }
}
