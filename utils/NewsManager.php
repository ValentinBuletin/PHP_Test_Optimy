<?php

namespace Database\utils;

use Database\class\News;
use DateTimeImmutable;
use Exception;
use PDOException;

class NewsManager
{
    // Private Variables
    private static mixed $instance = null;

    /**
     * Constructor validates the required files are present
     */
    public function __construct()
    {
        require_once('DB.php');
        require_once('CommentManager.php');
        require_once('../class/News.php');
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
     * Returns an Array with all the News entries as Objects
     * @return array
     * @throws Exception
     */
    public function listNews(): array
    {
        $db = DB::getInstance();
        $sql_query = "SELECT * FROM news";

        try {
            $news = [];
            // Iterate through all the rows returned from the SQL query
            foreach ($db->select($sql_query) as $row) {
                $new_news = new News();
                // Create a new News object and set each parameter and then add it in the array
                $news[] = $new_news->setId($row['id'])
                    ->setTitle($row['title'])
                    ->setBody($row['body'])
                    ->setCreatedAt(new DateTimeImmutable($row['created_at']));
            }
        } catch (Exception $e) {
            throw new Exception("Error when SELECTING the list of News!:\t" . $e->getMessage());
        }

        return $news;
    }

    /**
     * Inserts into the Database a News entry with the provided Title and Body.
     * Returns the changes added in the Database
     * @param $title
     * @param $body
     * @return mixed
     * @throws Exception
     */
    public function addNews($title, $body): mixed
    {
        try {
            $db = DB::getInstance()->pdo;
            $prepared_query = $db->prepare("INSERT INTO news (title, body, created_at) VALUES (:title, :body, :created_at)");
            $prepared_query->execute([
                ":title" => $title,
                ":body" => $body,
                ":created_at" => date('Y-m-d H:i:s', time())
            ]);
        } catch (PDOException $e) {
            throw new Exception("Error when INSERTING a new News entry in the DB!:\t" . $e->getMessage());
        }

        print ("The news '$title' was added successfully!\n");
        return $db->lastInsertId();
    }

    /**
     * Deletes the news entry based on the provided ID and also the linked comments.
     * Returns the rowCount (if it was successful or not)
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function deleteNews($id): mixed
    {
        try {
            // Get the list of all the Comments
            $comments = CommentManager::getInstance()->listComments();
            $idsToDelete = [];

            // Check if the newsId from any of the comments matches the passed ID, if positive add it to an array
            foreach ($comments as $comment) {
                if ($comment->getNewsId() == $id) {
                    $idsToDelete[] = $comment->getId();
                }
            }

            // Iterate through the array and delete the Comments that were linked to the News
            foreach ($idsToDelete as $idComment) {
                CommentManager::getInstance()->deleteComment($idComment);
            }

            // Delete the News
            $db = DB::getInstance()->pdo;
            $prepared_query = $db->prepare("DELETE FROM news WHERE id=:id");
            $prepared_query->execute([
                ":id" => $id
            ]);

            // Check the rowCount of the DB to see if the news entry was deleted or not
            // as it is possible that the provided ID does not exist in the DB
            $deletion_status = $prepared_query->rowCount();

            // If the rowCount is positive then the news entry was deleted, otherwise there was no news entry to be deleted
            if ($deletion_status) {
                print ("The news entry with ID: $id was deleted successfully\n");
            } else {
                print("The news entry with ID: $id does not exist in the DB!\n");
            }

            return $deletion_status;

        } catch (PDOException $e) {
            throw new Exception("Error when DELETING a News entry from the DB!:\t" . $e->getMessage());
        }
    }
}

// The code below was used to verify the functions from this class

//$nm = new NewsManager();
//$tmp_comments = $nm->listNews();
//foreach ($tmp_comments as $comment) {
//    print $comment->getid() . "\t";
//    print $comment->gettitle() . "\t";
//    print $comment->getbody() . "\t";
//    print $comment->getCreatedAt()->format('Y-m-d H:i:s') . "\n";
//}
//$nm->addNews("Great Title", "This is the body");
//$nm->deleteNews(14);