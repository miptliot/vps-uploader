<table class="table table-striped table-bordered table-hover vu-table">
	<thead>
		<tr>
			<th></th>
			<th>
				{Yii::t('vps-uploader', 'GUID')}
				<p class="help">{Yii::t('vps-uploader', 'Unique identifier.')}</p>
			</th>
			<th>{Yii::t('vps-uploader', 'Link')}</th>
			<th>{Yii::t('vps-uploader', 'Extension')}</th>
			<th>{Yii::t('vps-uploader', 'Original name')}</th>
			<th>{Yii::t('vps-uploader', 'Filesize')}</th>
			<th>{Yii::t('vps-uploader', 'Status')}</th>
			<th>
				{Yii::t('vps-uploader', 'Message')}
				<p class="help">{Yii::t('vps-uploader', 'In case of error.')}</p>
			</th>
			<th>{Yii::t('vps-uploader', 'Last edit DT')}</th>
		</tr>
	</thead>
	<tbody>
		{foreach $files as $file}
			<tr>
				<td><input type="checkbox" name="file[]" value="{$file->guid}" class="vu-file-check"></td>
				<td>{Html::a($file->guid, ["file/`$file->guid`"], [ 'class' => 'vu-file-link', 'title' => Yii::t('vps-uploader', 'File view') ])}</td>
				<td>{Html::a($file->path, $file->getUrl(), [ 'class' => 'vu-file-link' ])}</td>
				<td>{$file->extension}</td>
				<td>{$file->name}</td>
				<td>{HumanHelper::size($file->size)}</td>
				<td class="vu-file-status-{$file->status}">{$file->status}</td>
				<td>{$file->message}</td>
				<td>{Yii::$app->formatter->asDatetime($file->dt)}</td>
			</tr>
		{/foreach}
	</tbody>
</table>
<div class="btn-group" role="group">
	<button class="btn btn-default vu-file-check-all" type="button">{Yii::t('vps-uploader', 'Check all')}</button>
	<button class="btn btn-default vu-file-uncheck-all" type="button">{Yii::t('vps-uploader', 'Uncheck all')}</button>
</div>
<div class="vu-file-batch form-inline">
	{Yii::t('vps-uploader', 'With selected:')}
	<select class="form-control vu-file-batch-select">
		<option></option>
		{foreach Yii::$app->controller->module->batchActions as $action}
			<option value="{$action.path}">{Yii::t('vps-uploader', $action.title)}</option>
		{/foreach}
	</select>
	<button type="button" class="btn btn-primary vu-file-batch-go" disabled>{Yii::t('vps-uploader', 'Go')}</button>
</div>
<script>
	function checkedGuids () {
		var guids = [];
		$('.vu-file-check:checked').each(function () {
			guids.push($(this).val());
		});
		console.log(guids);
		return guids;
	}
	function toggleBtn () {
		var btn = $('.vu-file-batch-go');
		if ($('.vu-file-batch-select').val() == '' || $('.vu-file-check:checked').length == 0) {
			btn.prop('disabled', true);
		}
		else {
			btn.prop('disabled', false);
		}
	}
	$(document).ready(function () {
		$('.vu-file-check-all').click(function () {
			$('.vu-file-check').prop('checked', true);
		});
		$('.vu-file-uncheck-all').click(function () {
			$('.vu-file-check').prop('checked', false);
		});
		$('.vu-file-batch-select, .vu-file-check').change(function () {
			toggleBtn();
		});
		$('.vu-file-batch-go').click(function () {
			window.location = '{yii\helpers\Url::to([ "file/batch" ])}?path=' + $('.vu-file-batch-select').val() + '&guids=' + checkedGuids().join(',');
		});
		$('.vu-table tr').click(function (e) {
			if ($(e.target).is('.vu-file-check')) {
				return true;
			}
			else {
				var ch = $(this).find('input.vu-file-check');
				ch.prop('checked', !ch.prop('checked'));
				toggleBtn();
			}
		});
	});
</script>