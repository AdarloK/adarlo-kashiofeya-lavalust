<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/
/** @var object $router **/


$router->get('/', 'StudentController::index');

$router->get('/student', 'StudentController::index');
$router->post('/student/verify', 'StudentController::verify');
$router->get('/student/lock', 'StudentController::lock');
$router->get('/student/profile', 'StudentController::profile')->middleware('StudentMiddleware');