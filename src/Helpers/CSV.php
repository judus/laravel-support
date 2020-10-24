<?php

namespace Maduser\Laravel\Support\Helpers;

/**
 * Class CSV
 *
 * Helps doing things with CSV
 *
 * @package Maduser\Laravel\Helpers
 */
class CSV
{
    /**
     * Create a CSV file from a two-dimensional array
     *
     * @param array  $data
     * @param string $delimiter
     *
     * @return string
     */
    public static function create(array $data, $delimiter = null)
    {
        $delimiter = $delimiter ?: ',';

        $fh = fopen('php://temp', 'rw');
        fputs($fh, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

        fputcsv($fh, array_keys(current($data)), $delimiter);

        foreach ($data as $row) {
            fputcsv($fh, $row, $delimiter);
        }

        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $csv;
    }
}
