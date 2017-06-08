<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\JadwalKelas;
use app\models\Mahasiswa;
use app\models\SearchMahasiswa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\JawabanSiswa;
use app\models\SearchJawabanSiswa;
use app\models\KunciJawaban;

/**
 * MahasiswaController implements the CRUD actions for Mahasiswa model.
 */
class MahasiswaController extends Controller
{
    /**
     * @inheritdoc
     */
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Mahasiswa models.
     * @return mixed
     */
    public function actionIndex($id='')
    {

        $searchModel = new SearchMahasiswa();
		$searchModel->jadwal_kelas_id=$id;

        $dataProvider_Ipaddress = $searchModel->searchIpaddress(Yii::$app->request->queryParams);
		$dataProvider_hasil = $searchModel->searchHasil(Yii::$app->request->queryParams);

        $jadwal_kelas= JadwalKelas::findOne($id);
		if ($jadwal_kelas == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider_Ipaddress' => $dataProvider_Ipaddress,
            'dataProvider_hasil' => $dataProvider_hasil,
			'jadwal_kelas' => $jadwal_kelas,
        ]);
    }

    /**
     * Displays a single Mahasiswa model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id,$refresh=0)
    {
		$mahasiswa=$this->findModel($id);

		$sql="select count(*) from kunci_jawaban where jadwal_kelas_id='".$mahasiswa->jadwal_kelas_id."' AND tipe_soal='".$mahasiswa->tipe_soal."'";
		$jumlah_soal=Yii::$app->db->createCommand($sql)->queryScalar();

		$kunci_jawaban = $this->kunci_jawaban($mahasiswa->jadwal_kelas_id,$mahasiswa->tipe_soal);
		$jawaban_siswa = $this->jawaban_siswa($mahasiswa->id);

		$jwb_siswa=['','A','B','C','D','E'];
		$kunci=['','.',':',':.','::','::.'];
		$benar=0;$salah=0;$tdk_diisi=0;
		$total_skor=0;
		$list_jawaban="";
		for($i=1;$i<=$jumlah_soal;$i++){
			if(empty($kunci_jawaban[$i])){
				$benar=$benar + 1;
			}else{
				if(empty($jawaban_siswa[$i])){
					$tdk_diisi=$tdk_diisi+1;
				}else{
					if($kunci_jawaban[$i] == $jawaban_siswa[$i] ){
						$benar=$benar + 1;
					}else{
						$salah=$salah + 1;
					}			
				}
			}
		
			$title=(empty($kunci_jawaban[$i]) ? '#' : $kunci[$kunci_jawaban[$i]]);
			$list_jawaban .= "<div title='$title' >No. ".$i." ".(empty($jawaban_siswa[$i]) ? '-':"[".$jwb_siswa[$jawaban_siswa[$i]]."]")."</div>";
		}
		$skor_benar=$benar * $mahasiswa->jadwalKelas->nilai_benar;
		$skor_salah=$salah * $mahasiswa->jadwalKelas->nilai_salah;
		$nilai=$skor_benar + $skor_salah;

		$mahasiswa->benar=$benar;
		$mahasiswa->salah=$salah;
		$mahasiswa->tidak_menjawab=$tdk_diisi;
		$mahasiswa->skor=$nilai;
		$mahasiswa->save();

		if($refresh==1)
			return $this->redirect(['index', 'id' => $mahasiswa->jadwal_kelas_id]);


        return $this->render('view', [
			'mahasiswa' => $mahasiswa,
			'jumlah_soal' => $jumlah_soal,
			'list_jawaban' => $list_jawaban,
        ]);
    }

    /**
     * Creates a new Mahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mahasiswa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mahasiswa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Mahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mahasiswa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function kunci_jawaban($jadwal_kelas_id,$tipe_soal){
		$model=KunciJawaban::find()
			->where([
				'jadwal_kelas_id' => $jadwal_kelas_id,
				'tipe_soal' => $tipe_soal,
			])
			->orderBy(['no_soal'=>SORT_ASC])
			->all()
		;
		$tmp=array();
		foreach($model as $data){
			$tmp[$data->no_soal]=$data->jawaban;
		}
		return $tmp;
	}

	public function jawaban_siswa($mahasiswa_id){
		$model = JawabanSiswa::find()
			->where(['mahasiswa_id'=>$mahasiswa_id])
			->orderBy(['no_soal'=>SORT_ASC])
			->all()
		;
		$tmp=array();
		foreach($model as $data){
			$tmp[$data->no_soal]=$data->jawaban;
		}
		return $tmp;
	}

    public function actionReset_ip($id){
		$mahasiswa=$this->findModel($id);
		$mahasiswa->ip_address = null;
		$mahasiswa->save();
		$this->redirect(['index', 'id' => $mahasiswa->jadwal_kelas_id]);
	}

    public function actionHapusfile($nama_file,$kode_ujian,$id){
		rename("uploads/".$kode_ujian."/". $nama_file,"uploads/sampah_file/".$kode_ujian . "_" . $nama_file);
		$this->redirect(['index', 'id' => $id]);
	}

	public function actionXls($id){
        $searchModel = new SearchMahasiswa();
		$searchModel->jadwal_kelas_id=$id;

		$dataProvider = $searchModel->searchHasil(Yii::$app->request->queryParams);

        $jadwal_kelas= JadwalKelas::findOne($id);
		if ($jadwal_kelas == null)
            throw new NotFoundHttpException('jadwal kelas does not exist.');

		$link_download = "xls_pilihan_ganda/".$jadwal_kelas->kode_ujian."_".$jadwal_kelas->matakuliah.".xls";

        return $this->render('xls', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'link_download' => $link_download,
        ]);		
	}
}
