<?php 
/**
 *
 * Filename: send.php
 * Last update:  Thursday, December 15, 2005 20:36:21
 * Version: 1.0
 * Project: sms_api
 *
 * @version 1.0
 * @author Aleksandar Markovic <mikikg@gmail.com>                    
 * @copyright Copyright (c) 2005 Aleksandar Markovic
 * @copyright Copyright (c) 2005 NETSECTOR.NET
 *
 */ 

/* Load sms-api class */
require_once ("sms_api.php");

/* Initialize object */
$mysms = new sms();

/* Send message or print SMS credit balance */
if ($_GET['balance']<>1) {
    $results = $mysms->send($_POST['to'],$_POST['from'],$_POST['message']);
    echo "Sending results: ". $results;
} else {
    $balance = $mysms->getbalance();
    echo "Current SMS balance: ".$balance;
}

?>