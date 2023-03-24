<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AnnouncedPuResults;

/**
 * AnnouncedPuResultsSearch represents the model behind the search form of `app\models\AnnouncedPuResults`.
 */
class AnnouncedPuResultsSearch extends AnnouncedPuResults
{
    /**
     * {@inheritdoc}
     */

    public $lga_id;

    public function rules()
    {
        return [
            [['result_id', 'polling_unit_uniqueid', 'party_score', 'lga_id'], 'integer'],
            [['party_abbreviation', 'entered_by_user', 'date_entered', 'user_ip_address'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AnnouncedPuResults::find()->joinWith('pollingUnit');

        // add conditions that should always apply here

        $queryCount = clone $query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $queryCount->count(),
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'result_id' => $this->result_id,
            'polling_unit_uniqueid' => $this->polling_unit_uniqueid,
            'party_score' => $this->party_score,
            'date_entered' => $this->date_entered,
        ]);

        $query->andFilterWhere(['like', 'party_abbreviation', $this->party_abbreviation])
            ->andFilterWhere(['like', 'entered_by_user', $this->entered_by_user])
            ->andFilterWhere(['like', 'user_ip_address', $this->user_ip_address]);

        /// Yii::error($dataProvider->getModels())


        return $dataProvider;
    }

    public function lgaResultsearch($params)
    {
        $query = AnnouncedPuResults::find()
            ->select('announced_pu_results.* ,polling_unit.lga_id')
            ->joinWith('pollingUnit')
            ->orderBy('polling_unit.lga_id');

        // add conditions that should always apply here

        $queryCount = clone $query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $query->count(),
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        if ($this->lga_id > 0) {
            $query->andFilterWhere([
                'polling_unit.lga_id' => $this->lga_id,
            ]);
        } else {
            $query->andFilterWhere([
                'result_id' => $this->result_id,
                'polling_unit_uniqueid' => $this->polling_unit_uniqueid,
                'party_score' => $this->party_score,
                'date_entered' => $this->date_entered,
            ]);
        }

        // $query->andFilterWhere(['like', 'polling_unit.lga_id', $this->party_abbreviation]);
        // ->andFilterWhere(['like', 'entered_by_user', $this->entered_by_user])
        // ->andFilterWhere(['like', 'user_ip_address', $this->user_ip_address]);

        Yii::error($query->createCommand()->sql);


        return $dataProvider;
    }
}
