<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Litter[]|\Cake\Collection\CollectionInterface $litters
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Litter'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Plans'), ['controller' => 'Plans', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Plan'), ['controller' => 'Plans', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Breeds'), ['controller' => 'Breeds', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Breed'), ['controller' => 'Breeds', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="litters index large-9 medium-8 columns content">
    <h3><?= __('Litters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('litter_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('plan_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('no_live_kits') ?></th>
                <th scope="col"><?= $this->Paginator->sort('no_dead_kits') ?></th>
                <th scope="col"><?= $this->Paginator->sort('no_kits') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cage') ?></th>
                <th scope="col"><?= $this->Paginator->sort('breed_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('buck') ?></th>
                <th scope="col"><?= $this->Paginator->sort('doe') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_bred') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_born') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creator') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($litters as $litter): ?>
            <tr>
                <td><?= $this->Number->format($litter->id) ?></td>
                <td><?= h($litter->litter_id) ?></td>
                <td><?= $litter->has('plan') ? $this->Html->link($litter->plan->id, ['controller' => 'Plans', 'action' => 'view', $litter->plan->id]) : '' ?></td>
                <td><?= $this->Number->format($litter->no_live_kits) ?></td>
                <td><?= $this->Number->format($litter->no_dead_kits) ?></td>
                <td><?= $this->Number->format($litter->no_kits) ?></td>
                <td><?= h($litter->cage) ?></td>
                <td><?= $litter->has('breed') ? $this->Html->link($litter->breed->name, ['controller' => 'Breeds', 'action' => 'view', $litter->breed->id]) : '' ?></td>
                <td><?= $this->Number->format($litter->buck) ?></td>
                <td><?= $this->Number->format($litter->doe) ?></td>
                <td><?= h($litter->date_bred) ?></td>
                <td><?= h($litter->date_born) ?></td>
                <td><?= $this->Number->format($litter->creator) ?></td>
                <td><?= h($litter->created) ?></td>
                <td><?= $this->Number->format($litter->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $litter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $litter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $litter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $litter->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
