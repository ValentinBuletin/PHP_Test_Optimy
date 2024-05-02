<?php

namespace Database\utils;

use Database\class\Comment;
use DateTimeImmutable;
use Exception;
use PDOException;
use const Database\ROOT;

class CommentManager
{
    // Private Variables
    private static mixed $instance = null;

    /**
     * Constructor validates the required files are present
     */
    public function __construct()
    {
        require_once(ROOT . "/utils/DB.php");
        require_once(ROOT . "/class/Comment.php");
    }

    /**
     * Singleton instance
     * @return mixed|null
     */
    public static function getInstance(): mixed
    {
        if (null === self::$instance) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     * Returns an Array with all the Comments as Objects
     * @param int $news_id
     * @return array
     * @throws Exception
     */
    public function listComments(int $news_id = -1): array
    {
        try {
            $db = DB::getInstance();

            // If a news_id argument was passed then we make a select for the comments that have that ID
            if ($news_id != -1) {
                $sql_query = "SELECT * FROM comment WHERE news_id=$news_id";
            // Otherwise we select all the comments
            } else {
                $sql_query = "SELECT * FROM comment";
            }

            $comments = [];
            // Iterate through all the rows returned from the SQL query
            foreach ($db->select($sql_query) as $row) {
                $new_comment = new Comment();
                // Create a new Comment object and set each parameter and then add it to the array
                $comments[] = $new_comment->setId($row['id'])
                    ->setBody($row['body'])
                    ->setCreatedAt(new DateTimeImmutable($row['created_at']))
                    ->setNewsId($row['news_id']);
            }
        } catch (Exception $e) {
            throw new Exception("Error when SELECTING the list of Comments!:\t" . $e->getMessage());
        }

        return $comments;
    }

    /**
     * Inserts into the Database a Comment with the provided Body and NewsID.
     * Returns the last inserted ID in the Database
     * @param string $body
     * @param int $newsId
     * @return mixed
     * @throws Exception
     */
    public function addComment(string $body, int $newsId): mixed
    {
        try {
            $db = DB::getInstance();

            $prepared_query = "INSERT INTO comment (body, created_at, news_id) VALUES (:body, :created_at, :news_id)";
            $exec_arg = [
                ":body" => $body,
                ":created_at" => date('Y-m-d H:i:s', time()),
                ":news_id" => $newsId
            ];

            $db->exec($prepared_query, $exec_arg);

        } catch (PDOException $e) {
            throw new Exception("Error when INSERTING a new Comment in the DB!:\t" . $e->getMessage());
        }

        print ("The new comment '$body' was added successfully!\n");
        return $db->getLastInsertId();
    }


    /**
     * Deletes the comment based on the provided ID.
     * Returns the rowCount (if it was successful or not)
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function deleteComment(int $id): mixed
    {
        try {
            $db = DB::getInstance();
            $prepared_query = "DELETE FROM comment WHERE id=:id";
            $exec_arg = [
                ":id" => $id
            ];
            $deletion_status = $db->exec($prepared_query, $exec_arg, true);

            // If the rowCount is positive then the comment was deleted, otherwise there was no comment to be deleted
            if ($deletion_status) {
                print ("The comment with ID: $id was deleted successfully\n");
            } else {
                print("The comment with ID: $id does not exist in the DB!\n");
            }

            return $deletion_status;

        } catch (PDOException $e) {
            throw new Exception("Error when DELETING a Comment from the DB!:\t" . $e->getMessage());
        }
    }
}