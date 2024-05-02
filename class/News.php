<?php

namespace Database\classes;

use DateTimeImmutable;

class News
{
    // Private variables
    private int $id;
    private string $title;
    private string $body;
    private DateTimeImmutable $createdAt;

    // Sets the ID property of the News
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    // Sets the Title property of the News
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    // Sets the Body property of the News
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    // Sets the CreatedAt property of the News
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    // Gets the ID property of the News
    public function getId(): int
    {
        return $this->id;
    }

    // Gets the Title property of the News
    public function getTitle(): string
    {
        return $this->title;
    }

    // Gets the Body property of the News
    public function getBody(): string
    {
        return $this->body;
    }

    // Gets the CreatedAt property of the News
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}