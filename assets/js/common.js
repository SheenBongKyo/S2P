$(document).ready(function() {
	buttonType();
	inputDatepicker();
});

ajaxResult = function (resp, form) {
	if (resp.resultCode == 200) {
		alert(resp.msg);
		if (resp.reload) {
			location.reload();
		}
	} else if (resp.resultCode == 201) {
		alert(resp.msg);
	} else if (resp.resultCode == 400) {
		$('.alert-danger').remove();
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
                            ajaxResult(resp);
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

enterFormSubmit = function(e, id) {
	if (e.keyCode == 13 && e.srcElement.type != 'textarea')  {
		$("#"+id).click();
		return false;
	}
}