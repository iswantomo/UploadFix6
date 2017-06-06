<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\KunciJawaban;
use app\models\JadwalKelas;
use app\models\SearchKunciJawaban;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Command;
/**
 * Kunci_jawabanController implements the CRUD actions for KunciJawaban model.
 */
class Kunci_jawabanController extends Controller
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
					'clientOptions' => ['method' => 'POST'],
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all KunciJawaban models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchKunciJawaban();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KunciJawaban model.
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
     * Creates a new KunciJawaban model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($jk_id)
    {
		$no_soal='';
		
        if ( ($jadwal_kelas = JadwalKelas::findOne($jk_id)) === null)
            throw new NotFoundHttpException('The requested page does not exist.');

        $searchModel = new SearchKunciJawaban();

        $model = new KunciJawaban();
		$model->setScenario('newKunciJawaban');
		
		$model->jadwal_kelas_id=$jadwal_kelas->id;
		$model->no_soal=(int)$model->no_soal;
		$model->tipe_soal=(int)$model->tipe_soal;

        if ($model->load(Yii::$app->request->post()) ){
			//cek avaiable
			$sql="select id from kunci_jawaban where jadwal_kelas_id='$jk_id' and tipe_soal='".$model->tipe_soal."' and no_soal='".$model->no_soal."'";
			$id_kunci_jawaban=Yii::$app->db->createCommand($sql)->queryScalar();
			if(empty($id_kunci_jawaban)){
				$model->save();
			}else{
				//jika data ditemukan, update kunci jawaban.
				$sql="update kunci_jawaban set jawaban='".$model->jawaban."' where id='".$id_kunci_jawaban."' ";
				$cek_aviable=Yii::$app->db->createCommand($sql)->execute();
			}
			$model->no_soal=$model->no_soal + 1;
		}

		$searchModel->jadwal_kelas_id=$jk_id;
		
		
		return $this->render('create', [
			'model' => $model,
			'jadwal_kelas' => $jadwal_kelas,
			'searchModel' => $searchModel,
		]);
    }

    /**
     * Updates an existing KunciJawaban model.
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
     * Deletes an existing KunciJawaban model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
		$model->delete();

        return $this->redirect(['create','jk_id'=>$model->jadwal_kelas_id]);
    }

    /**
     * Finds the KunciJawaban model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return KunciJawaban the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KunciJawaban::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	public function data_tipe_soal(){
		return array(
			'1'=>'1',
			'2'=>'2',
			'3'=>'3',
			'4'=>'4',
			'5'=>'5',
			'6'=>'6',
			'7'=>'7',
			'8'=>'8',
			'9'=>'9',
			'10'=>'10',
		);
	}

	public function data_jawaban(){
		return array(
			'1'=>'[A]',
			'2'=>'[B]',
			'3'=>'[C]',
			'4'=>'[D]',
			'5'=>'[E]',
		);
	}

}
