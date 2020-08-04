$(document).ready(function() {
	buttonType();
	inputDatepicker();
	inputPrice();
});

ajaxResult = function (resp, form) {
	$('.alert-danger').remove();
	if (resp.resultCode == SUCCESS_CODE) {

		if (resp.msg) {
			if (resp.msg.indexOf('redirect:') !== -1) {
				location.href = resp.msg.replace('redirect:', '');
			} else {
				alert(resp.msg);
			}
		} 
		if (resp.reload) location.reload();

	} else if (resp.resultCode == FAIL_CODE) {

		if (resp.msg) {
			if (resp.msg.indexOf('redirect:') !== -1) {
				location.href = resp.msg.replace('redirect:', '');
			} else {
				alert(resp.msg);
			}
		} 
		if (resp.reload) location.reload();

	} else if (resp.resultCode == NOT_FOUND_CODE) {

		if (resp.msg) {
			if (resp.msg.indexOf('redirect:') !== -1) {
				location.href = resp.msg.replace('redirect:', '');
			} else {
				alert(resp.msg);
			}
		}
		if (resp.reload) location.reload();

	} else if (resp.resultCode == VALIDATION_FAIL_CODE) {

		if (form) {
			form.before(resp.msg);
		} else {
			alert(resp.msg);
		}

	}
}

buttonType = function() {
	const attr = 'button-type';
	$(document).on('click', '['+attr+']', function(){
		const self = $(this);
		const attrValue = self.attr(attr);
		switch (attrValue) {
			case 'submit':
				const formId = self.attr('form-id');
				const submitUrl = self.attr('submit-url') ? self.attr('submit-url') : $(location).attr('pathname');
				const submitType = self.attr('submit-type') ? self.attr('submit-type') : 'POST';
				const submitConfirm = self.attr('submit-confirm');
				const submitConfirmTitle = self.attr('submit-confirm-title') ? self.attr('submit-confirm-title') : "확인";

				if (!formId) {
					console.error('submit 버튼의 필수 속성이 모두 설정되지 않았습니다.[form-id]');
					return false;
				}
				const form = $('#'+formId);
				const redirect = form.attr('redirect-url') ? form.attr('redirect-url') : false;
				if (form.length == 0) {
					console.error('submit 버튼의 form-id 속성이 잘못 설정되었습니다.[form-id]');
					return false;
				}

				const data = form.serializeArray();
				let submitData = {};
				if (data.length > 0) {
					for (let i=0; i<data.length; i++) {
						submitData[data[i].name] = data[i].value;
					}
				}

				if (submitConfirm && !confirm(submitConfirm)) {
					return false;
                }

                const encType = form.attr('encType');
                if (encType && encType.toLowerCase() == 'multipart/form-data') {
                    form.ajaxSubmit({ 
                        url: submitUrl, 
                        type: submitType, 
                        data: data, 
                        dataType: "json",
                        success:function(resp){ 
                            ajaxResult(resp, form);
                        }
                    });
                } else {
                    $.ajax({
                        url: submitUrl,
                        type: submitType,
                        data: data,
                        dataType: "json",
                        async: false,
                        success: function (resp) {
                            ajaxResult(resp, form);
                        }
                    });
				}
				break;
			case 'go':
				const goUrl = self.attr('go-url');
				if (!goUrl) {
					console.error('go 버튼의 필수 속성이 모두 설정되지 않았습니다.[go-url]');
					return false;
				}
				location.href = goUrl;
				break;
			case 'back':
				history.back();
				break;
			case 'file':
				const fileId = self.attr('file-id');
				const fileExt = self.attr('file-ext');
				const inputId = self.attr('input-id');
				if (!fileId) {
					console.error('file 버튼의 필수 속성이 모두 설정되지 않았습니다.[file-id]');
					return false;
				}
				if (inputId) {
					$(document).on('change', "#"+fileId, function(){
						let value = $(this).val();
						if (value) {
							let valueArr = value.split('\\');
							let fileName = valueArr[(valueArr.length - 1)];
							$('#'+inputId).val(fileName);
						} else {
							$('#'+inputId).val('');
						}
					});
				}
				if (fileExt) {
					const fileExtArr = fileExt.toUpperCase().replace(/ /gi, '').split(',');
					$(document).on('change', "#"+fileId, function(){
						let value = $(this).val();
						if (value) {
							let valueArr = value.split('\\');
							let fileName = valueArr[(valueArr.length - 1)];
							let fileNameArr = fileName.split('.');
							let ext = fileNameArr[(fileNameArr.length - 1)].toUpperCase();
							if (fileExtArr.indexOf(ext) === -1) {
								$('#'+fileId).val('');
								if (inputId) {
									$('#'+inputId).val('');
								}
								kkMessgae.warning(fileExtArr.join(', ')+" 파일만 업로드 가능합니다.");
							}
						}
					});
				}
				$("#"+fileId).click();
				break;
		}
	});
}

inputDatepicker = function() {
	$("[datepicker]").datepicker({
		format: 'yyyy-mm-dd',
		language: 'kr',
		autoclose: true
	});
}

inputPrice = function() {
	$('.input-price').bind('keyup change', function() {
		const $this = $(this);
		const value = $this.val();
		$this.val(value.replace(/[^0-9]/g, "").toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	});
}

_ajaxGet = function (url, data, rsFunc) {
	$.ajax({
		url: url,
		type: 'GET',
		data: data ? data : {},
		dataType: "json",
		async: false,
		success: function (resp) {
			ajaxResult(resp);
			if (rsFunc) {
				rsFunc(resp);
			}
		}
	});
}

_ajaxPost = function (url, data, rsFunc) {
	$.ajax({
		url: url,
		type: 'POST',
		data: data ? data : {},
		dataType: "json",
		async: false,
		success: function (resp) {
			ajaxResult(resp);
			if (rsFunc) {
				rsFunc(resp);
			}
		}
	});
}

modalCreate = function(modalId, data) {
	$('#'+modalId+' form input[type="date"]').val('');
	$('#'+modalId+' form input[type="hidden"]').val('');
	$('#'+modalId+' form input[type="text"]').val('');
	$('#'+modalId+' form input[type="checkbox"]:checked').prop('checked', false);
	$('#'+modalId+' form input[type="radio"]:checked').prop('checked', false);
	$('#'+modalId+' form select').val('');
	$('#'+modalId+' form textarea').val('');
	$('#'+modalId+' .alert-danger').remove();
	
	if (data) {
		$.each(data, function(key, value){
			const inputAttr = '#'+modalId+' form [name="'+key+'"]';
			const input = $(inputAttr);
			if (input.length > 0) {
				const tag = input.prop('tagName');
				if (tag == 'INPUT') {
					const type = input.attr('type'); 
					switch (type) {
						case 'hidden':
						case 'text':
						case 'date':
							input.val(value);
							break;
						case 'radio':
						case 'checkbox':
							$(inputAttr+'[value="'+value+'"]').prop('checked', true);
							break;
					}
				} else if (tag == 'TEXTAREA') {
					input.val(value);
				} else if (tag == 'SELECT') {
					input.val(value);
				}
				input.change();
			}
		});
	}

	$('#'+modalId).modal();
}

enterFormSubmit = function(e, id) {
	if (e.keyCode == 13 && e.srcElement.type != 'textarea')  {
		$("#"+id).click();
		return false;
	}
}