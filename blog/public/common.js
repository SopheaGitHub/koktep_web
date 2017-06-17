function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

// get parse_url
function parse_url (str, component) { // eslint-disable-line camelcase
    //       discuss at: http://locutus.io/php/parse_url/
    //      original by: Steven Levithan (http://blog.stevenlevithan.com)
    // reimplemented by: Brett Zamir (http://brett-zamir.me)
    //         input by: Lorenzo Pisani
    //         input by: Tony
    //      improved by: Brett Zamir (http://brett-zamir.me)
    //           note 1: original by http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
    //           note 1: blog post at http://blog.stevenlevithan.com/archives/parseuri
    //           note 1: demo at http://stevenlevithan.com/demo/parseuri/js/assets/parseuri.js
    //           note 1: Does not replace invalid characters with '_' as in PHP,
    //           note 1: nor does it return false with
    //           note 1: a seriously malformed URL.
    //           note 1: Besides function name, is essentially the same as parseUri as
    //           note 1: well as our allowing
    //           note 1: an extra slash after the scheme/protocol (to allow file:/// as in PHP)
    //        example 1: parse_url('http://user:pass@host/path?a=v#a')
    //        returns 1: {scheme: 'http', host: 'host', user: 'user', pass: 'pass', path: '/path', query: 'a=v', fragment: 'a'}
    //        example 2: parse_url('http://en.wikipedia.org/wiki/%22@%22_%28album%29')
    //        returns 2: {scheme: 'http', host: 'en.wikipedia.org', path: '/wiki/%22@%22_%28album%29'}
    //        example 3: parse_url('https://host.domain.tld/a@b.c/folder')
    //        returns 3: {scheme: 'https', host: 'host.domain.tld', path: '/a@b.c/folder'}
    //        example 4: parse_url('https://gooduser:secretpassword@www.example.com/a@b.c/folder?foo=bar')
    //        returns 4: { scheme: 'https', host: 'www.example.com', path: '/a@b.c/folder', query: 'foo=bar', user: 'gooduser', pass: 'secretpassword' }

    var query

    var mode = (typeof require !== 'undefined' ? require('../info/ini_get')('locutus.parse_url.mode') : undefined) || 'php'

    var key = [
      'source',
      'scheme',
      'authority',
      'userInfo',
      'user',
      'pass',
      'host',
      'port',
      'relative',
      'path',
      'directory',
      'file',
      'query',
      'fragment'
    ]

    // For loose we added one optional slash to post-scheme to catch file:/// (should restrict this)
    var parser = {
      php: new RegExp([
        '(?:([^:\\/?#]+):)?',
        '(?:\\/\\/()(?:(?:()(?:([^:@\\/]*):?([^:@\\/]*))?@)?([^:\\/?#]*)(?::(\\d*))?))?',
        '()',
        '(?:(()(?:(?:[^?#\\/]*\\/)*)()(?:[^?#]*))(?:\\?([^#]*))?(?:#(.*))?)'
      ].join('')),
      strict: new RegExp([
        '(?:([^:\\/?#]+):)?',
        '(?:\\/\\/((?:(([^:@\\/]*):?([^:@\\/]*))?@)?([^:\\/?#]*)(?::(\\d*))?))?',
        '((((?:[^?#\\/]*\\/)*)([^?#]*))(?:\\?([^#]*))?(?:#(.*))?)'
      ].join('')),
      loose: new RegExp([
        '(?:(?![^:@]+:[^:@\\/]*@)([^:\\/?#.]+):)?',
        '(?:\\/\\/\\/?)?',
        '((?:(([^:@\\/]*):?([^:@\\/]*))?@)?([^:\\/?#]*)(?::(\\d*))?)',
        '(((\\/(?:[^?#](?![^?#\\/]*\\.[^?#\\/.]+(?:[?#]|$)))*\\/?)?([^?#\\/]*))',
        '(?:\\?([^#]*))?(?:#(.*))?)'
      ].join(''))
    }

    var m = parser[mode].exec(str)
    var uri = {}
    var i = 14

    while (i--) {
      if (m[i]) {
        uri[key[i]] = m[i]
      }
    }

    if (component) {
      return uri[component.replace('PHP_URL_', '').toLowerCase()]
    }

    if (mode !== 'php') {
      var name = (typeof require !== 'undefined' ? require('../info/ini_get')('locutus.parse_url.queryKey') : undefined) || 'queryKey'
      parser = /(?:^|&)([^&=]*)=?([^&]*)/g
      uri[name] = {}
      query = uri[key[12]] || ''
      query.replace(parser, function ($0, $1, $2) {
        if ($1) {
          uri[name][$1] = $2
        }
      })
    }

    delete uri.source
    return uri
}

