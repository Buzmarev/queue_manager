<?php

namespace App\Buzmarev\QueueManagerBundle\Controller;

use App\Buzmarev\QueueManagerBundle\Tasks\Task\Task1;
use App\Buzmarev\QueueManagerBundle\Tasks\Task\Task2;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QueueManagerController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('@QueueManager/index.html.twig', [
            'task_name_1' => Task1::taskName,
            'task_name_2' => Task2::taskName
        ]);
    }
}

