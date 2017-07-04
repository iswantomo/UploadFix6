<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jadwal_kelas".
 *
 * @property string $id
 * @property string $kode_ujian
 * @property string $nama_dosen
 * @property string $matakuliah
 * @property string $prodi
 * @property string $ruang_ujian
 * @property string $tanggal
 *
 * @property KunciJawaban[] $kunciJawabans
 * @property Mahasiswa[] $mahasiswas
 */
class JadwalKelas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	public $nim;
	
    public static function tableName()
    {
        return 'jadwal_kelas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['kode_ujian', 'nama_dosen', 'matakuliah', 'prodi', 'ruang_ujian', 'tanggal'], 'required','on'=>'newjadwal'],
			[['kode_ujian', 'nim'], 'required','on'=>'prosesMahasiswa','message'=>'{attribute} tidak boleh kosong'],
            [['tanggal','is_aktif','batas_waktu','jenis_ujian','nilai_benar','nilai_salah'], 'safe'],
            [['kode_ujian', 'nama_dosen', 'matakuliah', 'prodi', 'ruang_ujian'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_ujian' => 'Token / Kode Ujian',
            'nama_dosen' => 'Dosen',
            'matakuliah' => 'Keterangan',//'Matakuliah',
            'prodi' => 'Prodi',
            'ruang_ujian' => 'Ruang Ujian',
            'tanggal' => 'Tanggal',
            'batas_waktu' => 'Batas Waktu',
            'jenis_ujian' => 'Jenis Ujian/Tes',
			'is_aktif' => 'Is Aktif',
			'nim' => 'NIM',
			'nilai_benar' => 'Nilai Benar',
			'nilai_salah' => 'Nilai Salah',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKunciJawabans()
    {
        return $this->hasMany(KunciJawaban::className(), ['jadwal_kelas_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMahasiswas()
    {
        return $this->hasMany(Mahasiswa::className(), ['jadwal_kelas_id' => 'id']);
    }

    public function TxtJenisUjian($id)
    {
		$data=array('-','Upload','Multiple Choice','Upload dan Multiple Choice');
		return $data[$id];
    }
}
