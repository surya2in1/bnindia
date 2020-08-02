<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    // echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('middle_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('address');
                    echo $this->Form->control('city');
                    echo $this->Form->control('state');
                    echo $this->Form->control('gender');
                    echo $this->Form->control('maritial_status');
                    echo $this->Form->control('date_of_birth');
                    echo $this->Form->control('mobile_number');
                    echo $this->Form->control('email');
                    echo $this->Form->control('nominee_name');
                    echo $this->Form->control('nominee_relation');
                    echo $this->Form->control('nominee_dob', ['empty' => true]);
                    echo $this->Form->control('occupation');
                    echo $this->Form->control('income_amt');
                    echo $this->Form->control('address_proof');
                    echo $this->Form->control('photo_proof');
                    echo $this->Form->control('other_document');
                    echo $this->Form->control('profile_picture');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
