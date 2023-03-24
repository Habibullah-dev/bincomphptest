<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "announced_ward_results".
 *
 * @property int $result_id
 * @property string $ward_name
 * @property string $party_abbreviation
 * @property int $party_score
 * @property string $entered_by_user
 * @property string $date_entered
 * @property string $user_ip_address
 */
class AnnouncedWardResults extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announced_ward_results';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ward_name', 'party_abbreviation', 'party_score', 'entered_by_user', 'date_entered', 'user_ip_address'], 'required'],
            [['party_score'], 'integer'],
            [['date_entered'], 'safe'],
            [['ward_name', 'entered_by_user', 'user_ip_address'], 'string', 'max' => 50],
            [['party_abbreviation'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'result_id' => 'Result ID',
            'ward_name' => 'Ward Name',
            'party_abbreviation' => 'Party Abbreviation',
            'party_score' => 'Party Score',
            'entered_by_user' => 'Entered By User',
            'date_entered' => 'Date Entered',
            'user_ip_address' => 'User Ip Address',
        ];
    }
}
