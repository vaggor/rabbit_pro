<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property string|null $phone_no
 * @property int|null $asssoc_acct_id
 * @property int|null $status_id
 * @property int|null $usergroup_id
 * @property string|null $created
 * @property int|null $deleted
 *
 * @property \App\Model\Entity\AsssocAcct $asssoc_acct
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\Usergroup $usergroup
 */
class User extends Entity
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
        'email' => true,
        'password' => true,
        'phone_no' => true,
        'asssoc_acct_id' => true,
        'status_id' => true,
        'usergroup_id' => true,
        'created' => true,
        'deleted' => true,
        'asssoc_acct' => true,
        'status' => true,
        'usergroup' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}
