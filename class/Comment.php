<?php

namespace Database\class;

use DateTimeImmutable;

class Comment
{
    // Private variables
    private int $id;
    private string $body;
    private DateTimeImmutable $createdAt;
    private int $newsId;

    /**
     * Sets the ID property of the Comment
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets the Body property of the Comment
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Sets the CreatedAt property of the Comment
     * @param DateTimeImmutable $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Sets the NewsID property of the Comment
     * @param int $newsId
     * @return $this
     */
    public function setNewsId(int $newsId): self
    {
        $this->newsId = $newsId;

        return $this;
    }

    /**
     * Gets the ID property of the Comment
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the Body property of the Comment
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Gets the CreatedAt property of the Comment
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Gets the NewsID property of the Comment
     * @return int
     */
    public function getNewsId(): int
    {
        return $this->newsId;
    }
}