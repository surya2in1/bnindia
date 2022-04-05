<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agent $agent
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Agent'), ['action' => 'edit', $agent->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Agent'), ['action' => 'delete', $agent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agent->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Agents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Agent'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="agents view content">
            <h3><?= h($agent->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Agent Code') ?></th>
                    <td><?= h($agent->agent_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($agent->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($agent->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mobile Number') ?></th>
                    <td><?= h($agent->mobile_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($agent->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address Proof') ?></th>
                    <td><?= h($agent->address_proof) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pan Card') ?></th>
                    <td><?= h($agent->pan_card) ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo') ?></th>
                    <td><?= h($agent->photo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Educational Proof') ?></th>
                    <td><?= h($agent->educational_proof) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name') ?></th>
                    <td><?= h($agent->bank_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Account No') ?></th>
                    <td><?= h($agent->account_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ifsc Code') ?></th>
                    <td><?= h($agent->ifsc_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Branch Name') ?></th>
                    <td><?= h($agent->branch_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Address') ?></th>
                    <td><?= h($agent->bank_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($agent->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= $this->Number->format($agent->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($agent->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($agent->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
