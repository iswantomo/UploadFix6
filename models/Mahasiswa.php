<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mahasiswa".
 *
 * @property string $id
 * @property string $jadwal_kelas_id
 * @property string $nim
 * @property string $nama
 * @property string $ip_address
 *
 * @property JawabanSiswa[] $jawabanSiswas
 * @property JadwalKelas $jadwalKelas
 */
class Mahasiswa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $pernyataan;
	
    public static function tableName()
    {
        return 'mahasiswa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jadwal_kelas_id', 'tipe_soal', 'nama', 'nim', 'pernyataan'], 'required','on' => 'newIdentitas','message'=>'{attribute} tidak boleh kosong'],
			[['jadwal_kelas_id', 'nama', 'pernyataan'], 'required','on' => 'newIdentitasUpload','message'=>'{attribute} tidak boleh kosong'],
            [['id', 'jadwal_kelas_id','tipe_soal'], 'integer'],
            [['nim', 'nama', 'ip_address'], 'string', 'max' => 255],
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
            'nim' => 'Nim',
            'nama' => 'Nama Mahasiswa / Peserta',
            'ip_address' => 'Ip Address',
            'skor' => 'Nilai / Skor',
			'pernyataan' => 'Saya menyatakan data diatas adalah benar, dan siap diberi sanksi jika melakukan kecurangan.',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::className(), ['mahasiswa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJadwalKelas()
    {
        return $this->hasOne(JadwalKelas::className(), ['id' => 'jadwal_kelas_id']);
    }

}
