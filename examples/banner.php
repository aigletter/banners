<?php

use Aigletter\TestTask\Repositories\DatabaseRepository;
use Aigletter\TestTask\Service;

require dirname(__DIR__) . '/vendor/autoload.php';

$repository = new DatabaseRepository('mysql:dbname=test_task;host=127.0.01', 'root', '1q2w3e');

$service = new Service($repository,);

$renderer = $service->show(__DIR__ . '/banner.jpg');

$renderer->render();