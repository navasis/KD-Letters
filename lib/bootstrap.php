<?php
/**
 * bootstrap.php
 * 
 * Bootstrapping file which launches and executes the plugin.
 *
 * @package     KD-Letters
 * @author      Romas Navašinskas
 * @copyright   2016 www.kaledudirbtuves.lt
 * @license     NONE
 */
$kdl = require_once __DIR__ . '/plugin/KD-Letters.php';
$kdl->dispatch();