// submit form data
function requestSubmitForm(buttonId, formId, formAction) {
	$(document).on('click', '#'+buttonId, function(e) {
	    e.preventDefault();
	    var postDatas = new FormData($("form#"+formId)[0]);
	    $.ajax({
	      	url: formAction,
	      	type: "POST",
	      	data: postDatas,
	      	dataType: "json",
	      	async: false,
	      	beforeSend: function() {
	        	console.log('beforeSend');
	        	$('#'+buttonId).prop('disabled', true);
	      	},
	      	complete: function() {
	        	console.log('completed');
	        	$('#'+buttonId).prop('disabled', false);
	      	},
	      	success: function(data) {
	        	var msg = '';
	        	// if vaildate error
	        	if(data.error==1) {
	          		msg += '<div class="alert alert-warning" id="warning">';
	         		msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	          		msg += '<b><i class="fa fa-info-circle"></i> '+data.msg+' </b><br />';
	          		if(data.validatormsg) {
	            		$.each(data.validatormsg, function(index, value) {
	              			msg += '- '+value+'<br />';
	            		});
	          		}
	          		msg += '</div>';
	        	}

	        	// if success
	        	if(data.success==1) {
	          		msg += '<div class="alert alert-success" id="success">';
	          		msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	          		msg += '<b><i class="fa fa-check-circle"></i> '+data.msg+'</b><br />';
	          		msg += '</div>';
	          		if(data.action=='create') {
	            		loadingForm(data.load_form);
	          		}
	        	}

	        	$('#message').html(msg).show();
	      	},
	      	error: function(error) {
	        	$('#message').html('<div class="alert alert-danger" id="error"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-times"></i> Something wrong, Please alert to developer.</b></div>').show();
	      	},
	      	cache: false,
	      	contentType: false,
	      	processData: false
	    });
  	});
}

// submit delete data
function requestSubmitDeleteForm(buttonId, formId, formAction) {
	$(document).on('click', '#'+buttonId, function(e) {
	    e.preventDefault();
	    var postDatas = new FormData($("form#"+formId)[0]);
	    $.ajax({
	      	url: formAction,
	      	type: "POST",
	      	data: postDatas,
	      	dataType: "json",
	      	async: false,
	      	beforeSend: function() {
	        	console.log('beforeSend');
	        	$('#'+buttonId).prop('disabled', true);
	      	},
	      	complete: function() {
	        	console.log('completed');
	        	$('#'+buttonId).prop('disabled', false);
	      	},
	      	success: function(data) {
	        	var msg = '';
	        	// if vaildate error
	        	if(data.error==1) {
	          		msg += '<div class="alert alert-warning" id="warning">';
	         		msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	          		msg += '<b><i class="fa fa-info-circle"></i> '+data.msg+' </b><br />';
	          		if(data.validatormsg) {
	            		$.each(data.validatormsg, function(index, value) {
	              			msg += '- '+value+'<br />';
	            		});
	          		}
	          		msg += '</div>';
	        	}

	        	// if success
	        	if(data.success==1) {
	          		msg += '<div class="alert alert-success" id="success">';
	          		msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
	          		msg += '<b><i class="fa fa-check-circle"></i> '+data.msg+'</b><br />';
	          		msg += '</div>';
	          		if(data.action=='delete') {
	            		loadingList(data.load_form);
	          		}
	        	}

	        	$('#message').html(msg).show();
	      	},
	      	error: function(error) {
	        	$('#message').html('<div class="alert alert-danger" id="error"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-times"></i> Something wrong, Please alert to developer.</b></div>').show();
	      	},
	      	cache: false,
	      	contentType: false,
	      	processData: false
	    });
		return false;
  	});
}

// loading list data
function loadingList (requestAction) {
	$.ajax({
	  	type: "GET",
	  	url: requestAction,
	  	beforeSend:function() {
	  		console.log('beforeSend');
	  	},
	  	complete:function() {
	    	console.log('complete');
	  	},
	  	success:function(html) {
	    	$('#display-list').html(html).show();
	  	},
	  	error:function(err) {
	    	$('#display-list').html('<div class="alert alert-danger" id="error"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-times"></i> Something wrong, Please alert to developer.</b></div>').show();
	  	}
	});
	return false;
}

// loading form data
function loadingForm (requestAction) {
	$.ajax({
	  	type: "GET",
	  	url: requestAction,
	  	beforeSend:function() {
	  		console.log('beforeSend');
	  	},
	  	complete:function() {
	    	console.log('complete');
	  	},
	  	success:function(html) {
	    	$('#load-form').html(html).show();
	  	},
	  	error:function(err) {
	    	$('#load-form').html('<div class="alert alert-danger" id="error"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-times"></i> Something wrong, Please alert to developer.</b></div>').show();
	  	}
	});
	return false;
}

