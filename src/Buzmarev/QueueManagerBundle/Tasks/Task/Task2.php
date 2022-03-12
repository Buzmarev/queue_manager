<?php

namespace App\Buzmarev\QueueManagerBundle\Tasks\Task;

use App\Buzmarev\QueueManagerBundle\Tasks\AbstractTask;

class Task2 extends AbstractTask
{
    public const taskName = 'Task 2';
    
    protected function execute()
    {
        sleep(5);
    }
}