<?php

namespace App\Buzmarev\QueueManagerBundle\Tasks;

use Psr\Log\LoggerInterface;

abstract class AbstractTask implements TaskInterface
{
    public const taskName = '';
    
    public function init(LoggerInterface $logger)
    {
        try {
            $logger->info("Задача {self::taskName} выполняется");
            $this->execute();
            $logger->info("Задача {self::taskName} выполнена");
        } catch (\Exception $ex) {
            $logger->error("Ошибка {$ex->getMessage()}");
            throw new \Exception($ex->getMessage());
        }
    }
    
    abstract protected function execute();
}

