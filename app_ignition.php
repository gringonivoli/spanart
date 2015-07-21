<?php
/**
 * Script que arranca el motor.
 * 
 * @author Maxi Nivoli <maxi.nivoli@gmx.com>
 * @package SpanArt
 */

use SpanArt\SpanArt;
require "SpanArt.php";

$app = new SpanArt();
$app->run();