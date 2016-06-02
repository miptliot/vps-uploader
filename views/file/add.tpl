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
				add : '{Yii::t("vps-uploader", "Add files")}',
				clear : '{Yii::t("vps-uploader", "Clear list")}',
				remove : '{Yii::t("vps-uploader", "Remove file")}',
				select : '{Yii::t("vps-uploader", "Select files")}',
				upload : '{Yii::t("vps-uploader", "Upload")}'
			}
		});
	});
</script>