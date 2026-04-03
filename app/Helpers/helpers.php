<?php

use Carbon\Carbon; // Example of using a Laravel class within a helper

if (! function_exists('format_date')) {
    function format_date($date, $format = 'F j, Y')
    {
        return Carbon::parse($date)->format($format);
    }
}

if (! function_exists('custom_greeting')) {
    function custom_greeting($name)
    {
        return 'Hello, ' . $name . '!';
    }
}

if (! function_exists('current_url')) {
    function current_url()
    {
        $url = str_replace('/', '', $_SERVER['REQUEST_URI']);

        return $url;
    }
}

function checkActiveMenu($menuItem)
{
    // cek menu utama
    if (request()->is($menuItem->url) || request()->is($menuItem->url . '/*')) {
        return true;
    }

    // cek children jika ada
    if ($menuItem->children && $menuItem->children->count()) {
        foreach ($menuItem->children as $child) {
            if (checkActiveMenu($child)) {
                return true;
            }
        }
    }

    return false;
}

if (!function_exists('get_col')) {
    function get_col($row, $col, $start = null)
    {
        $col_name = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            'AA',
            'AB',
            'AC',
            'AD',
            'AE',
            'AF',
            'AG',
            'AH',
            'AI',
            'AJ',
            'AK',
            'AL',
            'AM',
            'AN',
            'AO',
            'AP',
            'AQ',
            'AR',
            'AS',
            'AT',
            'AU',
            'AV',
            'AW',
            'AX',
            'AY',
            'AZ',
            'BA',
            'BB',
            'BC',
            'BD',
            'BE',
            'BF',
            'BG',
            'BH',
            'BI',
            'BJ',
            'BK',
            'BL',
            'BM',
            'BN',
            'BO',
            'BP',
            'BQ',
            'BR',
            'BS',
            'BT',
            'BU',
            'BV',
            'BW',
            'BX',
            'BY',
            'BZ',
            'CA',
            'CB',
            'CC',
            'CD',
            'CE',
            'CF',
            'CG',
            'CH',
            'CI',
            'CJ',
            'CK',
            'CL',
            'CM',
            'CN',
            'CO',
            'CP',
            'CQ',
            'CR',
            'CS',
            'CT',
            'CU',
            'CV',
            'CW',
            'CX',
            'CY',
            'CZ'
        ];
        $colNumber = $col + ($start == null ? 0 : $start);
        $colNm = $col_name[$colNumber - 1] . $row;
        return $colNm;
    }
}

function getStyleCol()
{
    $style_col = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ]
    ];
    return $style_col;
}

function getStyleFooter()
{
    $style_col = [
        'font' => ['bold' => true],
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ]
    ];
    return $style_col;
}

function getStyleRow()
{
    $style_row = [
        'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ]
    ];
    return $style_row;
}

function getStyleRowRed()
{
    $style_col = [
        'font' => ['color' => array('argb' => 'FFFFFFFF')],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => array('argb' => 'FFFF0000')
        ]
    ];
    return $style_col;
}

function getStyleRowRight()
{
    $style_row = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ]
    ];
    return $style_row;
}

function getStyleFontHeader()
{
    $style_col = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ]
    ];
    return $style_col;
}

function getStyleFontHeaderGreen()
{
    $style_col = [
        'font' => ['bold' => true, 'color' => array('argb' => 'FFFFFFFF')],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => array('argb' => 'FF009900')
        ]
    ];
    return $style_col;
}

function getStyleFontHeaderBlue()
{
    $style_col = [
        'font' => ['bold' => true, 'size' => 30, 'color' => array('argb' => 'FF000000')],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => array('argb' => 'FFC2DBF2')
        ]
    ];
    return $style_col;
}

function getStyleFontHeaderTableBlue()
{
    $style_col = [
        'font' => ['bold' => true, 'color' => array('argb' => 'FF000000')],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => array('argb' => 'FFC2DBF2')
        ]
    ];
    return $style_col;
}

function getStyleFontHeaderLeft()
{
    $style_col = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
        ]
    ];
    return $style_col;
}

function getStyleFontTitleLeft()
{
    $style_col = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ]
    ];
    return $style_col;
}

function tl_status($status)
{
    if (substr($status, 0, 5) == 'BELUM') {
        return 'text-red';
    } elseif ($status == 'LENGKAP' || substr($status, 0, 5) == 'SUDAH') {
        return 'text-green';
    } else {
        return 'text-yellow';
    }
}

function nama_bulan($var)
{
    $bulan_arr = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    return $bulan_arr[$var - 1];
}


function printMsgTime($time)
{
    $waktuAwal = new DateTime($time);
    $waktuAkhir = new DateTime(now());

    $selisih = $waktuAwal->diff($waktuAkhir);

    // Konversi ke total menit: (jam * 60) + menit
    $totalMenit = ($selisih->days * 24 * 60) + ($selisih->h * 60) + $selisih->i;
    $totalMenit = ($selisih->days * 24 * 60) + ($selisih->h * 60) + $selisih->i;
    $totalJam = ($selisih->days * 24) + $selisih->h;
    $hasil = '';
    if ($totalMenit <= 5) {
        $hasil = 'Baru Saja';
    } elseif ($totalMenit <= 50) {
        $hasil = $totalMenit . ' menit yang lalu';
    } else {
        if ($totalJam < 24) {
            $hasil = $totalJam . ' jam yang lalu';
        } elseif ($totalJam <= 48) {
            $hasil = 'Kemarin';
        } else {
            if ($selisih->days <= 7) {
                $hasil = $selisih->days . ' hari yang lalu';
            } else {
                $hasil = format_date($time);
            }
        }
    }

    return $hasil;
}

function formatIndoPhone($value)
{
    $value_1 = str_replace([' ', '-'], '', $value);
    $value_2 = preg_replace('/[^0-9]/', '', $value_1);

    if (str_starts_with($value_2, '+628')) {
        return '08' . substr($value_2, 4);
    }

    if (str_starts_with($value_2, '628')) {
        return '08' . substr($value_2, 3);
    }

    if (str_starts_with($value_2, '62')) {
        return '0' . substr($value_2, 2);
    }

    return $value_2;
}

function validasiKabKota($kota)
{
    $value_1 = str_replace(['KABUPATEN ', 'KAB. ', 'Kabupaten ', 'Kab. '], '', $kota);
    if (substr($value_1, 0, 4) == 'KOTA') {
        return $value_1;
    } else {
        return 'KABUPATEN ' . $value_1;
    }
}
