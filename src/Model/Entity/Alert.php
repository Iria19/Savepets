<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Alert Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $country
 * @property string|null $province
 * @property string|null $specie
 * @property string|null $race
 * @property \Cake\I18n\FrozenTime $creation_date
 * @property string $active
 * @property string $title
 *
 * @property \App\Model\Entity\User $user
 */
class Alert extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'country' => true,
        'province' => true,
        'specie' => true,
        'race' => true,
        'creation_date' => true,
        'active' => true,
        'title' => true,
        'user' => true,
    ];
}
