<?php

namespace Database\utils;

use Database\class\Comment;
use DateTimeImmutable;
use Exception;
use PDOException;

class CommentManager
{
    // Private Variables
    private static mixed $instance = null;

    /**
     * Constructor validates the required files are present
     */
    public function __construct()
    {
        require_once('DB.php');
        require_once('../class/Comment.php');
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
     * @return array
     * @throws Exception
     */
    public function listComments(): array
    {
        $db = DB::getInstance();
        $sql_query = "SELECT * FROM comment";

        try {
            $comments = [];
            // Iterate through all the rows returned from the SQL query
            foreach ($db->select($sql_query) as $row) {
                $new_comment = new Comment();
                // Create a new Comment object and set each parameter and then add it in the array
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
     * Inserts into the Database a Comment with the provided Body and NewsID and
     * returns the changes added in the Database
     * @param $body
     * @param $newsId
     * @return mixed
     * @throws Exception
     */
    public function addComment($body, $newsId): mixed
    {
        try {
            $db = DB::getInstance()->pdo;
            $prepared_query = $db->prepare("INSERT INTO comment (body, created_at, news_id) VALUES (:body, :created_at, :news_id)");
            $prepared_query->execute([
                ":body" => $body,
                ":created_at" => date('Y-m-d H:i:s', time()),
                ":news_id" => $newsId
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error when INSERTING a new Comment in the DB!:\t" . $e->getMessage());
        }

        print ("The new comment '$body' was added successfully!\n");
        return $db->lastInsertId();
    }


    /**
     * Deletes the comment based on the provided ID and returns the rowCount (if it was successful or not)
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function deleteComment($id): mixed
    {
        try {
            $db = DB::getInstance()->pdo;
            $prepared_query = $db->prepare("DELETE FROM comment WHERE id=:id");
            $prepared_query->execute([
                ":id" => $id
            ]);

            // Check the rowCount of the DB to see if the comment was deleted or not
            // as it is possible that the provided ID does not exist in the DB
            $deletion_status = $prepared_query->rowCount();

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

// The code below was used to verify the functions from this class

//$cm = new CommentManager();
//$tmp_comments = $cm->listComments();
//foreach ($tmp_comments as $comment) {
//    print $comment->getid() . "\t";
//    print $comment->getbody() . "\t";
//    print $comment->getCreatedAt()->format('Y-m-d H:i:s') . "\t";
//    print $comment->getNewsId() . "\n";
//}
//$cm->addComment("This is a new comment", "3");
//$cm->deleteComment(50);
