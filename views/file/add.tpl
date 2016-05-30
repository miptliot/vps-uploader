{include file="../requirements.tpl"}
<div class="vu-file-add">
	<div class="vu-file-add-item row hide" id="vu-file-add-proto">
		<div class="col-md-6 vu-file-add-select">
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<span class="btn btn-default btn-file">
					<span class="fileinput-new">{Yii::t('vps-uploader', 'Select file')}</span>
					<span class="fileinput-exists">{Yii::t('vps-uploader', 'Change')}</span>
					<input type="file" name="uploader[]">
				</span>
				<span class="fileinput-filename"></span>
				<a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a>
			</div>
		</div>
		<div class="col-md-6 vu-file-add-progress">
			<div class="progress hide">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">
					<span class="sr-only">0%</span>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		if (!canUpload)
			return;
		for (var i = 0; i < {$simultaneous}; i++) {
			var addProto = $('#vu-file-add-proto').clone().removeAttr('id').removeClass('hide');
			$('.vu-file-add').append(addProto);
		}
	});
</script>