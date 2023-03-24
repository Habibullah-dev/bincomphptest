<?php

namespace app\models;

use app;
use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use ruskid\YiiBehaviors\IpBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "announced_pu_results".
 *
 * @property int $result_id
 * @property int $polling_unit_uniqueid
 * @property string $party_abbreviation
 * @property int $party_score
 * @property string $entered_by_user
 * @property string $date_entered
 * @property string $user_ip_address
 *
 * @property PollingUnit $pollingUnitUnique
 */
class AnnouncedPuResults extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announced_pu_results';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['polling_unit_uniqueid', 'party_abbreviation', 'party_score', 'entered_by_user'], 'required'],
            [['polling_unit_uniqueid', 'party_score'], 'integer'],
            [['date_entered'], 'safe'],
            [['party_abbreviation'], 'string', 'max' => 4],
            [['entered_by_user', 'user_ip_address'], 'string', 'max' => 50],
            [['polling_unit_uniqueid'], 'exist', 'skipOnError' => true, 'targetClass' => PollingUnit::class, 'targetAttribute' => ['polling_unit_uniqueid' => 'uniqueid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'result_id' => 'Result ID',
            'polling_unit_uniqueid' => 'Polling Unit',
            'party_abbreviation' => 'Party Abbreviation',
            'party_score' => 'Party Score',
            'entered_by_user' => 'Entered By User',
            'date_entered' => 'Date Entered',
            'user_ip_address' => 'User Ip Address',
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date_entered',

                ],
                'value' => new Expression('Now()'),
            ],
            [
                'class' => IpBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['user_ip_address'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'user_ip_address',
                ],
            ]
        ];
    }

    /**
     * Gets query for [[PollingUnitUnique]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPollingUnit()
    {
        return $this->hasOne(PollingUnit::class, ['uniqueid' => 'polling_unit_uniqueid']);
    }

    public function getPollingUnitLga()
    {
        return $this->hasOne(Lga::class, ['lga_id' => 'lga_id'])->via('pollingUnit');
    }
}
