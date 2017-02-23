<?php

// Home page
$app->get('/', 'jeanforteroche\Controller\HomeController::indexAction')
    ->bind('home');

// Detailed info about an article
$app->match('/article/{id}', 'jeanforteroche\Controller\HomeController::articleAction')
    ->bind('article');

// Login form
$app->get('/login', 'jeanforteroche\Controller\HomeController::loginAction')
    ->bind('login');

// Admin zone
$app->get('/admin', 'jeanforteroche\Controller\AdminController::indexAction')
    ->bind('admin');

// Add a new article
$app->match('/admin/article/add', 'jeanforteroche\Controller\AdminController::addArticleAction')
    ->bind('admin_article_add');

// Edit an existing article
$app->match('/admin/article/{id}/edit', 'jeanforteroche\Controller\AdminController::editArticleAction')
    ->bind('admin_article_edit');

// Remove an article
$app->get('/admin/article/{id}/delete', 'jeanforteroche\Controller\AdminController::deleteArticleAction')
    ->bind('admin_article_delete');

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', 'jeanforteroche\Controller\AdminController::editCommentAction')
    ->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', 'jeanforteroche\Controller\AdminController::deleteCommentAction')
    ->bind('admin_comment_delete');

// Add a user
$app->match('/admin/user/add', 'jeanforteroche\Controller\AdminController::addUserAction')
    ->bind('admin_user_add');

// Edit an existing user
$app->match('/admin/user/{id}/edit', 'jeanforteroche\Controller\AdminController::editUserAction')
    ->bind('admin_user_edit');

$app->get('/admin/user/{id}/delete', 'jeanforteroche\Controller\AdminController::deleteUserAction')
    ->bind('admin_user_delete');




