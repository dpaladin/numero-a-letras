# Numero A Letras

Convierte un número a su valor correspondiente en letras.

## Instalación

Agrega `arielcr/numero-a-letras` a tu archivo composer.json.

    {
        "require": {
            "arielcr/numero-a-letras": "dev-master"
        }
    }

## Uso

        $letras = NumeroALetras::convertir(12345);
        
Si deseas convertir un número con decimales y mostrar la moneda:

        $letras = NumeroALetras::convertir(12345.67, 'colones', 'centimos');
        
Lo cual te devuelve: *DOCE MIL TRESCIENTOS CUARENTA Y CINCO COLONES CON SESENTA Y SIETE CENTIMOS*



		$letras = NumeroALetras::convertir('99999999999999.9999', 'pesos', 'centavos');
		
Devuelve: *NOVENTA Y NUEVE BILLONES NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS CON NOVENTA Y NUEVE CENTAVOS*

## Créditos

Basado en la clase para PHP [AxiaCore/numero-a-letras](https://github.com/AxiaCore/numero-a-letras/blob/master/php/NumberToLetterConverter.class.php)

