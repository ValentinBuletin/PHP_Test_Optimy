<?php

namespace Database;

use Database\utils\NewsManager;
use Database\utils\CommentManager;

// Global variable
const ROOT = __DIR__; // Assigning to ROOT the absolute path of the project

// Validating the required files are present
require_once(ROOT . "/utils/NewsManager.php");
require_once(ROOT . "/utils/CommentManager.php");

/**
 * Displays all the News (Title, Body) and the Comments (ID, Body) associated to it
 * @return void
 */
function displayDataBaseData(): void
{

    // Iterate through all the returned News entities
    foreach (NewsManager::getInstance()->listNews() as $news) {
        // Display the Title and the Body of the News entity
        echo("############ NEWS " . $news->getTitle() . " ############\n");
        echo($news->getBody() . "\n");
        // Get all the comments that are associated to the News ID and iterate through them
        foreach (CommentManager::getInstance()->listComments($news->getId()) as $comment) {
            echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
        }
    }
}


/**
 * Function used to test all the methods from inside CommentManager
 * @return void
 */
function testCommentManagerFunctions(): void
{
    print ("\n Comment Manager Functions\n");

    $cm = CommentManager::getInstance();

    $tmp_comments = $cm->listComments(1);
    foreach ($tmp_comments as $comment) {
        print $comment->getid() . "\t";
        print $comment->getbody() . "\t";
        print $comment->getCreatedAt()->format('Y-m-d H:i:s') . "\t";
        print $comment->getNewsId() . "\n";
    }

    $cm->addComment("This is a new comment", "3");

    $cm->deleteComment(60);

}

/**
 * Function used to test all the methods from inside CommentManager
 * @return void
 */
function testNewsManagerFunctions(): void
{
    print ("\n News Manager Functions\n");

    $nm = NewsManager::getInstance();

    $tmp_comments = $nm->listNews();
    foreach ($tmp_comments as $comment) {
        print $comment->getid() . "\t";
        print $comment->gettitle() . "\t";
        print $comment->getbody() . "\t";
        print $comment->getCreatedAt()->format('Y-m-d H:i:s') . "\n";
    }

    $nm->addNews("Great Title", "This is the body");

    $nm->deleteNews(16);
}

displayDataBaseData();
//testCommentManagerFunctions();
//testNewsManagerFunctions();
