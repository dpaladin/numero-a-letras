<?php
/**
 * Clase que implementa un coversor de números
 * a letras.
 *
 * Soporte para PHP >= 5.4
 * Para soportar PHP 5.3, declare los arreglos
 * con la función array.
 *
 * @author AxiaCore S.A.S
 *
 */

class NumeroALetras
{
    private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
    ];

    private static $DECENAS = [
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
    ];

    private static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
    ];
    private static $OTROS = [
        '', 'MILLON', 'BILLON', 'TRILLON', 'CUATRILLON', 'QUINTILLON', 'SEXTILLON', 'SEPTILLON', 'OCTILLON'
    ];

    public static function convertir($number, $moneda = '', $centimos = '', $forzarCentimos = false)
    {
        $converted = '';
        $decimales = '';
        $number = (string) $number;
        
        $negativo = '';
        if ($number[0] == '-') {
            $negativo = 'MENOS ';
            $number = substr($number, 1);
        }

        $number = trim($number, '0');
        $div_decimales = explode('.', $number);
        $number = $div_decimales[0];

        $decimales = self::convertDecimales($div_decimales[1] ?? '', $forzarCentimos);
        $number = str_pad($number, ceil(strlen($number) / 6) * 6, '0', STR_PAD_LEFT);
        $i = 0;
        while (strlen($number)) {
            $strMil = substr($number, -6, 6);
            $number = substr($number, 0, -6);
            $n = intval($strMil);
            if ($n > 0) {
                if ($i == 0) {
                    $converted = self::convertMiles($strMil);
                } else {
                    $converted = sprintf('%s ', self::convertMiles($strMil) . self::$OTROS[$i] . ($n > 1 ? 'ES' : '')) . $converted;
                }
            }
            $i++;
        }

        if ($converted == '') {
            $converted = 'CERO ';
        }

        if(empty($decimales)){
            $valor_convertido = $converted . strtoupper($moneda);
        } else {
            $valor_convertido = $converted . strtoupper($moneda) . ' CON ' . $decimales . strtoupper($centimos);
        }

        return $valor_convertido;
    }
    private static function convertDecimales($n, $forzarCentimos)
    {
        $n = str_pad($n, 2, '0');
        $n = substr($n, 0, 2);
        $n = str_pad($n, 3, '0', STR_PAD_LEFT);
        if (intval($n) == 0 && $forzarCentimos) {
            return 'CERO ';
        } else {
            return self::convertCientos($n);
        }
    }
    private static function convertMiles($n)
    {
        $output = '';
        $miles = substr($n, 0, 3);
        $cientos = substr($n, 3);

        if (intval($miles) > 0) {
            if ($miles == '001') {
                $output .= 'MIL ';
            } else if (intval($miles) > 0) {
                $output .= sprintf('%sMIL ', self::convertCientos($miles));
            }
        }

        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $output .= 'UN ';
            } else if (intval($cientos) > 0) {
                $output .= sprintf('%s', self::convertCientos($cientos));
            }
        }
        return $output;
    }
    private static function convertCientos($n)
    {
        $output = '';

        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }

        $k = intval(substr($n, 1));

        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if($n[2] !== '0') {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }

        return $output;
    }
}