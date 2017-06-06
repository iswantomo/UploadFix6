<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kunci_jawaban".
 *
 * @property string $id
 * @property string $jadwal_kelas_id
 * @property integer $tipe_soal
 * @property integer $no_soal
 * @property integer $jawaban
 *
 * @property JadwalKelas $jadwalKelas
 */
class KunciJawaban extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $kode_ujian;
	
    public static function tableName()
    {
        return 'kunci_jawaban';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jadwal_kelas_id', 'tipe_soal', 'no_soal', 'jawaban'], 'required','on' => 'newKunciJawaban'],
            [['jadwal_kelas_id', 'tipe_soal', 'no_soal', 'jawaban'], 'integer'],
            [['jadwal_kelas_id'], 'exist', 'skipOnError' => true, 'targetClass' => JadwalKelas::className(), 'targetAttribute' => ['jadwal_kelas_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jadwal_kelas_id' => 'Jadwal Kelas ID',
            'tipe_soal' => 'Tipe Soal',
            'no_soal' => 'No Soal',
            'jawaban' => 'Jawaban',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJadwalKelas()
    {
        return $this->hasOne(JadwalKelas::className(), ['id' => 'jadwal_kelas_id']);
    }
}
