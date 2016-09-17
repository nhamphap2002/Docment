function validate_cvv(str) {

  if(jQuery("input#place_order").attr("disabled") != "disabled") {

    jQuery("input#place_order").attr("disabled", "disabled");

    jQuery("input#place_order").val("Please enter 3 or 4 numbers in the card security code field");

  }

  

  for(var i = 0; i < str.length; i ++) {

    if(isNaN(parseInt(str.charAt(i), 10)) || i > 3) return;

  }

  

  if(i > 2) {

    jQuery("input#place_order").removeAttr("disabled");

    jQuery("input#place_order").val("Place order");

  }
}

function dbShowHide(element1, element2){
	jQuery("#" + element1).show();
	jQuery("#" + element2).hide();
}

function dbShowHidePlan(item_value){
	if(item_value == 'Payment Plan'){
		jQuery("#db_plan").show();
		jQuery("#db_total_plan").show();
		jQuery("#db_total_oneoff").hide();
	} else {
		jQuery("#db_total_oneoff").show();
		jQuery("#db_total_plan").hide();
		jQuery("#db_plan").hide();
	}
}

function dbShowTotalInfo(total){
	var db_instalment_amount = parseFloat(jQuery("#db_instalment_amount").val());
	var db_schedulefrequency = jQuery("#db_schedulefrequency").val();
	
	var db_total_info = '';
	
	term = Math.ceil(total/db_instalment_amount);
	recur_total = db_instalment_amount * term;
	recur_total = recur_total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	db_total_info = "Total Amount: $" + recur_total + "<br/>Number of Payments: " + term + "<br/>Frequency: " + db_schedulefrequency;

	jQuery("#db_total_plan_info").html(db_total_info);
}