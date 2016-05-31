(function ($) {
	'use strict';

	var Uploader = function (element, options) {
		var Progress = function (element, options) {
			this.text = $('<span/>');

			this.bar = $('<div/>')
				.addClass('progress-bar')
				.attr('role', 'progressbar')
				.attr('aria-valuemin', '0')
				.attr('aria-valuemax', '100')
				.append(this.text);

			this.set(0);

			element.append($('<div/>').addClass('progress').append(this.bar));

			return this;
		};
		Progress.prototype.set = function (value) {
			if (value < 0)
				value = 0;
			if (value > 100)
				value = 100;
			this.bar
				.attr('aria-valuenow', value)
				.css('width', value + '%');
			this.text.html(value + '%')
		};

		var File = function (element, options) {
			this.options = options;

			this.input = $('<input/>')
				.attr('type', 'file');

			this.btn = $('<div/>')
				.addClass('btn btn-default vu-file')
				.append($('<span/>').html(this.options.messages.select))
				.append(this.input);

			this.name = $('<span/>')
				.addClass('vu-file-name');

			this.size = $('<span/>')
				.addClass('vu-file-size');

			var _self = this;
			var removeBtn = $('<span/>')
				.addClass('vu-file-remove')
				.click(function () {
					_self.remove();
				})
				.html('&times;')
				.attr('title', this.options.messages.remove);

			this.info = $('<div/>')
				.addClass('vu-file-info')
				.append(removeBtn)
				.append(this.name)
				.append(this.size)
				.hide();

			element
				.append(this.btn)
				.append(this.info);

			return this;
		};
		File.prototype.clearData = function () {
			this.info.hide();
		};
		File.prototype.setData = function (name, size) {
			this.name.html(name);

			this.size.html(humanSize(size));

			this.btn.children('span').html(this.options.messages.change);

			this.info.show();
		};
		File.prototype.remove = function () {
			this.input.remove();
			this.input = $('<input/>').attr('type', 'file');
			this.btn.append(this.input);
			this.btn.children('span').html(this.options.messages.select);

			flow.removeFile(flow.files[ 0 ]);
			flow.assignBrowse(this.input);

			this.clearData();
		};

		function humanSize (bytes, decimals) {
			if (bytes == 0) return '0 Byte';
			var k = 1024;
			var dm = decimals + 1 || 3;
			var sizes = [ 'Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ];
			var i = Math.floor(Math.log(bytes) / Math.log(k));
			return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[ i ];
		}

		var progress = new Progress(element.find('.vu-progress'));
		var file = new File(element.find('.vu-select'), {
			messages : options.messages
		});

		var flow = new Flow({
			target : options.target,
			uploadMethod : 'POST',
			chunkSize : options.chunksize,
			maxFiles : 1,
			simultaneousUploads : 20,
			query : options.query
		});

		flow.on('fileAdded', function (f, e) {
			file.setData(f.name, f.size);
		});
		flow.on('fileRemoved', function (f) {

		});

		flow.assignBrowse(file.input);

		return this;
	};

	Uploader.prototype.defaults = {
		extensions : null,
		messages : {
			change : 'Change',
			remove : 'Remove file',
			select : 'Select file'
		}
	};

	$.fn.uploader = function (options) {
		return this.each(function () {
			options = $.extend(true, {}, Uploader.prototype.defaults, options);
			Uploader($(this), options);
		});
	};
}(jQuery));