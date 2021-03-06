<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<h5>Laporan seleksi kompetisi | ITFest4.0 Universitas Sumatera Utara</h5>
			<hr>
		</div>
		<div class="container-fluid">
			<?php if ($reTahap): ?>
				<button class="btn btn-primary" id="tahapR">Kelolah Tahapan Seleksi</button>
			<?php endif ?>
			<?php if (count($reTahap)<1): ?>
				<center>Kompetisi ini belum memiliki tahapan seleksi <br> <button class="btn btn-primary" id="tahapP">Tambah Tahapan Seleksi</button></center>
			<?php endif ?>
		</div>
	</div>
	<div class="row" style="margin-top: 15px;">
		<?php if ($reTahap): ?>
		<?php $count=1; ?>
		<?php foreach ($reTahap as $key => $valreTahap): ?>
		<div class="col-12">
			<div class="card text-white mb-3" style="background-color: #7386D5">
	  			<div class="card-header" style="height: 80%;">
	  				<div class="float-left" style="padding-top: 5px;">
		  				<h5 class="">Tahapan Seleksi ke #<?php echo $count; ?></h5>
	  				</div>
	  				<div class="float-right">
	  					<button onclick="getSeleksi(<?php echo $valreTahap->id_tahap ?>)" class="btn btn-outline-light" data-toggle="collapse" data-target="#collapse<?php echo $count ?>" aria-expanded="true" aria-controls="collapse<?php echo $count ?>">
	  						Detil Seleksi
	  					</button>
	  				</div>
	  			</div>
	  			<div class="card-body collapse" id="collapse<?php echo $count ?>">
	  				<div class="row">
		  				<div class="col-12 col-md-6">
		  					<h5>Deskripsi</h5>
		  					<p style="color: white"><?php echo $valreTahap->deskripsi_tahap; ?></p>
		  					<h5>File Rule</h5>
		  					<p style="color: white"><a href="<?php echo base_url('public/kompetisi/tahap/'); echo $valreTahap->file_tahap ?>">Download File</a></p>
		  				</div>
		  				<div class="col-12 col-md-6">
		  					<div id="load<?php echo $valreTahap->id_tahap ?>">
		  					
			  				</div>
		  				</div>
	  				</div>
	  			</div>
			</div>
		</div>
		<?php $count++;  ?>
		<?php endforeach ?>
		<?php endif ?>
	</div>
</div>

<script type="text/javascript">
	$("#tahapR").click(function(event) {
        event.preventDefault();
        $('#loading').show();
        $('#contentPage').addClass('lodtime');
        $('#contentPage').load('<?php echo base_url('Panitia/')?>Tahap',function() {
            $('#loading').hide();
            $('#contentPage').removeClass('lodtime');
        });
    });   
    $("#tahapP").click(function(event) {
        event.preventDefault();
        $('#loading').show();
        $('#contentPage').addClass('lodtime');
        $('#contentPage').load('<?php echo base_url('Panitia/')?>tambahTahap',function() {
            $('#loading').hide();
            $('#contentPage').removeClass('lodtime');
        });
    });   
	function getSeleksi(id)
	{
		console.log(id);
		$('#load'+id).load("<?php echo base_url('panitia/subreTahap/');?>" + id);
	}
</script>