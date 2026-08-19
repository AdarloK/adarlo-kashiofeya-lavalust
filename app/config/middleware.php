<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 4
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

require_once SYSTEM_DIR . 'kernel/Middleware.php';

require_once APP_DIR . 'middlewares/StudentMiddleware.php';

$config['middlewares'] = [
    'StudentMiddleware' => new StudentMiddleware(),
];
