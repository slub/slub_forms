jQuery(document).ready(function() {

	base = getBaseUrl();

	$(function(){
		$("input[type=radio]").click(function(){
			var formid = $(this).val();
			hideAllForms();
			showForm(formid);
			//~ alert('clicked: ' + formid);
			//$('#slub-form-' + $(this).val()).removeClass('hide');
		});
	});

});

/**
 * Fill a field with a value
 *
 * @param int fieldUid		Field Uid
 * @param int fieldValue		Field Value
 */
function fieldValue(fieldUid, fieldValue) {
	$('.powermail_field[name="tx_powermail_pi1[field][' + fieldUid + ']"]').val(fieldValue); // select, input, textarea
	$('.powermail_radio[name="tx_powermail_pi1[field][' + fieldUid + ']"], .powermail_checkbox_' + fieldUid).each(function() { // radio, check
		if ($(this).attr('value') == fieldValue) {
			$(this).attr('checked', 'checked');
		}
	})
}


/**
 * Do some actions (hide and/or filter)
 *
 * @param string	list: commaseparated list with uids (1,2,3)
 * @return void
 */
function doAction(list) {
	showAll(); // show all fields and fieldsets at the beginning

	var uid = list.split(',');
	if (uid.length < 1) {
		return false; // stop process
	}
	for (var i=0; i < uid.length; i++) { // one loop for every affected field
		if (uid[i].indexOf('fieldset:') != '-1') { // fieldset part
			hideFieldset(uid[i]);
		} else if (uid[i].indexOf('filter:') != '-1') { // filter part
			filterSelection(uid[i]);
		} else { // fields part
			hideField(uid[i]);
		}
	}
}

/**
 * Hide a fieldset
 *
 * @param	integer	uid: uid of the element
 * @return	void
 */
function hideFieldset(uid) {
	$('#slub-forms-fieldsets-' + uid).addClass('hide'); // hide current field
	$('#slub-forms-fieldsets-' + uid).find('input').attr('disabled','disabled'); // XXXab
}

/**
 * Show a fieldset
 *
 * @param	integer	uid: uid of the element
 * @return	void
 */
function showFieldset(uid) {
	$('#slub-forms-fieldsets-' + uid).removeClass('hide'); // hide current field
	$('#slub-forms-fieldsets-' + uid).find('input').removeAttr('disabled'); // XXXab
}

/**
 * Show all forms
 *
 * @return void
 */
function showAllForms() {
	$('.slub-forms-form').removeClass('hide'); // show all fields and fieldsets
	$('.slub-forms-form, .slub-forms-fieldsets').find('input').removeAttr('disabled'); // XXab
}

/**
 * Hide all forms
 *
 * @return void
 */
function hideAllForms() {
	$('.slub-forms-form').addClass('hide'); // show all fields and fieldsets
	$('.slub-forms-form, .slub-forms-fieldsets').find('input').attr('disabled','disabled'); // XXXab
}

/**
 * Show a form
 *
 * @param	integer	uid: uid of the element
 * @return	void
 */
function showForm(uid) {
//~ alert('clicked showForm: ' + uid);
	//~ $('#slub-forms-form-' + uid).slideUp();
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
}

/**
 * Hide some fields, which are bundled in a fieldset and clear there value
 *
 * @param	string	string: mix of uid and values (fieldset:5:12;13;14)
 * @return	void
 */
function hideFieldset(string) {
	var params = string.split(':'); // filter / uid / values
	var values = params[2].split(';'); // value1 / value2 / value3
	$('.powermail_fieldset_' + params[1]).addClass('hide'); // hide current fieldset
	$('.powermail_fieldset_' + params[1]).find('input').attr('disabled','disabled'); // XXXab
	for (var k=0; k < values.length; k++) { // one loop for every field inside the fieldset
		clearValue('.powermail_fieldwrap_' + values[k] + ' .powermail_field'); // clear value of current field
	}
}

/**
 * Hide some fields and clear there value
 *
 * @param	string	string: mix of uid and values (filter:123:Value1;Value2;Value3)
 * @return	void
 */
function filterSelection(string) {
	var params = string.split(':'); // filter / uid / values
	var values = params[2].split(';'); // value1 / value2 / value3
	$('.powermail_fieldwrap_' + params[1] + ' .powermail_field > option').addClass('hide').attr('disabled', 'disabled'); // disable all options

	for (var j=0; j < values.length; j++) { // one loop for every option in select field
		$('.powermail_fieldwrap_' + params[1] + ' .powermail_field > option:contains(' + values[j] + ')').removeClass('hide').removeAttr('disabled'); // show this option
	}

	var valueSelected = $('.powermail_fieldwrap_' + params[1] + ' .powermail_field > option:selected').val(); // give me the value of the selected option
	if (params[2].indexOf(valueSelected) == '-1') { // if current selected value is one of the not allowed options
		$('.powermail_fieldwrap_' + params[1] + ' .powermail_field').get(0).selectedIndex = 0; // remove selection (because the selected option is not allowed)
	}
}

/**
 * Show all fields and fieldsets
 *
 * @return void
 */
function showAll() {
	$('.powermail_fieldwrap, .powermail_fieldset').removeClass('hide'); // show all fields and fieldsets
	$('.powermail_fieldwrap, .powermail_fieldset').find('input').removeAttr('disabled'); // XXab
}

/**
 * Clear value of an inputfield, set selectedIndex to 0 for selection, don't clear value of submit buttons
 *
 * @param	string	selection: selection for jQuery (e.g. input.powermail)
 * @return	void
 */
function clearValue(selection) {
	if ($(selection).attr('type') == 'radio' || $(selection).attr('type') == 'checkbox') {
		$(selection).attr('checked', false);
	} else {
		$(selection).not(':submit').val('');
	}
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

/**
 * Clear session of a uid
 *
 * @param	integer	uid: uid of the element
 * @return	void
 */
function clearSession(uid) {
	var url = base + '/index.php';
	var timestamp = Number(new Date()); // timestamp is needed for a internet explorer workarround (always change a parameter)
	var params = 'eID=' + 'powermailcond_saveToSession' + '&tx_powermailcond_pi1[form]=' + getFormUid() + '&tx_powermailcond_pi1[uid]=' + uid + '&tx_powermailcond_pi1[value]=&ts=' + timestamp;

	$.ajax({
		type: 'GET', // type
		url: url, // send to this url
		data: params, // add params
		cache: false, // disable cache (for ie)
		success: function(data) { // return values
			if (data != '') { // if there is a response
				$('form.powermail_form').append('Error in powermail_cond.js in clearSession function:' + data);
			}
			checkConditions(uid); // check if something should be changed
		}
	});
};

/**
 * Clear session values if form is submitted
 *
 * @return void
 */
function clearFullSession() {
	if ($('.powermail_create').length || $('.powermail_frontend').length) { // if submitted Pi1 OR any Pi2
		var url = base + '/index.php?eID=powermailcond_clearSession';
		$.ajax({
			url: url, // send to this url
			cache: false
		});
	}
}

/**
 * Read From uid from DOM
 *
 * @return int		Form uid
 */
function getFormUid() {
	var classes = $('.powermail_form:first').attr('class').split(' ');
	for (var i=0; i < classes.length; i++) {
		if (classes[i].indexOf('powermail_form_') !== -1) {
			var currentClass = classes[i];
		}
	}

	var formUid = currentClass.substr(15);
	return formUid;
}
