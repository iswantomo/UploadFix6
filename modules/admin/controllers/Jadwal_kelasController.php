<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\JadwalKelas;
use app\models\SearchJadwalKelas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\db\Command;

/**
 * Jadwal_kelasController implements the CRUD actions for JadwalKelas model.
 */
class Jadwal_kelasController extends Controller
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
     * Lists all JadwalKelas models.
     * @return mixed
     */
    public function actionIndex()
    {
		return $this->redirect(['create']);
		/*
        $searchModel = new SearchJadwalKelas();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		*/
    }

    /**
     * Displays a single JadwalKelas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new JadwalKelas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pilihan='aktif')
    {
        $model = new JadwalKelas();
		$model->setScenario('newjadwal');
		
		$model->kode_ujian="".time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$path = 'uploads/'. $model->kode_ujian;
			FileHelper::createDirectory($path);
            return $this->redirect(['create']);
        } else {
			$searchModel = new SearchJadwalKelas();
			if($pilihan=='aktif'){
				$searchModel->is_aktif='1';
			}else if($pilihan=='standby'){
				$searchModel->is_aktif='0';
				$searchModel->tanggal=date('Y-m-d');
			}
			
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);			

            return $this->render('create', [
                'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'pilihan' => $pilihan,
            ]);
        }
    }

    /**
     * Updates an existing JadwalKelas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->setScenario("newjadwal");

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				$path = 'uploads/'. $model->kode_ujian;
				FileHelper::createDirectory($path);
	            return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing JadwalKelas model.
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
     * Finds the JadwalKelas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return JadwalKelas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JadwalKelas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	function is_dir_empty($dir) {
		if (!is_readable($dir)) 
			return NULL; 
		
		return (count(scandir($dir)) == 2);
	}

	 public function actionKompres_file($kode_ujian){
		if (!is_dir("uploads/".$kode_ujian."/"))
			throw new NotFoundHttpException('folder tidak ada');

		if ($this->is_dir_empty("uploads/".$kode_ujian."/"))
			throw new NotFoundHttpException('Isi folder Kosong');
	 
	 	$this->zipfolder("uploads/".$kode_ujian."/");
		//copy("upload/file.zip", "upload/".$namafolder."/file.zip");
		copy("uploads/file.zip", "uploads/".$kode_ujian."/".$kode_ujian.".zip");
		//return $this->redirect(['create']);
		
		$sql="update jadwal_kelas set is_aktif='0' where kode_ujian='".$kode_ujian."'";
		Yii::$app->db->createCommand($sql)->execute();
		
        return $this->render('kompres_file', [
            'kode_ujian' => $kode_ujian,
        ]);
	 }

	public function zipfolder($nama_dir){	
		$rootPath = realpath($nama_dir);
		
		// Initialize archive object
		$zip = new \ZipArchive();
		$zip->open('uploads/file.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
		
		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($rootPath),
			\RecursiveIteratorIterator::LEAVES_ONLY
		);
		
		foreach ($files as $name => $file)
		{
			// Skip directories (they would be added automatically)
			if (!$file->isDir())
			{
				// Get real and relative path for current file
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
		
				// Add current file to archive
				$zip->addFile($filePath, $relativePath);
			}
		}
		
		// Zip archive will be created only after closing object
		$zip->close();	
	}

}
