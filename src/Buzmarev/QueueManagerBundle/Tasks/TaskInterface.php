<?php

namespace App\Buzmarev\QueueManagerBundle\Tasks;

use Psr\Log\LoggerInterface;

interface TaskInterface {
    public function init(LoggerInterface $logger);
}
