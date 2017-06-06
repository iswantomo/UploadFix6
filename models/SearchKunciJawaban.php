<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KunciJawaban;

/**
 * SearchKunciJawaban represents the model behind the search form about `app\models\KunciJawaban`.
 */
class SearchKunciJawaban extends KunciJawaban
{
    /**
     * @inheritdoc
     */
	
	public function rules()
    {
        return [
			[['kode_ujian'],'safe'],
            [['id', 'jadwal_kelas_id', 'tipe_soal', 'no_soal', 'jawaban'], 'integer'],
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
        $query = KunciJawaban::find()
		->leftJoin('jadwal_kelas jk','jk.id=kunci_jawaban.jadwal_kelas_id')
		;
		
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [ 'pageSize' => $query->count() ],
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
            'jadwal_kelas_id' => $this->jadwal_kelas_id,
            'tipe_soal' => $this->tipe_soal,
            'no_soal' => $this->no_soal,
            'jawaban' => $this->jawaban,
			'jk.kode_ujian' => $this->kode_ujian,
        ]);
		
		$query->orderBy([
			'tipe_soal' => SORT_ASC,
			'no_soal' => SORT_ASC,
		]);

        return $dataProvider;
    }
}
