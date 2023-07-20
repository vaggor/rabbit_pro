<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Litter Entity
 *
 * @property int $id
 * @property string|null $litter_id
 * @property int|null $plan_id
 * @property int|null $no_live_kits
 * @property int|null $no_dead_kits
 * @property int|null $no_kits
 * @property string|null $cage
 * @property int|null $breed_id
 * @property int|null $buck
 * @property int|null $doe
 * @property string|null $date_bred
 * @property string|null $date_born
 * @property int|null $creator
 * @property string|null $created
 * @property int|null $deleted
 *
 * @property \App\Model\Entity\Litter[] $litters
 * @property \App\Model\Entity\Plan $plan
 * @property \App\Model\Entity\Breed $breed
 */
class Litter extends Entity
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
        'litter_id' => true,
        'plan_id' => true,
        'no_live_kits' => true,
        'no_dead_kits' => true,
        'no_kits' => true,
        'cage' => true,
        'breed_id' => true,
        'buck' => true,
        'doe' => true,
        'date_bred' => true,
        'date_born' => true,
        'creator' => true,
        'created' => true,
        'deleted' => true,
        'litters' => true,
        'plan' => true,
        'breed' => true,
    ];
}
