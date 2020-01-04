<?php foreach ($datapeserta as $key => $v): ?>
	
<?php endforeach ?>
<div id='loadingmessage' style='display:none;margin-top: 50px;'>
    <center><img src='<?php echo base_url('assets/file/load.gif') ?>'/></center>
</div>
<form id="dataTim">
<div class="row" id="data">
	<div class="col-12">
		<div class="table-responsive-lg">
	<table class="table ">
		<tr>
			<td>Nama</td><td> : <?php echo $v->nama ?></td>
		</tr>
		<tr>
			<td>Telepon</td><td> : <?php echo $v->telepon ?></td>
		</tr>
		<tr>
			<td>Email</td><td> : <?php echo $v->email ?></td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td><td> : <?php echo $v->tgl_lahir ?></td>
		</tr>
		<tr>
			<td>Nomor Identitas</td><td> : <?php echo $v->identitas ?></td>
		</tr>
		<tr>
			<td>Bukti Pembayaran</td><td> : <a target="_blank" href="<?php echo base_url("public/seminar/pembayaran/"); echo $v->path_bukti ?>" style="text-decoration: underline;">Download</a></td>
		</tr>
		<tr>
			<td>Status Pembayaran</td>
			<td>
				<input type="text" id="id" hidden name="id" value="<?php echo $v->kode_seminar ?>">
				<select id="select" name="status" class="form-control">
				<?php if ($v->status_pembayaran=='1'): ?>
						<option value="1">Diterima</option>
						<option value="0">Abaikan</option>
				<?php endif ?>
				<?php if ($v->status_pembayaran!='1'): ?>
						<option value="0">Abaikan</option>
						<option value="1">Diterima</option>
				<?php endif ?>
				</select>
			</td>
		</tr>
	</table>
</div>
</div>
</div>
</form>
<script type="text/javascript">
	$(document).ajaxStart(function() {
		$('#data').toggleClass('opaci');
		$('#loadingmessage').show();
	});
	
	$('#simpan').click(function(event) {
		$('#dataTim').submit();
	});

	$('#batal').click(function(event) {
		$('#simpan').prop("disabled",true);
	});

	$('#select').change(function(event) {
		$('#simpan').prop("disabled",false);
	});

	$('#dataTim').submit(function(event) {
		event.preventDefault();
		var a = $('#select').val();
		var b = $('#id').val();
		console.log(a);
		$.ajax({
			url: '<?php echo base_url('bendahara/sdoSimpan') ?>',
			type: 'post',
			data: {sel: a, id : b},
			success: function(event){
				Swal.fire('Berhasil', 'Perubahan tersimpan', 'success');
				$('#modalTim').modal('hide'); 
				$('.modal-backdrop').remove();
				$('#simpan').prop("disabled",false);
				$('#contentPage').load('<?php echo base_url('bendahara/seminar') ?>');
			},
			error: function(event){
				Swal.fire('Kesalahan', 'Terjadi kesalahan', 'error');
			}
		})
	});
</script>