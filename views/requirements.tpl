<div class="alert alert-danger hide" id="requirements-flow">
	{Yii::tr('You should include <a href="https://github.com/flowjs/flow.js">Flow.js</a> library to make this uploader work.')}
</div>
<div class="alert alert-danger hide" id="requirements-fileinput">
	{Yii::tr('You should include FileInput library from <a href="https://github.com/jasny/bootstrap">Jasny Bootstrap</a> to make this uploader work.')}
</div>
<script>
	$(document).ready(function () {
		if (typeof window.Flow == 'undefined')
			$('#requirements-flow').removeClass('hide');
		if (typeof  window.$.fn.fileinput == 'undefined')
			$('#requirements-fileinput').removeClass('hide');
	});
</script>