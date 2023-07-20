<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ledger Entity
 *
 * @property int $id
 * @property string|null $date
 * @property string|null $name
 * @property int|null $cat_id
 * @property int|null $ledger_type_id
 * @property string|null $amount
 * @property string|null $note
 * @property int|null $creator
 * @property string|null $created
 * @property int|null $deleted
 *
 * @property \App\Model\Entity\Cat $cat
 * @property \App\Model\Entity\LedgerType $ledger_type
 */
class Ledger extends Entity
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
        'date' => true,
        'name' => true,
        'cat_id' => true,
        'ledger_type_id' => true,
        'amount' => true,
        'note' => true,
        'creator' => true,
        'created' => true,
        'deleted' => true,
        'cat' => true,
        'ledger_type' => true,
    ];
}
