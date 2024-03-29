<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Core\Configure;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    // Register scoped middleware for in scopes.
    $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
    ]));

    $builder->registerMiddleware('cookies', new EncryptedCookieMiddleware(['remember_me'],  base64_encode(random_bytes(32))));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    $builder->applyMiddleware('csrf','cookies');
    $builder->setExtensions(['pdf']);

    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
     */
    //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    
    $builder->connect('/', ['controller' => 'Users', 'action' => 'index']);
    $builder->connect('/admin', ['controller' => 'Users', 'action' => 'login']);
    $builder->connect('/pages', ['controller' => 'Pages', 'action' => 'test']);
    $builder->connect('/dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
    $builder->connect('/members', ['controller' => 'Users', 'action' => 'members']);
    $builder->connect('/resetpassword/*', ['controller' => 'Users', 'action' => 'resetPassword']);
    $builder->connect('/personalinfo', ['controller' => 'Users', 'action' => 'personalinfo']);
    $builder->connect('/change-password', ['controller' => 'Users', 'action' => 'changePassword']);
    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $builder->connect('/group-form/*', ['controller' => 'Groups', 'action' => 'groupform']);

    $builder->connect('/add-group-members', ['controller' => 'Groups', 'action' => 'addGroupMembers']);

    $builder->connect('/member-form/*', ['controller' => 'Users', 'action' => 'memberform']);

     $builder->connect('/agent-form/*', ['controller' => 'Agents', 'action' => 'agentform']);
    
    $builder->connect('/error404', ['controller' => 'Error', 'action' => 'error404']);
    
    $builder->connect('/auction-form/*', ['controller' => 'Auctions', 'action' => 'auctionform']);
    
    $builder->connect('/payment-form/*', ['controller' => 'Payments', 'action' => 'paymentform']);
    
    $builder->connect('/payment-voucher-form/*', ['controller' => 'PaymentVouchers', 'action' => 'paymentvoucherform']);

    $builder->connect('/other-payment-form/*', ['controller' => 'OtherPayments', 'action' => 'otherpaymentform']);
    
    $builder->connect('/receipt-statement', ['controller' => 'Reports', 'action' => 'receiptstatement']);
    
    $builder->connect('/about-us', ['controller' => 'Users', 'action' => 'aboutus']);

    $builder->connect('/chitfund', ['controller' => 'Users', 'action' => 'chitfund']);

    $builder->connect('/services', ['controller' => 'Users', 'action' => 'services']);

    $builder->connect('/contact', ['controller' => 'Users', 'action' => 'contact']);

    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});


/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
