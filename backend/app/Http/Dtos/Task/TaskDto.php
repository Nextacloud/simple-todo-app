<?php

namespace App\Http\Dtos\Task;

class TaskDto
{
    public function __construct(
        private string $title,
        private ?string $description = null,
    ) {}

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}

