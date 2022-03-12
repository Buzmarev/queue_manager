<?php

namespace App\Buzmarev\QueueManagerBundle\Entity;

use App\Buzmarev\QueueManagerBundle\Repository\QueueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QueueRepository::class)
 */
class Queue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $status_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $task_class;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusId(): ?Status
    {
        return $this->status_id;
    }

    public function setStatusId(?Status $status_id): self
    {
        $this->status_id = $status_id;

        return $this;
    }

    public function getTaskClass(): ?string
    {
        return $this->task_class;
    }
    
    public function getTaskName(): ?string
    {
        return $this->task_class::taskName;
    }

    public function setTaskClass(string $task_class): self
    {
        $this->task_class = $task_class;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(?\DateTimeInterface $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(?\DateTimeInterface $end_at): self
    {
        $this->end_at = $end_at;

        return $this;
    }
}
