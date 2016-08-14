<?php

use PhpProjects\AuthDev\Controllers\ContentNotFoundException;
use PhpProjects\AuthDev\Controllers\ErrorController;
use PhpProjects\AuthDev\Controllers\GroupController;
use PhpProjects\AuthDev\Controllers\LoginController;
use PhpProjects\AuthDev\Controllers\PermissionController;
use PhpProjects\AuthDev\Controllers\UserController;

require __DIR__ . '/../src/bootstrap.php';

session_start();

list($path, ) = explode('?', $_SERVER['REQUEST_URI'], 2);
$pathParts = explode('/', ltrim($path, '/'));

try
{
    switch ($pathParts[0])
    {
        case 'auth':
            $controller = LoginController::create();
            switch ($pathParts[1])
            {
                case 'login':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getLogin($_GET['originalUrl'] ?? '');
                    }
                    else
                    {
                        $controller->postLogin($_POST);
                    }
                    break;
                case 'logout':
                    if ($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $controller->postLogout($_POST);
                    }
                    break;
                default:
                    throw (new ContentNotFoundException("I could not find the page you were looking for. You may need to start over!"))
                        ->setTitle('Page not found!');
            }
            break;
        case 'users':
            $controller = UserController::create();

            switch ($pathParts[1])
            {
                case '':
                    $controller->getList($_GET['page'] ?? 1, $_GET['q'] ?? '');
                    break;
                case 'new':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getNew();
                    }
                    else
                    {
                        $controller->postNew($_POST);
                    }
                    break;
                case 'detail':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getDetail(urldecode($pathParts[2] ?? ''));
                    }
                    else
                    {
                        $controller->postDetail(urldecode($pathParts[2] ?? ''), $_POST);
                    }
                    break;
                case 'remove':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getRemove($_GET);
                    }
                    else
                    {
                        $controller->postRemove($_POST);
                    }
                    break;
                case 'update-groups':
                    if ($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $controller->postUpdateGroups(urldecode($pathParts[2] ?? ''), $_POST);
                    }
                    break;
                default:
                    throw (new ContentNotFoundException("I could not find the page you were looking for. You may need to start over!"))
                        ->setTitle('Page not found!');
            }
            break;

        case 'groups':
            $controller = GroupController::create();

            switch ($pathParts[1])
            {
                case '':
                    $controller->getList($_GET['page'] ?? 1, $_GET['q'] ?? '');
                    break;
                case 'new':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getNew();
                    }
                    else
                    {
                        $controller->postNew($_POST);
                    }
                    break;
                case 'detail':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getDetail(urldecode($pathParts[2] ?? ''));
                    }
                    else
                    {
                        $controller->postDetail(urldecode($pathParts[2] ?? ''), $_POST);
                    }
                    break;
                case 'remove':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getRemove($_GET);
                    }
                    else
                    {
                        $controller->postRemove($_POST);
                    }
                    break;
                case 'update-permissions':
                    if ($_SERVER['REQUEST_METHOD'] == 'POST')
                    {
                        $controller->postUpdatePermissions(urldecode($pathParts[2] ?? ''), $_POST);
                    }
                    break;
                default:
                    throw (new ContentNotFoundException("I could not find the page you were looking for. You may need to start over!"))
                        ->setTitle('Page not found!');
            }
            break;

        case 'permissions':
            $controller = PermissionController::create();

            switch ($pathParts[1])
            {
                case '':
                    $controller->getList($_GET['page'] ?? 1, $_GET['q'] ?? '');
                    break;
                case 'new':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getNew();
                    }
                    else
                    {
                        $controller->postNew($_POST);
                    }
                    break;
                case 'detail':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getDetail(urldecode($pathParts[2] ?? ''));
                    }
                    else
                    {
                        $controller->postDetail(urldecode($pathParts[2] ?? ''), $_POST);
                    }
                    break;
                case 'remove':
                    if ($_SERVER['REQUEST_METHOD'] == 'GET')
                    {
                        $controller->getRemove($_GET);
                    }
                    else
                    {
                        $controller->postRemove($_POST);
                    }
                    break;
                default:
                    throw (new ContentNotFoundException("I could not find the page you were looking for. You may need to start over!"))
                        ->setTitle('Page not found!');
            }
            break;

        case '':
            header('Location: /users/');
            break;
        
        default:
            throw (new ContentNotFoundException("I could not find the page you were looking for. You may need to start over!"))
                ->setTitle('Page not found!');
    }
}
catch (ContentNotFoundException $e)
{
    $controller = ErrorController::create();
    $controller->getNotFoundPage($e);
}
catch (Throwable $e)
{
    $controller = ErrorController::create();
    $controller->getErrorPage($e);
}
