<?php

namespace jeanforteroche\DAO;

use jeanforteroche\Domain\Comment;

class CommentDAO extends DAO
{
    /**
     * @var \jeanforteroche\DAO\ArticleDAO
     */
    private $articleDAO;


    /**
     * @var \jeanforteroche\DAO\UserDAO
     */
    private $userDAO;


    /**
     * @var \jeanforteroche\DAO\ReplyDAO
     */
    private $replyDAO;

    public function setArticleDAO(ArticleDAO $articleDAO)
    {
        $this->articleDAO = $articleDAO;
    }

    public function setUserDAO(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    /**
     * @var \jeanforteroche\DAO\ReplyDAO
     */
    public function setReplyDAO(ReplyDAO $replyDAO)
    {
        $this->replyDAO = $replyDAO;
    }


    /**
     * Return a list of all comments for an article, sorted by date (most recent last).
     *
     * @param integer $articleId The article id.
     *
     * @return array A list of all comments for the article.
     */
    public function findAllByArticle($articleId)
    {
        // The associated article is retrieved only once
        $article = $this->articleDAO->find($articleId);

        // art_id is not selected by the SQL query
        // The article won't be retrieved during domain objet construction
        $sql = "select com_id, com_content, com_author, usr_id from t_comment where art_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($articleId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $comment->setArticle($article);
            $comments[$comId] = $comment;
        }
        return $comments;
    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \jeanforteroche\Domain\Comment
     */
    protected function buildDomainObject(array $row)
    {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setAuthor($row['com_author']);
        $comment->setContent($row['com_content']);

        if (array_key_exists('art_id', $row))
        {
            // Find and set the associated article
            $articleId = $row['art_id'];
            $article = $this->articleDAO->find($articleId);
            $comment->setArticle($article);
        }
        return $comment;
    }

    public function save(Comment $comment) {
        $commentData = array(
            'art_id' => $comment->getArticle()->getId(),
            'com_content' => $comment->getContent(),
            'com_author' => $comment->getAuthor(),
            'usr_id'    => $comment->getId(1)
        );

        if ($comment->getId()) {
            // The comment has already been saved : update it
            $this->getDb()->insert('t_comment', $commentData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $comment->setId($id);
        }
    }

    /**
     * Returns a list of all comments, sorted by date (most recent first).
     *
     * @return array A list of all comments.
     */
    public function findAll()
    {
        $sql = "select * from t_comment order by com_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['com_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }

    /**
     * Removes all comments for an article
     *
     * @param $articleId The id of the article
     */
    public function deleteAllByArticle($articleId) {
        $this->getDb()->delete('t_comment', array('art_id' => $articleId));
    }


    public function find ($id) {
        $sql = "select * from t_comment where com_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("pas de commentaire id " .$id);
    }

    /**
     * Removes a comment from the database.
     *
     * @param @param integer $id The comment id
     */
    public function delete($id) {

        $this->getDb()->delete('t_comment', array('com_id' => $id));
    }

    /**
     * Removes all comments for a user
     *
     * @param integer $userId The id of the user
     */

    public function deleteAllByUser($userId)
    {
        $this->getDb()->delete('t_comment', array('usr_id' => $userId));
    }


}