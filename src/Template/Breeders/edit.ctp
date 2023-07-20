<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Breeder $breeder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $breeder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $breeder->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Breeders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Breeds'), ['controller' => 'Breeds', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Breed'), ['controller' => 'Breeds', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sexes'), ['controller' => 'Sexes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Sex'), ['controller' => 'Sexes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Breeders'), ['controller' => 'Breeders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Breeder'), ['controller' => 'Breeders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="breeders form large-9 medium-8 columns content">
    <?= $this->Form->create($breeder) ?>
    <fieldset>
        <legend><?= __('Edit Breeder') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('breeder_id');
            echo $this->Form->control('cage');
            echo $this->Form->control('color');
            echo $this->Form->control('breed_id', ['options' => $breeds, 'empty' => true]);
            echo $this->Form->control('sex_id', ['options' => $sexes, 'empty' => true]);
            echo $this->Form->control('weight');
            echo $this->Form->control('date_born');
            echo $this->Form->control('date_acquired');
            echo $this->Form->control('father');
            echo $this->Form->control('mother');
            echo $this->Form->control('creator');
            echo $this->Form->control('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
