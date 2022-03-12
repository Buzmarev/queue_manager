<?php

namespace App\Buzmarev\QueueManagerBundle\Tasks\Task;

use App\Buzmarev\QueueManagerBundle\Tasks\AbstractTask;

class Task1 extends AbstractTask
{
    public const taskName = 'Task 1';
    
    protected function execute()
    {
        sleep(10);
    }
}