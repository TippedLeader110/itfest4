<link href="<?php echo base_url('/assets/css/addons/datatables.min.css') ?>" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?php echo base_url('/assets/css/mdb.min.css') ?>"> -->

<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<h5>kelolah Pemberitahuan kompetisi | ITFest4.0 Universitas Sumatera Utara</h5>
			<hr>
			
		</div>
		<div class="container-fluid">
			<button class="btn btn-primary" id="tambahDO">Tambah</button>
		</div>
	</div>
	<div class="row" style="margin-top: 0px;">
		<div class="col-12">
			<div class="container-fluid">
				<div class="table-responsive">
					<table id="dtBasicExample" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead class="bg-custom text-white">
							<th>#</th><th>Judul</th><th></th><th></th><th></th>
						</thead>
						<?php $count=1; ?>
						<tbody>
						<?php foreach ($post as $key => $var): ?>
								<tr>
									<td>
										<?php echo $count;$count++; ?>
									</td>
									<td><?php echo $var->judul ?></td>
									<!-- <td><button class="btn btn-primary" data-toggle='collapse' data-target='#cbody<?php echo $count ?>' aria-expanded='false'>Isi</button></td> -->
									<td><button class="btn btn-danger" onclick="hapusPost(<?php echo $var->id_post ?>)">Hapus</button></td><td><button class="btn btn-warning" onclick="editPost(<?php echo $var->id_post ?>)">Ubah</button></span></td>
								</tr>
							<?php $count++ ?>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	$('#tambahDO').click(function(event) {
		$('#loading').show();
	    $('#contentPage').addClass('lodtime');
        $('#contentPage').load('<?php echo base_url('Panitia/')?>tambahPost',function() {
            $('#loading').hide();
            $('#contentPage').removeClass('lodtime');
        });   
	});

	$(document).ready(function () {
		$('#dtBasicExample').DataTable();
		$('.dataTables_length').addClass('bs-select');
	});

	function openInNewTab(va) {
		var url = "<?php echo base_url('public/kompetisi/tahap/')?>" + va;
	  	var win = window.open(url, '_blank');
	  	win.focus();
	}

	function editPost(id){
		$('#loading').show();
	    $('#contentPage').addClass('lodtime');
        $('#contentPage').load('<?php echo base_url('Panitia/editPost/')?>'+ id,function() {
            $('#loading').hide();
            $('#contentPage').removeClass('lodtime');
        });   
		// $('#contentPage').load('<?php echo base_url('panitia/editPost/') ?>'+id);
	}

	function hapusPost(value){
		console.log(value);
		Swal.fire({
		title: 'Apakah anda yakin?',
		text: "Perubahan tidak dapat diundurkan!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Hapus!!',
		cancelButtonText: 'Mungkin tidak'
		}).then((result) => {
			if (result.value) {
			    $.ajax({
			    	url: '<?php echo base_url('panitia/hapusPost') ?>',
			    	type: 'post',
			    	data: {value:value},
			    	success: function(er){
			    		if (er==1) {
							console.log(er);
							Swal.fire(
						      'Terhapus!',
						      'Pemberitahuan dengan id #'+ value +' telah di hapus!!.',
						      'success'
						    );
						    $('#loading').show();
	    					$('#contentPage').addClass('lodtime');
        					$('#contentPage').load('<?php echo base_url('Panitia/')?>Post',function() {
            					$('#loading').hide();
            					$('#contentPage').removeClass('lodtime');
        					});   
						}
						else{
							console.log(er);
							Swal.fire('Gagal','Terjadi kesalahan', 'error');
						}

			    		
			    	},
			    	error: function(er){

			    	}
			    });
			}
			else{
			}
		})
	}


</script>