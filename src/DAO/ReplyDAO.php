<?php

namespace jeanforteroche\DAO;

use jeanforteroche\Domain\Reply;

class ReplyDAO extends DAO
{

    /**
     * @var \jeanforteroche\DAO\UserDAO
     */
    private $userDAO;

    /**
     * @var \jeanforteroche\DAO\CommentDAO
     */
    private $commentDAO;

    public function setCommentDAO(CommentDAO $commentDAO)
    {
        $this->commentDAO = $commentDAO;
    }

    public function setUserDAO(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    /**
     * Return a list of all replys for an article, sorted by date (most recent last).
     *
     * @param integer $commentId reply id.
     *
     * @return array A list of all replys for the article.
     */
    public function findAllByComment($commentId)
    {

        $comment = $this->commentDAO->find($commentId);

        $sql = "select reply_id, reply_content, reply_author from t_reply where com_id=2 order by reply_id";
        $result = $this->getDb()->fetchAll($sql, array($commentId));

        // Convert query result to an array of domain objects
        $replys = array();
        foreach ($result as $row) {
            $comId = $row['reply_id'];
            $reply = $this->buildDomainObject($row);
            // The associated article is defined for the constructed comment
            $reply->setComment($comment);
            $replys[$comId] = $reply;
        }
        return $replys;
    }


    /**
     * Creates an Reply object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \jeanforteroche\Domain\Reply
     */
    protected function buildDomainObject(array $row)
    {
        $reply = new Reply();
        $reply->setId($row['reply_id']);
        $reply->setAuthor($row['reply_author']);
        $reply->setContent($row['reply_content']);

        if (array_key_exists('com_id', $row))
        {
            // Find and set the associated comment
            $commentaireId = $row['com_id'];
            $article = $this->commentDAO->find($commentaireId);
            $reply->setComment($article);
        }
        return $reply;
    }

    public function save(Reply $reply) {
         var_dump($reply->getComParent());
        $commentData = array(
            'reply_content' => $reply->getContent(),
            'reply_author' => $reply->getAuthor(),
            'com_id'    => $reply->getComParent(),
            'reply_level'   => $reply->getLevel(),
        );

        if ($reply->getId()) {
            // The reply has already been saved : update it
            $this->getDb()->insert('t_reply', $commentData);
            // Get the id of the newly created reply and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $reply->setId($id);
        }
    }

    public function find ($id) {
        $sql = "select * from t_reply where reply_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
    }

    public function findAll()
    {
        $sql = "select * from t_reply order by reply_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['reply_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
}