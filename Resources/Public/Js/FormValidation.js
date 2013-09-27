jQuery(document).ready(function() {

	base = getBaseUrl();

	disableAllHiddenForms();
	$(function(){
		$("input[type=radio]").click(function(){
			var formid = $(this).val();
			hideAllForms();
			showForm(formid);
			//~ alert('clicked: ' + formid);
		});
	});

});

/**
 * Hide all forms
 *
 * @return void
 */
function hideAllForms() {
	$('.slub-forms-form').addClass('hide'); // show all fields and fieldsets
	$('.slub-forms-fieldset').find('input').attr('disabled','disabled'); // XXXab
}

/**
 * Hide all forms
 *
 * @return void
 */
function disableAllHiddenForms() {
	$('.slub-forms-form.hide .slub-forms-fieldset').find('input').attr('disabled','disabled'); // XXXab
}

/**
 * Show a form
 *
 * @param	integer	uid: uid of the element
 * @return	void
 */
function showForm(uid) {
	$('#slub-forms-form-' + uid).removeClass('hide'); // hide current field
	$('#slub-forms-form-' + uid).find('input').removeAttr('disabled'); // XXab
}

/**
 * Show a form
 *
 * @param	integer	uid: uid of the element
 * @return	void
 */
function hideForm(uid) {
	$('.slub-forms-form-' + uid).addClass('hide'); // hide current field
	$('.slub-forms-form-' + uid).find('input').attr('disabled','disabled'); // XXXab
}

/**
 * Read BaseUrl
 *
 * @return string	BaseUrl from Tag in DOM
 */
function getBaseUrl() {
	var base = $('base').attr('href');
	if (!base || base == undefined) {
		base = '';
	}
	return base;
}

