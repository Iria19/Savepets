<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FeatureUserFixture
 */
class FeatureUserFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'feature_user';
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
                'feature_id' => 1,
                'value' => 'Lorem',
            ],            [
                'id' => 2,
                'user_id' => 1,
                'feature_id' => 2,
                'value' => 'Lorem',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'feature_id' => 3,
                'value' => 'single',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'feature_id' => 4,
                'value' => 2,
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'feature_id' => 5,
                'value' => 'flat',
            ],
            [
                'id' =>6,
                'user_id' => 1,
                'feature_id' => 6,
                'value' => 'dog',
            ],
            [
                'id' =>7,
                'user_id' => 1,
                'feature_id' => 7,
                'value' => 2,
            ],
            [
                'id' =>8,
                'user_id' => 1,
                'feature_id' => 8,
                'value' => '',
            ],
        ];
        parent::init();
    }
}
