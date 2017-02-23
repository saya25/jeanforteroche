<?php

namespace jeanforteroche\Controller;


use Silex\Application;
use jeanforteroche\Domain\Article;
use jeanforteroche\Domain\User;
use jeanforteroche\Form\Type\ArticleType;
use jeanforteroche\Form\Type\CommentType;
Use jeanforteroche\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

class AdminController {

    public function indexAction(Application $app)
    {
        $articles = $app['dao.article']->findAll();
        $comments = $app['dao.comment']->findAll();
        $users = $app['dao.user']->findAll();
        return $app['twig']->render('admin.html.twig', array(
            'articles' => $articles,
            'comments' => $comments,
            'users' => $users,
        ));
    }

    public function addArticleAction(Request $request, Application $app) {
        $article = new Article();
        $articleForm = $app['form.factory']->create(ArticleType::class, $article);
        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'L\'article a bien été ajouter.');
        }
        return $app['twig']->render('article_form_admin.html.twig', array(
            'title' => 'Nouvel article',
            'articleForm' => $articleForm->createView()));
    }

    public function EditArticleAction($id, Request $request, Application $app)
    {
        $article = $app['dao.article']->find($id);
        $articleForm = $app['form.factory']->create(ArticleType::class, $article);
        $articleForm->handleRequest($request);
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $app['dao.article']->save($article);
            $app['session']->getFlashBag()->add('success', 'L\'article a bien été modifier');
        }
        return $app['twig']->render('article_form_admin.html.twig', array(
            'title' => 'Edit article',
            'articleForm' => $articleForm->createView()));
    }

    public function deleteArticleAction($id, Application $app)
    {
        $app['dao.comment']->deleteAllByArticle($id);
        $app['dao.article']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'article a bien été supprimer');

        return $app->redirect($app['url_generator']->generate('admin'));
    }

    public function editCommentAction($id, Request $request, Application $app)
    {

        $comment = $app['dao.comment']->find($id);
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if($commentForm->isSubmitted() && $commentForm->isValid())
        {
            $app['dao.comment']->save($comment);
            $app['session']->getFlashBag()->add('success', 'Le commentaire a bien été modifier');
        }
        return $app['twig']->render('comment_form_admin.html.twig', array(
            'title' => 'Editer commentaire',
            'commentForm' => $commentForm->createView()));
    }

    public function deleteCommentAction($id, Application $app)
    {
        $app['dao.comment']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Le commentaire a bien été supprimer');

        return $app->redirect($app['url_generator']->generate('admin'));
    }

    public function addUserAction(Request $request, Application $app)
    {
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();

            $encoder = $app['security.encoder.bcrypt'];

            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'L\'utilisateur a bien été ajouter');
        }
            return $app['twig']->render('user_form_admin.html.twig', array(
                'title' => 'Nouvel utilisateur',
                'userForm'  => $userForm->createView()));
    }

    public function editUserAction($id, Request $request, Application $app)
    {
        $user = $app['dao.user']->find($id);
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid())
        {
            $plainPassword =  $user->getPassword();

            $encoder = $app['security.encoder_factory']->getEncoder($user);

            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $app['dao.user']->save($user);
            $app['session']->getFlashBag()->add('success', 'L\'utilisateur a bien été modifier');
        }
        return $app['twig']->render('user_form_admin.html.twig', array(
            'title' => 'Editer utilisateur',
            'userForm' => $userForm->createView()));
    }

    public function deleteUserAction($id, Application $app)
    {
        $app['dao.comment']->deleteAllByUser($id);

        $app['dao.user']->delete($id);
        $app['session']->getFlashBag()->add('success', 'L\'utilisateur a bien été supprimer');

        return $app->redirect($app['url_generator']->generate('admin'));
    }
}