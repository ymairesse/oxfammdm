<?php

session_start();

require_once '../config.inc.php';

require_once 'entetes.inc.php';

session_destroy();

header('Location: ../index.php');
