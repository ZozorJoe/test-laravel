<?php

use Carbon\Carbon;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertToDMY')) {
    function convertToDMY($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('convertToYmd')) {
    function convertToYmd($date)
    {
        # 13/03/2022
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }
}

/**
 * Calculer sous-total bloc
 *
 * @return response()
 */
if (!function_exists('sousTotalBloc')) {
    function sousTotalBloc($blocs)
    {
        $somme = 0;

        foreach ($blocs as $bloc) {
            $somme += $bloc->nominal * $bloc->quantite;
        }

        return $somme;
    }
}

/**
 * Calculer sous-total bloc
 *
 * @return response()
 */
if (!function_exists('Total')) {
    function total($billets, $pieces, $centiments)
    {
        return sousTotalBloc($billets) + sousTotalBloc($pieces) + sousTotalBloc($centiments);
    }
}


/**
 * Calculer Tableau
 *
 * @return response()
 */
if (!function_exists('totalTab')) {
    function totalTab($billet, $piece, $centiment)
    {
        return $billet + $piece + $centiment;
    }
}