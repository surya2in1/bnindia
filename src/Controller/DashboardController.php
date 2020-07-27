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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class DashboardController extends AppController
{
    public function index()
    {
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
        ]);
        // echo '<pre>';print_r($user);exit;
        $this->viewBuilder()->setLayout('admin');

        // Output user image
    }
}
