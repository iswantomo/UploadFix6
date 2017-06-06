<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\modules\admin\controllers\Kunci_jawabanController;
use yii\db\Command;

$this->title = 'LJK';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-kelas-form">
    <div class="col-md-4">
			<h2 style="padding:0px; margin:0px;">Jadwal Ujian</h2>
    		<hr />
            <label>Kode Ujian : </label> <?= $mahasiswa->jadwalKelas->kode_ujian ?> &nbsp; &nbsp;<br />
            <label>Batas Waktu : </label> <?= date('d M Y H:i:s',strtotime($mahasiswa->jadwalKelas->batas_waktu)) ?><br /><br />
    
            <label>Nama Dosen : </label> <?= $mahasiswa->jadwalKelas->nama_dosen ?> &nbsp; &nbsp;<br />
            <label>Matakuliah : </label> <?= $mahasiswa->jadwalKelas->matakuliah ?><br />
            
            <label>Prodi : </label> <?= $mahasiswa->jadwalKelas->prodi ?> &nbsp; &nbsp;<br />
            <div style="clear:both"></div>
            <hr />
            Histori Jawaban : <br />
            <textarea id="log_jawab" rows="7" cols="30" style="font-size:11px;padding:0px 15px 15px 15px;" readonly="readonly"></textarea>
    </div>

    <div class="col-md-8">
    	<div class="col-md-9">        
            <h2 style="padding:0px; margin:0px;">Lembar Jawaban</h2>
            <label>NIM / Nama : </label> <?= $mahasiswa->nim ." / " .  $mahasiswa->nama ?> &nbsp; &nbsp;<br />
            <label>Tipe Soal : </label> <?= $mahasiswa->tipe_soal ?> [ <?= $jumlah_soal ?> Soal ]
		</div>
        <div class="col-md-3">
			<?php $form = ActiveForm::begin(); ?>
                <div class="form-group">
                    <?= Html::submitButton('Selesai', ['class' => 'btn btn-success']) ?>
                </div>        
            <?php ActiveForm::end(); ?>
        </div>
        <div style="clear:both"></div>
        <hr />
		<?php $no=0; ?>
        <?php for($col=1;$col<=6; $col++){ ?>
            <div class="col-md-2">            
                <?php				
                for($i=1; $i<=10; $i++){
                    $no++;
                    $onchange="simpan_jawaban(".$mahasiswa->id.",".$no.",$(this).val())";
					$jwb=Yii::$app->db->createCommand("select jawaban from jawaban_siswa where mahasiswa_id='".$mahasiswa->id."' and no_soal='".$no."'")->queryScalar();
                    echo "
                        <div style='padding:5px;'>
							".($no <= $jumlah_soal ? 
								($no<=9 ? ' &nbsp; ' : '').$no."&nbsp; ".(Html::dropDownList("jawaban_nomer[".$no."]",$jwb,[':::','[A]','[B]','[C]','[D]','[E]'],[ 'id'=>'jawaban_nomer_'.$no,'onchange'=>$onchange] ))
							:
								($no<=9 ? ' &nbsp; ' : '').$no." - "
							).
                        "</div>
                    ";
                }
                ?>
            </div>
        <?php }?>
        
    </div>
</div>

<script>
function simpan_jawaban(idmhs,nomer,jawaban){
	var round = Math.round;
	var txt_lama;
	$('#jawaban_nomer_'+nomer).attr("disabled","disabled");

	if(round(idmhs)!=0 || round(nomer)!=0 || round(jawaban)!=0){	
		$.ajax({
		  type: "GET",
		  url: "<?= Yii::$app->urlManager->createUrl('site/tes'); ?>",
		  data: {idmhs : idmhs, nomer:nomer, jawaban:jawaban},
		  //cache: false,
		  success: function(data){
			 txt_lama=$('#log_jawab').html();
			 $("#log_jawab").text('\n'+data+' '+txt_lama);
			 $("#log_jawab").focus();
			 $("#jawaban_nomer_"+nomer).removeAttr('disabled');
		  }
		});
	}
}
</script>