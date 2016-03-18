<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "routes.php";

$name = '404';
$content = '';

$params = array();


foreach ($routes as $map)
{
    $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

	if (preg_match($map['pattern'], $url_path, $matches))
	{
		array_shift($matches);
 		foreach ($matches as $index => $value)
		{
			$params[$map['aliases'][$index]] = $value;
		}

		$name = $map['name'];
		$content = $map['content'];
		break;
	}
}

?>