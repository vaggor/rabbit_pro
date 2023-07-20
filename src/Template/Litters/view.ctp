<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Litter $litter
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Litter'), ['action' => 'edit', $litter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Litter'), ['action' => 'delete', $litter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $litter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Litters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Litter'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Plans'), ['controller' => 'Plans', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Plan'), ['controller' => 'Plans', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Breeds'), ['controller' => 'Breeds', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Breed'), ['controller' => 'Breeds', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Litters'), ['controller' => 'Litters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Litter'), ['controller' => 'Litters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="litters view large-9 medium-8 columns content">
    <h3><?= h($litter->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Litter Id') ?></th>
            <td><?= h($litter->litter_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Plan') ?></th>
            <td><?= $litter->has('plan') ? $this->Html->link($litter->plan->id, ['controller' => 'Plans', 'action' => 'view', $litter->plan->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cage') ?></th>
            <td><?= h($litter->cage) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Breed') ?></th>
            <td><?= $litter->has('breed') ? $this->Html->link($litter->breed->name, ['controller' => 'Breeds', 'action' => 'view', $litter->breed->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Bred') ?></th>
            <td><?= h($litter->date_bred) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Born') ?></th>
            <td><?= h($litter->date_born) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($litter->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($litter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('No Live Kits') ?></th>
            <td><?= $this->Number->format($litter->no_live_kits) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('No Dead Kits') ?></th>
            <td><?= $this->Number->format($litter->no_dead_kits) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('No Kits') ?></th>
            <td><?= $this->Number->format($litter->no_kits) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Buck') ?></th>
            <td><?= $this->Number->format($litter->buck) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Doe') ?></th>
            <td><?= $this->Number->format($litter->doe) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creator') ?></th>
            <td><?= $this->Number->format($litter->creator) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= $this->Number->format($litter->deleted) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Litters') ?></h4>
        <?php if (!empty($litter->litters)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Litter Id') ?></th>
                <th scope="col"><?= __('Plan Id') ?></th>
                <th scope="col"><?= __('No Live Kits') ?></th>
                <th scope="col"><?= __('No Dead Kits') ?></th>
                <th scope="col"><?= __('No Kits') ?></th>
                <th scope="col"><?= __('Cage') ?></th>
                <th scope="col"><?= __('Breed Id') ?></th>
                <th scope="col"><?= __('Buck') ?></th>
                <th scope="col"><?= __('Doe') ?></th>
                <th scope="col"><?= __('Date Bred') ?></th>
                <th scope="col"><?= __('Date Born') ?></th>
                <th scope="col"><?= __('Creator') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($litter->litters as $litters): ?>
            <tr>
                <td><?= h($litters->id) ?></td>
                <td><?= h($litters->litter_id) ?></td>
                <td><?= h($litters->plan_id) ?></td>
                <td><?= h($litters->no_live_kits) ?></td>
                <td><?= h($litters->no_dead_kits) ?></td>
                <td><?= h($litters->no_kits) ?></td>
                <td><?= h($litters->cage) ?></td>
                <td><?= h($litters->breed_id) ?></td>
                <td><?= h($litters->buck) ?></td>
                <td><?= h($litters->doe) ?></td>
                <td><?= h($litters->date_bred) ?></td>
                <td><?= h($litters->date_born) ?></td>
                <td><?= h($litters->creator) ?></td>
                <td><?= h($litters->created) ?></td>
                <td><?= h($litters->deleted) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Litters', 'action' => 'view', $litters->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Litters', 'action' => 'edit', $litters->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Litters', 'action' => 'delete', $litters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $litters->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
