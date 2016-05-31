{include file="../requirements.tpl"}
<div class="vu-file-add"></div>
<script>
	$(document).ready(function () {
		if (!canUpload)
			return;

		$('.vu-file-add').uploader({
			chunksize : {$chunksize},
			query : {
				'{Yii::$app->request->csrfParam}' : '{Yii::$app->request->csrfToken}'
			},
			target : '{yii\helpers\Url::to([ "file/upload" ])}',
			messages : {
				change : '{Yii::t("vps-uploader", "Change")}',
				remove : '{Yii::t("vps-uploader", "Remove file")}',
				select : '{Yii::t("vps-uploader", "Select files")}'
			}
		});
	});
</script>