<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JawabanSiswa;

/**
 * SearchJawabanSiswa represents the model behind the search form about `app\models\JawabanSiswa`.
 */
class SearchJawabanSiswa extends JawabanSiswa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mahasiswa_id', 'no_soal', 'jawaban'], 'integer'],
            [['mahasiswa_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = JawabanSiswa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 100,
			],
			'sort' => [
				'defaultOrder' => [
					'no_soal' => SORT_ASC,
				],
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
            'id' => $this->id,
            'mahasiswa_id' => $this->mahasiswa_id,
            'no_soal' => $this->no_soal,
            'jawaban' => $this->jawaban,
        ]);

        $query->andFilterWhere(['like', 'ip_address', $this->ip_address]);

        return $dataProvider;
    }

    public function searchAdmin($params,$mahasiswa_id)
    {
        $query = JawabanSiswa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 100,
			],
			'sort' => [
				'defaultOrder' => [
					'no_soal' => SORT_ASC,
				],
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
            'id' => $this->id,
            'mahasiswa_id' => $mahasiswa_id,
            'no_soal' => $this->no_soal,
            'jawaban' => $this->jawaban,
        ]);

        //$query->andFilterWhere(['=', 'mahasiswa_id',$this->mahasiswa_id ]);

        return $dataProvider;
    }

}
