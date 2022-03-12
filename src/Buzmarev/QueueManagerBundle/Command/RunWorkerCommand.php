<?php

namespace App\Buzmarev\QueueManagerBundle\Command;

use App\Buzmarev\QueueManagerBundle\Entity\Status;
use App\Buzmarev\QueueManagerBundle\Entity\Queue;
use App\Buzmarev\QueueManagerBundle\Tasks\TaskInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunWorkerCommand extends Command
{
    protected static $defaultName = 'buzmarev:run-worker';
    
    /** @var LoggerInterface */
    protected $logger;
    
    /** @var ManagerRegistry */
    protected $doctrine;

    public function __construct(
        LoggerInterface $logger,
        ManagerRegistry $doctrine
    )
    {
        parent::__construct();
        
        $this->logger = $logger;
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Run worker.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        do {
            try {
                
                $queue = $this->getNextQueue();
                if (!$queue) {
                    sleep(5);
                    continue;
                }
                $class = $queue->getTaskClass();
                $task = new $class();
                if ($task instanceof TaskInterface) {
                    $queue->setStartAt(new \DateTime('now'));
                    $this->updateQueue($queue);
                    
                    $output->writeln("<info>Execute task</info>");
                    $task->init($this->logger);
                    $output->writeln("<info>finish task</info>");
                    $queue->setStatusId($this->getStatus(Status::SUCCESS));
                    $queue->setEndAt(new \DateTime('now'));
                    $this->updateQueue($queue);
                } else {
                    $message = "Класс '{$class}' не является таской";
                    $this->logger->error($message);
                    
                    $queue->setStatusId($this->getStatus(Status::FAILED));
                    $queue->setEndAt(new \DateTime('now'));
                    $this->updateQueue($queue);
                    
                    throw new \Exception($message);
                }
            } catch (\Exception $ex) {
                $output->writeln("<error>{$ex->getMessage()}</error>");
            }
        } while (true);
    }
    
    protected function getNextQueue()
    {
        $queue = $this->doctrine->getRepository(Queue::class)->findOneBy(
            [
                'status_id' => Status::PENDING
            ]
        );
        
        return $queue;
    }
    
    protected function updateQueue($queue)
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($queue);
        $entityManager->flush();
    }
    
    protected function getStatus($id)
    {
        return $this->doctrine->getRepository(Status::class)->find($id);
    }
}

