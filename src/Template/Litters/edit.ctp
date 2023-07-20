<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Litter $litter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $litter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $litter->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Litters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Plans'), ['controller' => 'Plans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Plan'), ['controller' => 'Plans', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Breeds'), ['controller' => 'Breeds', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Breed'), ['controller' => 'Breeds', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Litters'), ['controller' => 'Litters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Litter'), ['controller' => 'Litters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="litters form large-9 medium-8 columns content">
    <?= $this->Form->create($litter) ?>
    <fieldset>
        <legend><?= __('Edit Litter') ?></legend>
        <?php
            echo $this->Form->control('litter_id');
            echo $this->Form->control('plan_id', ['options' => $plans, 'empty' => true]);
            echo $this->Form->control('no_live_kits');
            echo $this->Form->control('no_dead_kits');
            echo $this->Form->control('no_kits');
            echo $this->Form->control('cage');
            echo $this->Form->control('breed_id', ['options' => $breeds, 'empty' => true]);
            echo $this->Form->control('buck');
            echo $this->Form->control('doe');
            echo $this->Form->control('date_bred');
            echo $this->Form->control('date_born');
            echo $this->Form->control('creator');
            echo $this->Form->control('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
