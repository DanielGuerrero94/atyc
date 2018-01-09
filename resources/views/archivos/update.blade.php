<form id="update" name="update">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<label style="cursor: pointer;color: #2F2D2D;">
		<input type="file" style="display: none;" name="csv">
		<i class="fa fa-cloud-upload"></i>
	</label>
</form>