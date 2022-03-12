<?php

namespace App\Buzmarev\QueueManagerBundle\Controller;

use App\Buzmarev\QueueManagerBundle\Entity\Status;
use App\Buzmarev\QueueManagerBundle\Entity\Queue;
use App\Buzmarev\QueueManagerBundle\Tasks\Task\Task1;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Task1Controller extends AbstractController
{
    public function index(): Response
    {
        return $this->render('@QueueManager/task_1.html.twig', [
            'task_name' => Task1::taskName
        ]);
    }
    
    public function launch(Request $request, ManagerRegistry $doctrine): Response
    {
        $qnt = $request->request->get('qnt');
        
        $entityManager = $doctrine->getManager();
        $status = $doctrine->getRepository(Status::class)->find(Status::PENDING);

        for ($i=0; $i < $qnt; $i++) {
            $queue = new Queue();
            $queue->setStatusId($status);
            $queue->setTaskClass(Task1::class);
            $queue->setCreatedAt(new \DateTimeImmutable('now'));

            $entityManager->persist($queue);
        }
        $entityManager->flush();
        
        return $this->redirectToRoute(
            'task_1_page',
            [
                'task_name' => Task1::taskName
            ]
        );
    }
}

