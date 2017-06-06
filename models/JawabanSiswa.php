<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jawaban_siswa".
 *
 * @property string $id
 * @property string $mahasiswa_id
 * @property integer $no_soal
 * @property integer $jawaban
 * @property string $ip_address
 *
 * @property Mahasiswa $mahasiswa
 */
class JawabanSiswa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jawaban_siswa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mahasiswa_id', 'no_soal', 'jawaban'], 'required'],
            [['mahasiswa_id', 'no_soal', 'jawaban'], 'integer'],
            [['ip_address'], 'string', 'max' => 255],
            [['mahasiswa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mahasiswa::className(), 'targetAttribute' => ['mahasiswa_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mahasiswa_id' => 'Mahasiswa ID',
            'no_soal' => 'No Soal',
            'jawaban' => 'Jawaban',
            'ip_address' => 'Ip Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMahasiswa()
    {
        return $this->hasOne(Mahasiswa::className(), ['id' => 'mahasiswa_id']);
    }
}
