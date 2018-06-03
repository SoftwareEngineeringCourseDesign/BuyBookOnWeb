<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'auth',
], function () use ($router) {
   $router->post('register', 'Auth\RegisterController@handle'); //注册(√)
   $router->post('login', 'Auth\LoginController@handle'); //登陆(√)
});

$router->group([
    'prefix' => 'category',
], function () use ($router) {
    $router->get('/', 'Category\ListController@handle'); //获取分类(√)
});

$router->group([
    'prefix' => 'book',
], function () use ($router) {
    $router->get('/', 'Book\ShowController@handle'); //书籍查询(√)
    $router->post('/', 'Book\NewController@handle'); //上传新书(√)
    $router->get('/{id}', 'Book\ShowDetailController@handle'); //书籍详情(√)
    $router->put('/{id}', 'Book\AlterController@handle'); //修改书籍信息(√)
});

$router->group([
    'prefix' => 'order',
], function () use ($router) {
    $router->get('/', 'Order\ListController@handle'); //订单列表(√)
    $router->get('/{id}', 'Order\DetailController@handle'); //订单详情(√)
    $router->post('/new', 'Order\NewController@handle'); //生成订单(√)
    $router->put('/{id}/pay', 'Order\PayController@handle'); //订单支付(√)
    $router->put('/{id}/send', 'Order\SendController@handle'); //订单发货(√)
    $router->put('/{id}/receive', 'Order\ReceiveController@handle'); //订单收货(√)
    $router->put('/{id}/evaluate', 'Order\EvaluateController@handle'); //评分评价(√)
});

$router->group([
    'prefix' => 'comment',
], function () use ($router) {
    $router->get('/', 'Comment\ListController@handle'); //获取评论列表(√)
    $router->post('/{order_id}', 'Comment\NewController@handle'); //新建评论(√)
    $router->delete('/{id}', 'Comment\DeleteController@handle'); //删除评论(√)
});

$router->group([
    'prefix' => 'user',
], function () use ($router) {
    $router->put('/{id}', 'User\AlterController@handle'); //密码修改(√)
    $router->get('/{id}', 'User\ShowController@handle'); //信息展示(√)
});

$router->group([
    'prefix' => 'archive',
], function () use ($router) {
    $router->get('/{type}', 'Archive\ListController@handle'); //获取列表(√)
    $router->get('/{type}/{id}', 'Archive\DetailController@handle'); //获取详情(√)
    $router->put('/{type}/{id}', 'Archive\AuditController@handle'); //审核(√)
    $router->post('/{type}/{id}', 'Archive\NewController@handle'); //新建备案(√)
});