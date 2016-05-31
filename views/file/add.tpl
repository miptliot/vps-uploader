{include file="../requirements.tpl"}
<div class="vu-file-add">
	{for $i=1 to $simultaneous}
		<div class="vu-file-add-item row">
			<div class="col-md-6 vu-select"></div>
			<div class="col-md-6 vu-progress"></div>
		</div>
	{/for}
</div>
<script>
	$(document).ready(function () {
		if (!canUpload)
			return;

		$('.vu-file-add-item').uploader({
			chunksize : {$chunksize},
			query : {
				'{Yii::$app->request->csrfParam}' : '{Yii::$app->request->csrfToken}'
			},
			target : '{yii\helpers\Url::to([ "file/upload" ])}'
		});
	});
</script>