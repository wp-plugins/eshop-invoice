<?php

ob_start();
define('WP_USE_THEMES', false);
require('../../../../../wp-load.php' );
$current_user = wp_get_current_user();
$uid = $current_user->ID;

$TRANSID = $_GET['invoice'];
if(isset($_GET['admin_override']) and current_user_can('administrator') ) {
    $ADMIN_OVERRIDE = $_GET['admin_override'];
    }
else {
    $ADMIN_OVERRIDE = "no";
    }

header('Content-type: application/pdf');

$invoice_options = get_option( 'eShopInvoice_options' );


include('../../../eshop/eshop-admin-functions.php');




$dtable=$wpdb->prefix.'eshop_orders';
$itable=$wpdb->prefix.'eshop_order_items';

if($ADMIN_OVERRIDE == 'yes') {
    $myrowres=$wpdb->get_results("Select * From $dtable where transid = '$TRANSID'");
    }
else{
    $myrowres=$wpdb->get_results("Select * From $dtable where user_id='$uid' and transid = '$TRANSID'");
    }

if(count($myrowres) == 1) {
    $myrowres = $myrowres[0];
    $CLIENT_NAME = $myrowres->first_name.' '.$myrowres->last_name;
    $eshop = $current_user->eshop;
   
    $CLIENT_ADDRESS = $myrowres->address1.'<br>'.$myrowres->address2.'<br>'.$myrowres->country.$myrowres->zip.' '.$myrowres->city;
    $CLIENT_EMAIL = $myrowres->email ;
    $CLIENT_PHONE = $myrowres->phone;
    $CLIENT_COMPANY = $myrowres->company;
    
    $DATE = eshop_real_date($myrowres->custom_field);
    $DATE = explode(' ',$DATE);
    $DATE = $DATE[0];
    
    $DETAILS = "";
    
    $PAIDVIA=$myrowres->paidvia;
    $status = $myrowres->status;
    $status = strtolower($status);
        
    $DETAILS ='<table cellspacing="0" style="width: 100%; border: solid 1px black; background: #F7F7F7; text-align: center; font-size: 10pt;">';
    $c++;
          
    $checkid=$myrowres->checkid;

    $itemrowres=$wpdb->get_results("Select * From $itable where checkid='$checkid'");

    $total=0;

    $x=-1;
    
    foreach($itemrowres as $itemrow){
        if($itemrow->post_id != 0)
            $title = get_the_title($itemrow->post_id);
            $value=$itemrow->item_qty * $itemrow->item_amt;
        
        $total=$total+$value;
        if($value != 0)
            {
            $item = $itemrow->item_id;
            $DETAILS .= '<tr>
                <td style="width: 12%; text-align: left">'.$itemrow->optsets.'</td>
                <td style="width: 52%; text-align: left">'.$title.'<br>'.$item.'</td>
                <td style="width: 13%; text-align: right">'.$itemrow->item_amt.'&euro;</td>
                <td style="width: 10%">'.$itemrow->item_qty.'</td>
                <td style="width: 13%; text-align: right;">'.number_format($value, 2, ',', ' ').' &euro;</td>
            </tr>';
            }
        $x++;
        
        }
    $DETAILS .= '</table>';
    if ($status == 'sent' or $status == 'completed')
        $PAID = $invoice_options['paid'];
    else
        $PAID = $invoice_options['tobepaid'];
    
    include( dirname(__FILE__).'/invoice_part1.php');
    
    //PART 2
    if($status == 'waiting') {
        $COPY = $invoice_options['merchant_copy'].' '.$invoice_options['company_name'];
        include( dirname(__FILE__).'/invoice_part1.php');
        }
       
    if($status=='sent' or $status =='completed') {
        foreach($itemrowres as $itemrow){
            if($itemrow->post_id != 0) {
                $TITLE = get_the_title($itemrow->post_id);
                $item = $itemrow->item_id;
                $NUMBER = $itemrow->item_qty;
                $optsets = $itemrow->optsets;
                $value=$itemrow->item_qty * $itemrow->item_amt;

                include( dirname(__FILE__).'/invoice_part2.php');
                }
            }
        }

    
    $content = ob_get_contents();
    ob_end_clean();
    // convert to PDF
    require_once('../../html2pdf/html2pdf.class.php');

    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output($invoice_options['status_'.$status.'_title']."-".$TRANSID.".pdf",'D');        
    };

?>