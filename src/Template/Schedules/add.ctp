<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Schedule $schedule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Schedules'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Schedule Types'), ['controller' => 'ScheduleTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Schedule Type'), ['controller' => 'ScheduleTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Icons'), ['controller' => 'Icons', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Icon'), ['controller' => 'Icons', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Recurrings'), ['controller' => 'Recurrings', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Recurring'), ['controller' => 'Recurrings', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="schedules form large-9 medium-8 columns content">
    <?= $this->Form->create($schedule) ?>
    <fieldset>
        <legend><?= __('Add Schedule') ?></legend>
        <?php
            echo $this->Form->control('schedule_type_id', ['options' => $scheduleTypes, 'empty' => true]);
            echo $this->Form->control('name');
            echo $this->Form->control('date');
            echo $this->Form->control('icon_id', ['options' => $icons, 'empty' => true]);
            echo $this->Form->control('recurring_id', ['options' => $recurrings, 'empty' => true]);
            echo $this->Form->control('creator');
            echo $this->Form->control('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
