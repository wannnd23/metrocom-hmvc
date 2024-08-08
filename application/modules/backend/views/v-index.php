<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>
	<!-- CSS dan Font Awesome -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap-4.1.3.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/font-awesome/css/all.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/dataTables.bootstrap4.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css'); ?>">
</head>
<body>
	<div id="flash-data-success" data-flashsuccess="<?= $this->session->flashdata('messuccess'); ?>"></div>
	<div id="flash-data-error" data-flasherrors="<?= $this->session->flashdata('meserror'); ?>"></div>
	<!-- navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="javascript:void(0)"><strong>Metrocom</strong></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link active" href="<?= base_url(''); ?>">Home</a>
				</div>
			</div>
		</div>
	</nav>
	<!-- navbar end -->

	<!-- content -->
	<div class="container">
		<div class="row mt-3">
			<div class="col-md-2"></div>
			<div class="col-md-8 right">
				<!-- button add data -->
				<button class="btn btn-secondary" onclick="add()">
					<i class="fa-solid fa-plus"></i> Add
				</button>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="card">
					<h5 class="card-header">List data</h5>
					<div class="card-body">
						<table class="table table-sm table-hover" id="data-table">
							<thead class="thead-light">
								<tr>
									<th class="w-10">#</th>
									<th>Title</th>
									<th class="w-20">Status</th>
									<th class="w-15">Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- content end -->

	<!-- modal -->
	<!-- modal add data -->
	<div class="modal fade" role="dialog" id="modal-add">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title">Form add</h5>
				</div>
				<form method="post" action="<?= base_url('backend/metrocom/save_data'); ?>">
					<div class="modal-body" id="modal-body-add"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary w-15" data-dismiss="modal">Close</button>
						<button class="btn btn-sm btn-primary w-15">Save</button>
					</div>
				</form>
			</div>
		</div>		
	</div>
	<!-- modal edit data -->
	<div class="modal fade" role="dialog" id="modal-edit">
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title">Form Edit</h5>
				</div>
				<form method="post" action="<?= base_url('backend/metrocom/update_data'); ?>">
					<div class="modal-body" id="modal-body-edit"></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary w-25" data-dismiss="modal">Close</button>
						<button class="btn btn-sm btn-primary w-25">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- modal end -->

	<!-- JavaScript -->
	<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.1.1.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/popper-1.14.3.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap-4.1.3.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/dataTables.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/dataTables.bootstrap4.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/sweetalert2-11.12.4.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/style.js'); ?>"></script>
	<script type="text/javascript">
		const	flashSuccess = $('#flash-data-success').data('flashsuccess');
		const	flashErrors = $('#flash-data-error').data('flasherrors');

		if (flashSuccess) {
			Swal.fire({
				icon: 'success',
				title: 'Good job!',
				text:  flashSuccess,
				showConfirmButton: false,
				timer: 1800
			});
		} else if (flashErrors) {
			Swal.fire({
				icon: 'error',
				title: 'Opss..',
				text:  flashErrors,
				showConfirmButton: false,
				timer: 1800
			});
		}

		function add() {
			$.ajax({
				type: "post",
				url: "<?= base_url('backend/metrocom/get_data_add') ?>",
				success: function(response) {
					$("#modal-add").modal("show");
					$("#modal-body-add").html(response);
				}
			})
		}

		function edit(id) {
			$.ajax({
				type: "post",
				url: "<?= base_url('backend/metrocom/get_data_edit') ?>",
				data: {id},
				success: function(response) {
					$("#modal-edit").modal("show");
					$("#modal-body-edit").html(response);
				}
			})
		}

		function deleted(id) {
			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "rgb(30, 224, 172)",
				cancelButtonColor: "rgb(122, 131, 147)",
				confirmButtonText: "Yes",
				cancelButtonText: "No"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: "post",
						url: "<?= base_url('backend/metrocom/delete_data') ?>",
						data: {id},
						success: function(response) {
							Swal.fire({
								position: "center",
								icon: "success",
								title: "Good job!",
								text: "Your file has been deleted.",
								showConfirmButton: false,
								timer: 1500
							}).then((result) => {
								location.href = "<?= base_url('') ?>"
							});
						}
					})
				}
			});
		}

		$(document).ready(function() {
			// dataTable
			table = $("#data-table").dataTable({
				responsive: true,
				autoWidth: false,
				dom: dom,
				language: {
					search: "",
					searchPlaceholder: "Type to search",
					lengthMenu: "<span class='d-none d-sm-inline-block'>Show</span><div class='form-control-select'> _MENU_ </div>",
					info: "_START_ -_END_ to _TOTAL_",
					infoEmpty: "0",
					infoFiltered: "( Total _MAX_  )",
					sEmptyTable: "No data entry",
					paginate: {
						first: "<<",
						last: ">>",
						next: ">",
						previous: "<"
					}
				},
				processing: true,
				serverSide: true,
				order: [],
				ajax: {
					url: "<?= base_url('backend/metrocom/get_data') ?>",
					type: "post"
				},
				columnDefs: [{
					targets: [0],
					orderable: false
				}]
			})
			// dataTable end
		})
	</script>
</body>
</html>