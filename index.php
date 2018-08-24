<?php

/**
 * Tested down to PHP 5.4
 * This needs work.
 * This is a framework for small websites.
 *
 */

require __DIR__ . '/vendor/autoload.php';

const DEBUG = true;
const INSTALLATION_DIRECTORY = '/napolean';

if (DEBUG === true) {
  error_reporting(E_ALL); 
  ini_set('display_errors', 1); 
}

use Scsmktng\Napolean\Application as App;

$request = $_SERVER['REQUEST_URI'];
$request = str_replace(INSTALLATION_DIRECTORY, '', $request);
$request = $request !== '/' ? rtrim($request, '/') : '/';

$app = new App(INSTALLATION_DIRECTORY);

switch ($request) {

  case '/' :
    $app->renderPage('home');
    break;

  default: 
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
    $app->renderPage('404');
    break;

}