<?php
/**
 * Generated by "Autoload generator"
 * @link http://github.com/dmkuznetsov/php-autoloader
 * @date 2013-11-16 15:38
 */
function __dm_autoload_geo( $name )
{
	$map = array (
  'Yandex\\Geo\\Api' => 'Geo/Api.php',
  'Yandex\\Geo\\Exception' => 'Geo/Exception.php',
  'Yandex\\Geo\\Exception\\CurlError' => 'Geo/Exception/CurlError.php',
  'Yandex\\Geo\\Exception\\ServerError' => 'Geo/Exception/ServerError.php',
  'Yandex\\Geo\\GeoObject' => 'Geo/GeoObject.php',
  'Yandex\\Geo\\Response' => 'Geo/Response.php',
);
	if ( isset( $map[ $name ] ) )
	{
		require $map[ $name ];
	}
}
spl_autoload_register( '__dm_autoload_geo' );