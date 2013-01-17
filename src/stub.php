#!/usr/bin/env php
<?php

phar::mapPhar('stamper.phar');

phar::interceptFileFuncs();
require 'phar://stamper.phar/stamper.php';

__HALT_COMPILER();