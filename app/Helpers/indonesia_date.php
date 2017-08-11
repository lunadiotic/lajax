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