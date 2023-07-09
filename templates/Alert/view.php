<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Alert $alert
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Alert'), ['action' => 'edit', $alert->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Alert'), ['action' => 'delete', $alert->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alert->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Alert'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Alert'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="alert view content">
            <h3><?= h($alert->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $alert->has('user') ? $this->Html->link($alert->user->username, ['controller' => 'User', 'action' => 'view', $alert->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($alert->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Province') ?></th>
                    <td><?= h($alert->province) ?></td>
                </tr>
                <tr>
                    <th><?= __('Specie') ?></th>
                    <td><?= h($alert->specie) ?></td>
                </tr>
                <tr>
                    <th><?= __('Race') ?></th>
                    <td><?= h($alert->race) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= h($alert->active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($alert->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($alert->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Creation Date') ?></th>
                    <td><?= h($alert->creation_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
