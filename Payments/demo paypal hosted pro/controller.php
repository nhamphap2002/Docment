<?php
// Include functions
include 'functions.php';

// Prepare processes
switch ($_GET['task']) {
	
    case 'add_order':
        addOrder($_POST);
        break;
		
	case 'confirm_order':
		confirmOrder($_GET['id']);
		break;
		
    case 'cancel_order':
        cancelOrder($_GET['id']);
        break;
		
    case 'update_ipn':
        setOrderStatus(1, 11);
        break;
		
    case 'verify_ipn':
        readIPN($_POST);
        break;
		
	case 'generate_pdf':
		createPDF($_GET['id']);
		break;
		
}

?>