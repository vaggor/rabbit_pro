<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Plan $plan
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Plan'), ['action' => 'edit', $plan->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Plan'), ['action' => 'delete', $plan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $plan->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Plans'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Plan'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Litters'), ['controller' => 'Litters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Litter'), ['controller' => 'Litters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="plans view large-9 medium-8 columns content">
    <h3><?= h($plan->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($plan->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($plan->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($plan->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Buck') ?></th>
            <td><?= $this->Number->format($plan->buck) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Doe') ?></th>
            <td><?= $this->Number->format($plan->doe) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creator') ?></th>
            <td><?= $this->Number->format($plan->creator) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= $this->Number->format($plan->deleted) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Litters') ?></h4>
        <?php if (!empty($plan->litters)): ?>
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
            <?php foreach ($plan->litters as $litters): ?>
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
