<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Schedule Entity
 *
 * @property int $id
 * @property int|null $schedule_type_id
 * @property string|null $name
 * @property string|null $date
 * @property int|null $icon_id
 * @property int|null $recurring_id
 * @property int|null $creator
 * @property string|null $created
 * @property int|null $deleted
 *
 * @property \App\Model\Entity\ScheduleType $schedule_type
 * @property \App\Model\Entity\Icon $icon
 * @property \App\Model\Entity\Recurring $recurring
 */
class Schedule extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'schedule_type_id' => true,
        'name' => true,
        'date' => true,
        'icon_id' => true,
        'recurring_id' => true,
        'creator' => true,
        'created' => true,
        'deleted' => true,
        'schedule_type' => true,
        'icon' => true,
        'recurring' => true,
    ];
}
