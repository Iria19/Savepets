<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AlertFixture
 */
class AlertFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'alert';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'country' => 'España',
                'province' => 'Barcelona',
                'specie' => 'dog',
                'race' => 'Caniche',
                'creation_date' => '2023-02-26 23:17:48',
                'active' => 'yes',
                'title' => 'Alerta caniche',
            ],
        ];
        parent::init();
    }
}
