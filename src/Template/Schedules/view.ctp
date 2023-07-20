<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Schedule $schedule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Schedule'), ['action' => 'edit', $schedule->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Schedule'), ['action' => 'delete', $schedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schedule->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Schedule Types'), ['controller' => 'ScheduleTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule Type'), ['controller' => 'ScheduleTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Icons'), ['controller' => 'Icons', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Icon'), ['controller' => 'Icons', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Recurrings'), ['controller' => 'Recurrings', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recurring'), ['controller' => 'Recurrings', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="schedules view large-9 medium-8 columns content">
    <h3><?= h($schedule->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Schedule Type') ?></th>
            <td><?= $schedule->has('schedule_type') ? $this->Html->link($schedule->schedule_type->name, ['controller' => 'ScheduleTypes', 'action' => 'view', $schedule->schedule_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($schedule->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($schedule->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= $schedule->has('icon') ? $this->Html->link($schedule->icon->name, ['controller' => 'Icons', 'action' => 'view', $schedule->icon->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Recurring') ?></th>
            <td><?= $schedule->has('recurring') ? $this->Html->link($schedule->recurring->name, ['controller' => 'Recurrings', 'action' => 'view', $schedule->recurring->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($schedule->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($schedule->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creator') ?></th>
            <td><?= $this->Number->format($schedule->creator) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= $this->Number->format($schedule->deleted) ?></td>
        </tr>
    </table>
</div>
