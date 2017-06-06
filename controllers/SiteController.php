<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Mahasiswa;
use app\models\FormUpload;
use app\models\JadwalKelas;
use app\models\JawabanSiswa;
use yii\db\Command;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(){
		$model=new JadwalKelas;
		$model->setScenario('prosesMahasiswa');
        if ($model->load(Yii::$app->request->post())){
			
			$model->nim=str_replace(' ', '', $model->nim);
			$model->nim=preg_replace('/\s+/', '', $model->nim);
			$model->kode_ujian=str_replace(' ', '', $model->kode_ujian);
			$model->kode_ujian=preg_replace('/\s+/', '', $model->kode_ujian);

			$jadwal_kelas=JadwalKelas::find()->where(['kode_ujian' => $model->kode_ujian,])->one();
			if($jadwal_kelas===null){
				$model->addError('kode_ujian','Kode Ujian Tidak Ditemukan');
			}else{
				$mhs= Mahasiswa::find()->where(['jadwal_kelas_id' => $jadwal_kelas->id,'nim' => $model->nim])->one();
				if($mhs===null){
					$sql="select nama from mahasiswa where nim='".$model->nim."' order by id desc";
					$nama_mhs=Yii::$app->db->createCommand($sql)->queryScalar();
					return $this->redirect(['identitas', 'jk_id' => $jadwal_kelas->id,'id' => $jadwal_kelas->id, 'nim' => $model->nim, 'nama' => $nama_mhs ]);
				}else{
					if($mhs->ip_address=='' || $mhs->ip_address==null){
						$is_ip_sudah_dipakai=Yii::$app->db->createCommand("select ip_address from mahasiswa where ip_address like '".$_SERVER['REMOTE_ADDR']."' and jadwal_kelas_id='".$jadwal_kelas->id."'")->queryScalar();
						if( empty($is_ip_sudah_dipakai)){
							Yii::$app->db->createCommand("update mahasiswa set ip_address='".$_SERVER['REMOTE_ADDR']."' where id='".$mhs->id."'")->execute();
						}else{
							throw new NotFoundHttpException('1 Komputer tidak bisa digunakan lebih dari 1 siswa/peserta, hubungi operator/teknisi ruang.');
						}
					}
						
					if($jadwal_kelas->jenis_ujian==1){
						return $this->redirect(['upload_mhs', 'id' => $mhs->id]);
					}else{
						return $this->redirect(['ljk', 'id' => $mhs->id]);
					}
				}

			}
		}

		$item_jadwal_kelas = ArrayHelper::map(JadwalKelas::find()
			->select(['kode_ujian',"concat(CONCAT(SUBSTRING(kode_ujian, 1,3), ' ',SUBSTRING(kode_ujian, 4,3), ' ', SUBSTRING(kode_ujian, 7,4)),' [ ',ruang_ujian,' - ',matakuliah,' ]') as ruang_ujian"])
			->where(['is_aktif'=>1])
			->all(), 'kode_ujian', 'ruang_ujian')
		;

        return $this->render('index', [
            'model' => $model,
			'item_jadwal_kelas' => $item_jadwal_kelas,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionIdentitas($jk_id,$nim,$nama=''){
        if ( ($jadwal_kelas = JadwalKelas::findOne($jk_id)) === null)
            throw new NotFoundHttpException('Jadwal Kelas Ujian tidak ditersedia');

		if( date('Y-m-d',strtotime($jadwal_kelas->tanggal )) != date('Y-m-d') )
			throw new NotFoundHttpException('Tanggal '.date('d M Y').' tidak ada ujian dengan kode : '.$jadwal_kelas->kode_ujian.'. Silakan hubungi operator ');

		if( $jadwal_kelas->is_aktif != 1 )
			throw new NotFoundHttpException('Kode Ujian '.$jadwal_kelas->kode_ujian.' masih belum dibuka. Silakan hubungi operator ');

		$is_ip_sudah_dipakai=Yii::$app->db->createCommand("select ip_address from mahasiswa where ip_address like '".$_SERVER['REMOTE_ADDR']."' and jadwal_kelas_id='".$jadwal_kelas->id."'")->queryScalar();
		if( ! empty($is_ip_sudah_dipakai))
			throw new NotFoundHttpException('1 Komputer tidak bisa digunakan lebih dari 1 siswa/peserta, hubungi operator/teknisi ruang.');			
			
		$model=new Mahasiswa;
		
		if($jadwal_kelas->jenis_ujian==1){
			$model->setScenario('newIdentitasUpload');
		}else{
			$model->setScenario('newIdentitas');
		}

        if ($model->load(Yii::$app->request->post()) ){
		
			$model->ip_address=$_SERVER['REMOTE_ADDR'];

			$model->jadwal_kelas_id=$jadwal_kelas->id;
			$model->nama=strtoupper(trim($model->nama));
			$model->nim=str_replace(' ', '', $model->nim);
			$model->nim=preg_replace('/\s+/', '', $model->nim);
			
			$sql="select id from mahasiswa where jadwal_kelas_id='".$jadwal_kelas->id."' and nim='".$model->nim."'";
			$id_mhs=Yii::$app->db->createCommand($sql)->queryScalar();
			if(empty($id_mhs)){
				if($model->save()){
					if($jadwal_kelas->jenis_ujian==1){
						return $this->redirect(['upload_mhs', 'id' => $model->id]);
					}else{
						return $this->redirect(['ljk', 'id' => $model->id]);
					}				
				}
			}else{
				$sql="select ip_address from mahasiswa where jadwal_kelas_id='".$jadwal_kelas->id."' and nim='".$model->nim."'";
				$ip_address=Yii::$app->db->createCommand($sql)->queryScalar();
				$this->cek_ip_address($mahasiswa);

				$sql="update mahasiswa set nama='".$model->nama."',tipe_soal='".$model->tipe_soal."' where jadwal_kelas_id='".$jadwal_kelas->id."' and nim='".$model->nim."'";
				Yii::$app->db->createCommand($sql)->execute();				
				
				//return $this->redirect(['ljk', 'id' => $id_mhs]);

				if($jadwal_kelas->jenis_ujian==1){
					return $this->redirect(['upload_mhs', 'id' => $id_mhs]);
				}else{
					return $this->redirect(['ljk', 'id' => $id_mhs]);
				}				
			}
			
		}
		
		$model->nim=$nim;
		$model->nama=empty($nama) ? '' : $nama;
		
        return $this->render('identitas', [
            'model' => $model,
			'jadwal_kelas' => $jadwal_kelas,
        ]);
    }

	public function actionLjk($id){
        if ( ($mahasiswa = Mahasiswa::findOne($id)) === null)
            return $this->redirect(['index']);

		$this->cek_ip_address($mahasiswa);
		
		$sql="select count(*) from kunci_jawaban where tipe_soal='".$mahasiswa->tipe_soal."' and jadwal_kelas_id='".$mahasiswa->jadwal_kelas_id."'";
		$jumlah_soal=Yii::$app->db->createCommand($sql)->queryScalar();
		
		if (Yii::$app->request->post()){
			
		}
		
        return $this->render('ljk', [
            //'model' => $model,
			'mahasiswa' => $mahasiswa,
			'jumlah_soal' => $jumlah_soal,
        ]);		
	}

	public function actionUpload_mhs($id){
        if ( ($mahasiswa = Mahasiswa::findOne($id)) === null)
            return $this->redirect(['index']);

        if ( ($jadwal_kelas = JadwalKelas::findOne($mahasiswa->jadwal_kelas_id)) === null)
            throw new NotFoundHttpException('Jadwal Kelas Ujian tidak ditersedia');

		if( date('Y-m-d',strtotime($mahasiswa->jadwalKelas->tanggal )) != date('Y-m-d') )
			throw new NotFoundHttpException('Tanggal '.date('d M Y').' tidak ada ujian dengan kode : '.$jadwal_kelas->kode_ujian.'. Silakan hubungi operator ');

		if( $mahasiswa->jadwalKelas->is_aktif != 1 )
			throw new NotFoundHttpException('Kode Ujian '.$jadwal_kelas->kode_ujian.' masih belum dibuka. Silakan hubungi operator ');

		$this->cek_ip_address($mahasiswa);
		
		$sql="select count(*) from kunci_jawaban where tipe_soal='".$mahasiswa->tipe_soal."' and jadwal_kelas_id='".$mahasiswa->jadwal_kelas_id."'";
		$jumlah_soal=Yii::$app->db->createCommand($sql)->queryScalar();
		
		$mhs_upload=new FormUpload;
		$mhs_upload->setScenario('UploadMhs');

        if (Yii::$app->request->isPost) {
            $mhs_upload->file_mhs = UploadedFile::getInstance($mhs_upload, 'file_mhs');
            if ($mhs_upload->upload($mahasiswa->nim,$mahasiswa->jadwalKelas->kode_ujian)) {
                return $this->redirect(['upload_mhs','id'=>$id]);
            }
        }
		
        return $this->render('upload_mhs', [
            //'model' => $model,
			'mahasiswa' => $mahasiswa,
			'mhs_upload' => $mhs_upload,
			'jumlah_soal' => $jumlah_soal,
        ]);		
	}
	
	public function cek_ip_address($model_mahasiswa){
		if ($model_mahasiswa->ip_address != $_SERVER['REMOTE_ADDR'])
			throw new NotFoundHttpException('Tidak diijinkan untuk pindah komputer, silakan hubungi operator/teknisi '.$model_mahasiswa->jadwalKelas->ruang_ujian.' untuk me-reset !');
	}

    public function actionTes($idmhs,$nomer,$jawaban)
    {
        if ( ($mahasiswa = Mahasiswa::findOne($idmhs)) === null)
            return $this->redirect(['index']);
		
		$this->cek_ip_address($mahasiswa);

		$jawaban_siswa=JawabanSiswa::findOne([
			'mahasiswa_id'=>$idmhs,
			'no_soal'=>$nomer,
		]);
				
		if(empty($jawaban_siswa)){
			$jawaban_siswa=new JawabanSiswa();
			$jawaban_siswa->mahasiswa_id=$idmhs;
			$jawaban_siswa->no_soal=$nomer;
			$jawaban_siswa->jawaban=$jawaban;
			$jawaban_siswa->ip_address=$_SERVER['REMOTE_ADDR'];
			$jawaban_siswa->save();
		}else{
			$jawaban_siswa->jawaban=$jawaban;
			$jawaban_siswa->ip_address=$_SERVER['REMOTE_ADDR'];
			$jawaban_siswa->save();
		}
		
		$jwb=array('[]','[A]','[B]','[C]','[D]','[E]');
		echo "No. $nomer ".$jwb[$jawaban]." - Tersimpan";
    }

}
