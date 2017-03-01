<?php
	header("Content-type: text/javascript");
	require_once('../../../../wp-load.php');
	//main slider


?>



	//form validation
	function validateName(fld) {
		"use strict";
		var error = "";
				
		if (fld.value === '' || fld.value === 'Nickname' || fld.value === 'Enter Your Name..' || fld.value === 'Your Name..') {
			error = "<?php printf ( __( 'You didn\'t enter Your First Name.' , THEME_NAME ));?>\n";
		} else if ((fld.value.length < 2) || (fld.value.length > 200)) {
			error = "<?php printf ( __( 'First Name is the wrong length.' , THEME_NAME ));?>\n";
		}
		return error;
	}
			
	function validateEmail(fld) {
		"use strict";
		var error="";
		var illegalChars = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
				
		if (fld.value === "") {
			error = "<?php printf ( __( 'You didn\'t enter an email address.' , THEME_NAME ));?>\n";
		} else if ( fld.value.match(illegalChars) === null) {
			error = "<?php printf ( __( 'The email address contains illegal characters.' , THEME_NAME ));?>\n";
		}

		return error;

	}
			
	function valName(text) {
		"use strict";
		var error = "";
				
		if (text === '' || text === 'Nickname' || text === 'Enter Your Name..' || text === 'Your Name..') {
			error = "<?php printf ( __( 'You didn\'t enter Your First Name.' , THEME_NAME ));?>\n";
		} else if ((text.length < 2) || (text.length > 50)) {
			error = "<?php printf ( __( 'First Name is the wrong length.' , THEME_NAME ));?>\n";
		}
		return error;
	}
			
	function valEmail(text) {
		"use strict";
		var error="";
		var illegalChars = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
				
		if (text === "") {
			error = "<?php printf ( __( 'You didn\'t enter an email address.' , THEME_NAME ));?>\n";
		} else if ( text.match(illegalChars) === null) {
			error = "<?php printf ( __( 'The email address contains illegal characters.' , THEME_NAME ));?>\n";
		}

		return error;

	}
			
	function validateMessage(fld) {
		"use strict";
		var error = "";
				
		if (fld.value === '') {
			error = "<?php printf ( __( 'You didn\'t enter Your message.' , THEME_NAME ));?>\n";
		} else if (fld.value.length < 3) {
			error = "<?php printf ( __( 'The message is to short.' , THEME_NAME ));?>\n";
		}

		return error;
	}		

	function validatecheckbox() {
		"use strict";
		var error = "<?php _e( 'Please select at least one checkbox!' , THEME_NAME );?>\n";
		return error;
	}

