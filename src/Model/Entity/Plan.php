<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Plan Entity
 *
 * @property int $id
 * @property int|null $buck
 * @property int|null $doe
 * @property string|null $date
 * @property int|null $creator
 * @property string|null $created
 * @property int|null $deleted
 *
 * @property \App\Model\Entity\Litter[] $litters
 */
class Plan extends Entity
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
        'buck' => true,
        'doe' => true,
        'date' => true,
        'creator' => true,
        'created' => true,
        'deleted' => true,
        'litters' => true,
    ];
}
