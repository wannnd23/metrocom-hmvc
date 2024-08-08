<div class="form-group row">
	<label for="status" class="col-sm-3 col-form-label">Status</label>
	<div class="col-sm-9">
		<input type="text" name="id" id="id" value="<?= $dataById['id']; ?>" hidden>
		<select class="form-control" name="status" id="status" required>
			<option value="">Select one</option>
			<option value="Pending" <?= $dataById['status'] == 'Pending' ? 'selected' : null; ?>>Pending</option>
			<option value="In Progress" <?= $dataById['status'] == 'In Progress' ? 'selected' : null; ?>>In Progress</option>
			<option value="Completed" <?= $dataById['status'] == 'Completed' ? 'selected' : null; ?>>Completed</option>
		</select>
	</div>
</div>