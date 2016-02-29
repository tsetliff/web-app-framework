<?php
require_once ('config.php');
require_once(APP_LOCATION . "/init.php");
(new TSetliff\WebAppFramework\Kernel())->route();