<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ledger $ledger
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ledger->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ledger->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ledgers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ledger Types'), ['controller' => 'LedgerTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ledger Type'), ['controller' => 'LedgerTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ledgers form large-9 medium-8 columns content">
    <?= $this->Form->create($ledger) ?>
    <fieldset>
        <legend><?= __('Edit Ledger') ?></legend>
        <?php
            echo $this->Form->control('date');
            echo $this->Form->control('name');
            echo $this->Form->control('cat_id');
            echo $this->Form->control('ledger_type_id', ['options' => $ledgerTypes, 'empty' => true]);
            echo $this->Form->control('amount');
            echo $this->Form->control('note');
            echo $this->Form->control('creator');
            echo $this->Form->control('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
