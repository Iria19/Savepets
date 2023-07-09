<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FeatureFixture
 */
class FeatureFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'feature';
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
                'key_feature' => 'work',
            ],
            [
                'id' => 2,
                'key_feature' => 'studies',
            ],            [
                'id' => 3,
                'key_feature' => 'marital status',
            ],            [
                'id' => 4,
                'key_feature' => 'children',
            ],            [
                'id' => 5,
                'key_feature' => 'housing type',
            ],            [
                'id' => 6,
                'key_feature' => 'other pets',
            ],            [
                'id' => 7,
                'key_feature' => 'numpets',
            ],            [
                'id' => 8,
                'key_feature' => 'gender',
            ],
        ];
        parent::init();
    }
}
