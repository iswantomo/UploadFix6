<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JadwalKelas;

/**
 * SearchJadwalKelas represents the model behind the search form about `app\models\JadwalKelas`.
 */
class SearchJadwalKelas extends JadwalKelas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['kode_ujian', 'nama_dosen', 'matakuliah', 'prodi', 'ruang_ujian', 'tanggal', 'is_aktif', 'jenis_ujian'], 'safe'],
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
        $query = JadwalKelas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        ]);

        $query->andFilterWhere(['like', 'kode_ujian', $this->kode_ujian])
            ->andFilterWhere(['like', 'nama_dosen', $this->nama_dosen])
            ->andFilterWhere(['like', 'matakuliah', $this->matakuliah])
            ->andFilterWhere(['like', 'prodi', $this->prodi])
            ->andFilterWhere(['like', 'ruang_ujian', $this->ruang_ujian])
            ->andFilterWhere(['like', 'tanggal', $this->tanggal])
            ->andFilterWhere(['like', 'is_aktif', $this->is_aktif])
            ->andFilterWhere(['like', 'jenis_ujian', $this->jenis_ujian])
			->orderBy(['id' => SORT_DESC])
			;

        return $dataProvider;
    }
}
