<?php

namespace jeanforteroche\Controller;

use jeanforteroche\Domain\Reply;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use jeanforteroche\Domain\Comment;
use jeanforteroche\Form\Type\CommentType;
use jeanforteroche\Form\Type\ReplyType;

class HomeController {

    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $articles = $app['dao.article']->findAll();
        return $app['twig']->render('index.html.twig', array('articles' => $articles));
    }

    /**
     * Article details controller.
     *
     * @param integer $id Article id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function articleAction($id, Request $request, Application $app) {
        $article = $app['dao.article']->find($id);

        if ($article) {
            $comment = new Comment();
            $comment->setArticle($article);
            $comment->setId($id);
            $commentForm = $app['form.factory']->create(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été enregistrer');
            }
            $reply = new Reply();
            $reply->setComment($comment);
            $reply->setId($id);
            $replyForm = $app['form.factory']->create(ReplyType::class, $reply);
            $replyForm->handleRequest($request);
            if ($replyForm->isSubmitted() && $replyForm->isValid())
            {
                $app['dao.reply']->save($reply);
                $app['session']->getFlashBag()->add('success', 'Votre commentaire a bien été enregistrer');

            }
        }
        $comments = $app['dao.comment']->findAllByArticle($id);
        $replys = $app['dao.reply']->findAllByComment($id);

        return $app['twig']->render('article.html.twig', array(
                'article' => $article,
                'comments' => $comments,
                'replys'  => $replys,
                'replyForm'  => $replyForm->createView(),
                'commentForm' => $commentForm->createView())
        );
    }

    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
    }
}
