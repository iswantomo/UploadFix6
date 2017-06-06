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

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider_hasil = $searchModel->searchHasil(Yii::$app->request->queryParams);

        $jadwal_kelas= JadwalKelas::findOne($id);
		if ($jadwal_kelas == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider_hasil' => $dataProvider_hasil,
			'jadwal_kelas' => $jadwal_kelas,
        ]);
    }

    /**
     * Displays a single Mahasiswa model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
		$mahasiswa=$this->findModel($id);

		/*
		Yii::$app->view->params['kunci_jawaban'] = '';
		$this->view->params['kunci_jawaban'] = $this->kunci_jawaban($mahasiswa->jadwal_kelas_id);

		Yii::$app->view->params['jawaban_siswa'] = '';
		$this->view->params['jawaban_siswa'] = $this->jawaban_siswa($mahasiswa->id);
		*/
		
		$sql="select count(*) from kunci_jawaban where jadwal_kelas_id='".$mahasiswa->jadwal_kelas_id."' AND tipe_soal='".$mahasiswa->tipe_soal."'";
		$jumlah_soal=Yii::$app->db->createCommand($sql)->queryScalar();

        return $this->render('view', [
			'mahasiswa' => $mahasiswa,
			'jumlah_soal' => $jumlah_soal,
			'kunci_jawaban' => $this->kunci_jawaban($mahasiswa->jadwal_kelas_id,$mahasiswa->tipe_soal),
			'jawaban_siswa' => $this->jawaban_siswa($mahasiswa->id),
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
}