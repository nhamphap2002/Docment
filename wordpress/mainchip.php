<?php
/**
 * Description: Handle Formidable Form submit action.
 * to validate car type.
 
 */

/* Handle form submit action */
add_filter('frm_validate_entry', 'validate_my_form', 20, 3);
function validate_my_form($value1, $values, $value3) {
    $form_id = 13;
    $year_id = 55;
    $fuel_id = 56;
    $country_id = 60;
    $compatible_yes = 61;
    $compatible_no = 62;

    $year = $_POST['item_meta'][$year_id];
    $fuel = $_POST['item_meta'][$fuel_id];
    $country = $_POST['item_meta'][$country_id];
    $petrol = 'Petrol/Gasoline';
    $diesel = 'Diesel';
    $mailchimp = 'mc4wp-subscribe';
    /*******************************************/
    if ($values['form_id'] == $form_id) {
        $_POST['item_meta'][$mailchimp] = '1';
        if (isset($country) && (strpos($fuel, 'Hybrid') !== FALSE)) {
            $_POST['item_meta'][$compatible_yes] = 'Confirmed';
        } else if ($country == 'Australia') {
            return check_compability('2006', '2006', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'New Zeland') {
            return check_compability('2006', '2006', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'United States of America') {
            return check_compability('1996', '1996', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Canada') {
            return check_compability('1996', '1996', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'England') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Belgium') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Croatia') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Czech Republic') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Denmark') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'France') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Ireland') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Italy') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Norway') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Portugal') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'Scotland') {
            return check_compability('2001', '2004', $fuel, $petrol, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else if ($country == 'India') {
            return check_compability('0', '2010', $fuel, 0, $diesel, $year, $errors, $values, $compatible_yes, $compatible_no);
        } else {
            $_POST['item_meta'][$compatible_no] = '';
            add_filter('frm_main_feedback', 'frm_main_feedback', 20, 3);
        }
    }
    return $value1;
}