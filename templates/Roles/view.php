<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Roles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Role'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="roles view content">
            <h3><?= h($role->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($role->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($role->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($role->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($role->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Role Permissions') ?></h4>
                <?php if (!empty($role->role_permissions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Module Id') ?></th>
                            <th><?= __('Permission Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($role->role_permissions as $rolePermissions) : ?>
                        <tr>
                            <td><?= h($rolePermissions->id) ?></td>
                            <td><?= h($rolePermissions->role_id) ?></td>
                            <td><?= h($rolePermissions->module_id) ?></td>
                            <td><?= h($rolePermissions->permission_id) ?></td>
                            <td><?= h($rolePermissions->created) ?></td>
                            <td><?= h($rolePermissions->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RolePermissions', 'action' => 'view', $rolePermissions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RolePermissions', 'action' => 'edit', $rolePermissions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'RolePermissions', 'action' => 'delete', $rolePermissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rolePermissions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
