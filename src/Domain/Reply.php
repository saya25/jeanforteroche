<?php

namespace jeanforteroche\Domain;

class Reply
{

    /**
     * Comment id.
     *
     * @var integer
     */
    private $id;

    /**
     * Comment idComParent.
     *
     * @var integer
     */
    private $comParent;

    /**
     * Comment level.
     *
     * @var integer
     */
    private $level = 0;

    /**
     * Comment author.
     *
     * @var string
     */
    private $author;

    /**
     * Comment content.
     *
     * @var integer
     */
    private $content;

    /**
     * Associated article.
     *
     * @var \jeanforteroche\Domain\Article
     */
    private $article;


    /**
     * Associated article.
     *
     * @var \jeanforteroche\Domain\Comment
     */
    private $comment;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }

    public function getComment(){
        return $this->comment;
    }

    public function setComment(Comment $comment){
        $this->comment = $comment;
        return  $this;
    }

    public function getComParent(){
        return  $this->comParent;
    }

    public function setComParent($comParent){
        $this->comParent = $comParent;
        return  $this;
    }

    public function getLevel(){
        return  $this->level;
    }

    public function setLevel($level){
        $this->level = $level;
        return  $this;
    }
}