function paginateListAction (mainPaginateId, requestAction) {
	$(document).on('click','#'+mainPaginateId+' > .pagination > li > a',function(e){
	    e.preventDefault();
	    var value = $(this).attr('href');
	    url = parse_url(value);
	    if(url.query != ''){
	      	var query = url.query;
	      	var url = requestAction+"?"+query;
	     	$.ajax({
	        	type: 'GET',
	        	url: url,
	        	beforeSend:function() {
	    			console.log('beforeSend');
	    		},
	    		complete:function() {
	      			console.log('complete');
	    		},
	    		success:function(html) {
	      			$('#display-list').html(html).show();
	    		},
	    		error:function(err) {
	      			$('#display-list').html('<div class="alert alert-danger" id="error"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-times"></i> Something wrong, Please alert to developer.</b></div>').show();
	    		}
	      	});
	      	return false;
	    }
	    return false;
	});
}

$(document).ready(function() {
	//Form Submit for IE Browser
	$('button[type=\'submit\']').on('click', function() {
		$("form[id*='form-']").submit();
	});

	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();

		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});

	// Set last page opened on the menu
	$('#menu a[href]').on('click', function() {
		sessionStorage.setItem('menu', $(this).attr('href'));
	});

	if (!sessionStorage.getItem('menu')) {
		$('#menu #dashboard').addClass('active');
	} else {
		// Sets active and open to selected page in the left column menu.
		$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active open');
	}

	if (localStorage.getItem('column-left') == 'active') {
		$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

		$('#column-left').addClass('active');

		// Slide Down Menu
		$('#menu li.active').has('ul').children('ul').addClass('collapse in');
		$('#menu li').not('.active').has('ul').children('ul').addClass('collapse');
	} else {
		$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

		$('#menu li li.active').has('ul').children('ul').addClass('collapse in');
		$('#menu li li').not('.active').has('ul').children('ul').addClass('collapse');
	}

	// Menu button
	$('#button-menu').on('click', function() {
		// Checks if the left column is active or not.
		if ($('#column-left').hasClass('active')) {
			localStorage.setItem('column-left', '');

			$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

			$('#column-left').removeClass('active');

			$('#menu > li > ul').removeClass('in collapse');
			$('#menu > li > ul').removeAttr('style');
		} else {
			localStorage.setItem('column-left', 'active');

			$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');

			$('#column-left').addClass('active');

			// Add the slide down to open menu items
			$('#menu li.open').has('ul').children('ul').addClass('collapse in');
			$('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
		}
	});

	// Menu
	$('#menu').find('li').has('ul').children('a').on('click', function() {
		if ($('#column-left').hasClass('active')) {
			$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
			$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
		} else if (!$(this).parent().parent().is('#menu')) {
			$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
			$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
		}
	});

	// Override summernotes image manager
	$('button[data-original-title=\'Picture\']').attr('data-toggle', 'image').removeAttr('data-event');

	$(document).delegate('button[data-toggle=\'image\']', 'click', function() {
		$('#modal-image').remove();

		$(this).parents('.note-editor').find('.note-editable').focus();

		$.ajax({
			url: 'filemanager',
			dataType: 'html',
			beforeSend: function() {
				$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-image').prop('disabled', true);
			},
			complete: function() {
				$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
				$('#button-image').prop('disabled', false);
			},
			success: function(html) {
				$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

				$('#modal-image').modal('show');
			}
		});
	});

	// Image Manager
	$(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
		e.preventDefault();

		$('.popover').popover('hide', function() {
			$('.popover').remove();
		});

		var element = this;

		$(element).popover({
			html: true,
			placement: 'right',
			trigger: 'manual',
			content: function() {
				return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
			}
		});

		$(element).popover('show');

		$('#button-image').on('click', function() {
			$('#modal-image').remove();

			$.ajax({
				url: 'filemanager?target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
				dataType: 'html',
				beforeSend: function() {
					$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-image').prop('disabled', true);
				},
				complete: function() {
					$('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
					$('#button-image').prop('disabled', false);
				},
				success: function(html) {
					$('body').append('<div id="modal-image" class="modal">' + html + '</div>');

					$('#modal-image').modal('show');
				}
			});

			$(element).popover('hide', function() {
				$('.popover').remove();
			});
		});

		$('#button-clear').on('click', function() {
			$(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

			$(element).parent().find('input').attr('value', '');

			$(element).popover('hide', function() {
				$('.popover').remove();
			});
		});
	});

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});

	// https://github.com/opencart/opencart/issues/2595
	$.event.special.remove = {
		remove: function(o) {
			if (o.handler) {
				o.handler.apply(this, arguments);
			}
		}
	}

	$('[data-toggle=\'tooltip\']').on('remove', function() {
		$(this).tooltip('destroy');
	});

	// 
	$(document).delegate('a[data-toggle=\'information\']', 'click', function() {
		$('#modal-information').remove();
		var information_id = $(this).data("id");
		var language_id = $(this).data("languageid");
		$.ajax({
			url: 'information/detail?information_id='+encodeURIComponent(information_id)+'&language_id='+encodeURIComponent(language_id),
			dataType: 'html',
			beforeSend: function() {
				// before send
			},
			complete: function() {
				// completed
			},
			success: function(html) {
				$('body').append('<div id="modal-information" class="modal">' + html + '</div>');

				$('#modal-information').modal('show');
			}
		});
		return false;
	});

});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);