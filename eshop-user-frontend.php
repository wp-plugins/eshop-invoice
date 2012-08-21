<?php

add_shortcode('eshop_invoice_user_frontend','eshop_invoice_user_frontend');


function eshop_invoice_user_frontend($atts, $content = ''){
    global $current_user;
    get_currentuserinfo();
    $uid = $current_user->ID;
    
    global $wpdb,$eshopoptions;
    $dtable=$wpdb->prefix.'eshop_orders';

    $itable=$wpdb->prefix.'eshop_order_items';
    
    $myrowres=$wpdb->get_results("Select * From $dtable where user_id='$uid' ");
    $c = 0; 
    if(count($myrowres) != 0) {
    echo '<div class="orderlist tablecontainer" >';

        echo '<table class="hidealllabels" summary="order listing" style="font-size:12px;border:1px solid black;width:85%" >

        <thead>

        <tr>

        <th id="date" style="text-align:center">'.__('Ordered on','eshop').'</th>

        <th id="transid" style="text-align:center">'.__('Transaction','eshop').'</th>

        <th id="price" style="text-align:center">'.__('Price','eshop').'</th>

        <th id="state" style="text-align:center">'.__('Order Status','eshop').'</th>
        
        <th id="invoice" style="text-align:center">'.__('Invoice','eshop').'</th>

        </tr></thead><tbody>'."\n";
        
        foreach($myrowres as $myrow){
            $c++;
          
            $checkid=$myrow->checkid;

            $itemrowres=$wpdb->get_results("Select * From $itable where checkid='$checkid'");

            $status=$myrow->status;
            
            $paidvia=$myrow->paidvia;

            $total=0;

            $x=-1;
            $detail = "";
            $transcontent = '';
            foreach($itemrowres as $itemrow){
                if($itemrow->post_id != 0)
                    $transcontent .= "<a href=". get_permalink($itemrow->post_id)." target='_blank' style='color:#F56127'>".get_the_title($itemrow->post_id)."</a><br>";
                    $value=$itemrow->item_qty * $itemrow->item_amt;
                
                $total=$total+$value;
                if($value != 0)
                    {
                    $date = explode(' : ', $itemrow->item_id);
                    $transcontent .= $itemrow->item_qty."x ".$itemrow->optsets." : ".$value."&euro; (".$date[1].")<br>";
                    }
                $x++;
                
                }          
            


            
            //~ echo $paidvia;
            
            if($status=='Completed'){$status=__('Shipped','eshop');}

            if($status=='Pending'){$status=__('Pending','eshop');}

            if($status=='Waiting'){$status=__('Awaiting Payment','eshop');}

            if($status=='Sent'){$status=__('Shipped','eshop');}

            if($status=='Deleted'){$status=__('Deleted','eshop');}

            if($status=='Failed'){$status=__('Failed','eshop');}
           
            
            
              
              $thisdate = eshop_real_date($myrow->custom_field);


                if($myrow->company!=''){

                    $company=__(' of ','eshop').$myrow->company;

                }else{

                    $company='';

                }
            
                $currsymbol=$eshopoptions['currency_symbol'];
                $pay = "";
                $invoice = "";
                $inoptions = get_option('eShopInvoice_options'); 
                $template = $inoptions['template'];
                if($status == __('Awaiting Payment','eshop')) {
                    $pay = '';
                    $invoice = "<a href='".plugins_url()."/eshop-invoice/templates/".$template."/invoice.php?invoice=".$myrow->transid."' style='color:#F56127'><img src='".plugins_url( 'eshop-invoice/pdf.png' , dirname(__FILE__) )."'><br>".__('Invoice','eshop')."</a>";
                    }
                
                else {
                    $pay = "";
                    if($status == __('Shipped','eshop'))
                        {
                        $invoice = "<a href='".plugins_url()."/eshop-invoice/templates/".$template."/invoice.php?invoice=".$myrow->transid."' style='color:#F56127'><img src='".plugins_url( 'eshop-invoice/pdf.png' , dirname(__FILE__) )."'><br>".__('Invoice','eshop')." & Voucher</a>";
                        }
                    }
                
                echo '<tr'.$alt.' style="font-size:12px;border:1px solid black;text-align:center">

                <td headers="date numb'.$c.'" style="font-size:12px;border:1px solid black;">'.$thisdate.'</td>

                <td headers="transid numb'.$c.'" style="font-size:12px;border:1px solid black;">'.$transcontent.'<br><i>'.$myrow->transid.'</i></td>

                <td headers="price numb'.$c.'" class="right" style="font-size:12px;border:1px solid black;">'.sprintf( __('%1$s%2$s','eshop'), $currsymbol, number_format_i18n($total, __('2','eshop'))).'</td>

                <td headers="state numb'.$c.'" class="right" style="font-size:12px;border:1px solid black;">'.$status.'<br>'.$pay.'</td>
                
                <td headers="invoice numb'.$c.'" class="right" style="font-size:12px;border:1px solid black;">'.$invoice.'</td>

                </tr>';
                
                
         
         }
        echo "</tbody></table></div>\n";
    }
    else {
        echo "You did not place any order yet...";
        }
    
}

?>