<?php

namespace Database\class;

use DateTimeImmutable;

class News
{
    // Private variables
    private int $id;
    private string $title;
    private string $body;
    private DateTimeImmutable $createdAt;

    /**
     * Sets the ID property of the News
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the Title property of the News
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Sets the Body property of the News
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Sets the CreatedAt property of the News
     * @param DateTimeImmutable $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets the ID property of the News
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the Title property of the News
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Gets the Body property of the News
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Gets the CreatedAt property of the News
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}