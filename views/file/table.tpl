<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>

		</tr>
	</thead>
	<tbody>
		{foreach $files as $file}
			<tr>
				<td>{$file->guid}</td>
				<td>{$file->name}</td>
				<td>{HumanHelper::size($file->size)}</td>
				<td class="vu-file-status-{$file->status}">{$file->status}</td>
				<td>{$file->message}</td>
				<td>{Yii::$app->formatter->asDatetime($file->dt)}</td>
			</tr>
		{/foreach}
	</tbody>
</table>