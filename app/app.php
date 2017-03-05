<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Chargement erreurs, exception
ErrorHandler::register();
ExceptionHandler::register();

// Enregistrement fournisseurs de services (doctrine, twig, Form, sécurité)
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new jeanforteroche\DAO\UserDAO($app['db']);
            },
        ),
    ),
));

// Section admin
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => function () use ($app) {
                return new jeanforteroche\DAO\UserDAO($app['db']);
            },
        ),
    ),
    'security.role_hierarchy' => array(
        'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));

// enregistrement de mes services (article, user, commentaire)
$app['dao.article'] = function ($app) {
    return new jeanforteroche\DAO\ArticleDAO($app['db']);
};

$app['dao.user'] = function ($app) {
    return new jeanforteroche\DAO\UserDAO($app['db']);
};

$app['dao.comment'] = function ($app) {
    $commentDAO = new jeanforteroche\DAO\CommentDAO($app['db']);
    $commentDAO->setArticleDAO($app['dao.article']);
    return $commentDAO;
};

$app['dao.reply'] = function ($app) {
    $replyDAO = new jeanforteroche\DAO\ReplyDAO($app['db']);
    $replyDAO->setCommentDAO($app['dao.comment']);
    return $replyDAO;
};


$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/jeanforteroche.log',
    'monolog.name' => 'JeanForteroche',
    'monolog.level' => $app['monolog.level']
));




