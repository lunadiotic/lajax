<?php
    function indoDate($getDate, $getDay = true) {
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei',
            'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $year = substr($getDate, 0, 4);
        $month = $months[(int)substr($getDate,5,2)];
        $date = substr($getDate, 8,2);

        $text = "";

        if ($getDay) {
            $order_days = date('w',
                mktime(0,0,0, substr($getDate, 5 ,2), $date, $year)
            );

            $day = $days[$order_days];
            $text .= $day.", ";
        }

        $text .= $date . ' ' . $month . ' ' . $year;

        return $text;
    }

    function indoCurrency($number) {
        $result = number_format($number,0,',','.');
        return $result;
    }

    function indoSpellNumber($number) {
        $number = abs($number);
        $spell = [
            "", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sebelas"
        ];

        $spellOut = "";

        if ($number < 12) {
            $spellOut = " " .  $spell[$number];
        } elseif ($number < 20) {
            $spellOut = indoSpellNumber($number - 10) . " belas";
        } elseif ($number < 100) {
            $spellOut = indoSpellNumber($number / 10) . " puluh" . indoSpellNumber($number % 10);
        } elseif ($number < 200) {
            $spellOut = " seratus" . indoSpellNumber($number - 100);
        } elseif ($number < 1000) {
            $spellOut = indoSpellNumber($number / 100) . " ratus" . indoSpellNumber($number % 100);
        } elseif ($number < 2000) {
            $spellOut = " seribu" . indoSpellNumber($number - 1000);
        } elseif ($number < 1000000) {
            $spellOut = indoSpellNumber($number / 1000) . " ribu" . indoSpellNumber($number % 1000);
        } elseif ($number < 1000000000) {
            $spellOut = indoSpellNumber($number / 1000000) . " juta" . indoSpellNumber($number % 1000000);
        }

        return $spellOut;
    }