<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class FormUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $file_mhs;

    public function rules()
    {
        return [
			[['file_mhs'], 'required','on' => 'UploadMhs','message'=>'File tidak boleh kosong'],
			[['file_mhs'], 'file', 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
			'file_mhs' => 'Upload File Jawaban',
        ];
    }

    public function upload($nim,$kode_ujian)
    {
        if ($this->validate()) {
			$namafile=$nim . '_' . $this->file_mhs->baseName . '.' . $this->file_mhs->extension;
			$namafile=str_replace(' ','_',$namafile);
            $this->file_mhs->saveAs('uploads/'.$kode_ujian.'/' . $namafile);
            return true;
        } else {
            return false;
        }
    }
}