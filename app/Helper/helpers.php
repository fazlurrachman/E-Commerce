<?php

if (! function_exists('setActive')) {

    /**
     * setActive
     *
     * @param  mixed  $path
     * @return void
     */
    function setActive($path)
    {
        return Request::is($path) ? 'active open' : '';
    }
}

if (! function_exists('moneyFormat')) {
    /**
     * moneyFormat
     *
     * @param  mixed  $str
     * @return void
     */
    function moneyFormat($str)
    {
        $nominal = str_replace('.', '', $str ?? 0);

        return 'Rp. '.number_format($nominal, '0', '', '.');
    }
}

if (! function_exists('dateID')) {
    /**
     * dateID
     *
     * @param  mixed  $tanggal
     * @return void
     */
    function dateID($tanggal)
    {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');

        return $parse->translatedFormat('l, d F Y');
    }
}
