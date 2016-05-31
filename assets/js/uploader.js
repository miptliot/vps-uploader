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
		Progress.prototype.remove = function () {
			this.bar.remove();
			this.text.remove();
		};

		var File = function (element, options) {
			element.attr('id', 'vu-' + options.id);

			this.id = options.id;

			this.name = $('<span/>')
				.addClass('vu-file-name')
				.html(options.name);

			this.size = $('<span/>')
				.addClass('vu-file-size')
				.html(humanSize(options.size));

			var removeBtn = $('<span/>')
				.addClass('vu-file-remove')
				.click(function () {
					removeFile(options.id);
				})
				.html('&times;');

			this.info = $('<div/>')
				.addClass('vu-file-info')
				.append(removeBtn)
				.append(this.name)
				.append(this.size);

			var prEl = $('<div/>')
				.addClass('vu-file-progress');

			this.progress = new Progress(prEl);

			this.element = element
				.append(this.info)
				.append(prEl);

			return this;
		};
		File.prototype.remove = function () {
			this.info.remove();
			this.progress.remove();
			this.element.remove();
		};

		var humanSize = function (bytes, decimals) {
			if (bytes == 0) return '0 Byte';
			var k = 1024;
			var dm = decimals + 1 || 3;
			var sizes = [ 'Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB' ];
			var i = Math.floor(Math.log(bytes) / Math.log(k));
			return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[ i ];
		};

		var removeFile = function (id) {
			for (var i = 0; i < flow.files.length; i++) {
				if (flow.files[ i ].uniqueIdentifier == id) {
					flow.removeFile(flow.files[ i ]);
					break;
				}
			}

			for (var i = 0; i < fileList.length; i++) {
				if (fileList[ i ].id == id) {
					fileList[ i ].remove();
					fileList.splice(i, 1);
				}
			}
		};

		this.options = $.extend(true, {}, Uploader.defaults, options);

		var fileList = [];

		var fileInput = $('<input/>')
			.attr('type', 'file');

		var btnSelect = $('<div/>')
			.addClass('btn btn-default vu-file-select')
			.html(options.messages.select)
			.append(fileInput);

		element.append($('<div/>')
			.addClass('vu-controls')
			.append(btnSelect));

		var flow = new Flow({
			target : options.target,
			uploadMethod : 'POST',
			chunkSize : options.chunksize,
			simultaneousUploads : 20,
			query : options.query
		});

		flow.on('filesAdded', function (files, e) {
			for (var i = 0; i < files.length; i++) {
				var c = $('<div/>').addClass('vu-file-item');
				fileList.push(new File(c, {
					id : files[ i ].uniqueIdentifier,
					name : files[ i ].name,
					size : files[ i ].size
				}));
				element.append(c);
			}
		});

		flow.on('fileRemove', function (f) {
			console.log(f);
		});

		flow.assignBrowse(fileInput);

		return this;
	};

	Uploader.prototype.defaults = {
		extensions : null,
		messages : {
			change : 'Change',
			remove : 'Remove file',
			select : 'Select files'
		}
	};

	$.fn.uploader = function (options) {
		return this.each(function () {
			new Uploader($(this), options);
		});
	};
}(jQuery));