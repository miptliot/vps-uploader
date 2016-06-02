<div class="alert alert-danger hide" id="requirements-flow">
	{Yii::t('vps-uploader', 'You should include <a href="https://github.com/flowjs/flow.js">Flow.js</a> library to make this uploader work.')}
</div>
<script>
	var canUpload = true;
	$(document).ready(function () {
		if (typeof window.Flow == 'undefined') {
			$('#requirements-flow').removeClass('hide');
			canUpload = false;
		}
	});
</script>