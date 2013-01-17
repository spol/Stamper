#!/usr/bin/env php
<?php

$srcRoot = __DIR__ . '/src';
$buildRoot = __DIR__ . '/build';

$phar = new Phar($buildRoot . '/stamper.phar',
	FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, "stamper.phar");

$phar->buildFromDirectory($srcRoot);

$phar->setStub(file_get_contents($srcRoot . '/stub.php'));