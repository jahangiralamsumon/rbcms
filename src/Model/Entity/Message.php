<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity.
 *
 * @property int $msg_id
 * @property \App\Model\Entity\Msg $msg
 * @property string $subject
 * @property string $msg_content
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property \Cake\I18n\Time $msg_date
 * @property int $is_read
 * @property int $sender_id
 * @property \App\Model\Entity\Sender $sender
 * @property int $is_deleted
 */
class Message extends Entity
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
        '*' => true,
        'msg_id' => false,
    ];
}
