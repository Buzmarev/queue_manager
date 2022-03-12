<?php

namespace App\Buzmarev\QueueManagerBundle\Controller;

use App\Buzmarev\QueueManagerBundle\Entity\Status;
use App\Buzmarev\QueueManagerBundle\Entity\Queue;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QueueController extends AbstractController
{
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $statuses = $doctrine->getRepository(Status::class)->findAll();
        $queues = $doctrine->getRepository(Queue::class)->findBy(
            [
                'status_id' => $request->request->get('filter')
            ]
        );
        return $this->render('@QueueManager/queue.html.twig', [
            'statuses' => $statuses,
            'queues' => $queues
        ]);
    }
}

