<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Breeder Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $breeder_id
 * @property string|null $cage
 * @property string|null $color
 * @property int|null $breed_id
 * @property int|null $sex_id
 * @property string|null $weight
 * @property string|null $date_born
 * @property string|null $date_acquired
 * @property int|null $father
 * @property int|null $mother
 * @property int|null $creator
 * @property string|null $created
 * @property int|null $deleted
 *
 * @property \App\Model\Entity\Breeder[] $breeders
 * @property \App\Model\Entity\Breed $breed
 * @property \App\Model\Entity\Sex $sex
 */
class Breeder extends Entity
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
        'name' => true,
        'breeder_id' => true,
        'cage' => true,
        'color' => true,
        'breed_id' => true,
        'sex_id' => true,
        'weight' => true,
        'date_born' => true,
        'date_acquired' => true,
        'father' => true,
        'mother' => true,
        'creator' => true,
        'created' => true,
        'deleted' => true,
        'breeders' => true,
        'breed' => true,
        'sex' => true,
    ];
}
