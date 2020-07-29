<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Common');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ],
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => '/Users/login',
            // 'Authenticate.Cookie' => array(
            //        'fields' => array(
            //            'username' => 'email',
            //           'password' => 'password'
            //        ),
            //        'userModel' => 'User',
            //        'scope' => array('User.active' => 1),
            //        'crypt' => 'rijndael', // Defaults to rijndael(safest), optionally set to 'cipher' if required
            //        'cookie' => array(
            //            'name' => 'RememberMe',
            //            'time' => '+2 weeks',
            //       )
            //    )
        ]);
        
        $this->Auth->allow(['login','signup','add','forgotPassword','resetPassword']);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
        // echo '<pre>';print_r($this->Auth->user('first_name'));exit;
        $this->set('Auth', $this->Auth);

        if ($this->Auth->user()) {
            $ROLE_ADMIN = Configure::read('ROLE_ADMIN');
            $users= TableRegistry::get('Users');
            $user = $users->get($this->Auth->user('id'), [
                'contain' => [
                                 'Roles' => function ($q) {
                                    return $q
                                        ->select(['id','name'])
                                        ->contain(['RolePermissions' => function ($q) {
                                                return $q
                                                    ->select(['RolePermissions.role_id','Modules.name','Permissions.permission'])
                                                    ->contain(['Modules','Permissions']);
                                            },  
                                        ]);
                                },      
                             ],
            ])->toArray();
            $this->set('member_side_menu', $this->Common->searchUserPermission('members',$user['role']['role_permissions']));

        }
    }

}

