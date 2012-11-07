<style type="text/css">
<!--
table { vertical-align: top; }
tr    { vertical-align: top; }
td    { vertical-align: top; }
}
-->
</style>
<page backcolor="#FEFEFE" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" backbottom="30mm" footer="date;heure;page" style="font-size: 12pt">
    <bookmark title="Facture/Invoice" level="0" ></bookmark>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px">
        <tr style='vertical-align:middle'>
            <td style="width: 50%;vertical-align:middle;text-align:left;margin-left:40px;">
                <b><font style='font-size:20pt'><?php if(isset($COPY)) {echo $COPY;} else {echo $invoice_options['status_'.$status.'_title'];} ?></font></b>
            </td>
            <td style="width: 50%; color: #444444;">
            <?php if ($invoice_options['company_logo'] != "") { ?>
                <img src="<?php echo $invoice_options['company_logo']; ?>" alt='logo'>
            <?php } ?>
                <h1><?php echo $invoice_options['company_name']; ?></h1>
                <?php echo $invoice_options['invoice_emitter']; ?>
            </td>
        </tr>
    </table>
    
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
        <tr>
            <td style="width:50%;"></td>
            <td style="width:14%; ">Client:</td>
            <td style="width:36%"><?php echo $CLIENT_NAME; ?></td>
        </tr>
        <tr>
            <td style="width:50%;"></td>
            <td style="width:14%; ">Company:</td>
            <td style="width:36%"><?php echo $CLIENT_COMPANY; ?></td>
        </tr>
        
        <tr>
            <td style="width:50%;"></td>
            <td style="width:14%; ">Address:</td>
            <td style="width:36%">
                <?php echo nl2br($CLIENT_ADDRESS); ?>
            </td>
        </tr>
        <tr>
            <td style="width:50%;"></td>
            <td style="width:14%; ">Email:</td>
            <td style="width:36%"><?php echo $CLIENT_EMAIL; ?></td>
        </tr>
        <tr>
            <td style="width:50%;"></td>
            <td style="width:14%; ">Tel:</td>
            <td style="width:36%"><?php echo $CLIENT_PHONE; ?></td>
        </tr>        <tr>
            <td style="width:50%;"></td>
            <td style="width:14%; ">Ref:</td>
            <td style="width:36%"><i><?php echo $TRANSID; ?></i></td>
        </tr>
    </table>
    <br>
    <br>
    
    <br>
    <br>
    <?php echo $invoice_options['politeness']; ?><br>
    <br>
    <br>
    <?php echo $invoice_options['status_'.$status]?>.<br>
    <br>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
        <tr>
            <th style="width: 12%">Options</th>
            <th style="width: 52%">Description</th>
            <th style="width: 13%">Price</th>
            <th style="width: 10%">Quantity</th>
            <th style="width: 13%">Total Price</th>
        </tr>
    </table>
<?php
echo $DETAILS;
?>
    <table cellspacing="0" style="width: 100%; border: solid 1px black; background: #E7E7E7; text-align: center; font-size: 10pt;">
        <tr>
            <th style="width: 87%; text-align: right;">Total: </th>
            <th style="width: 13%; text-align: right;"><?php echo number_format($total, 2, ',', ' '); ?> <?php echo $eshopoptions['currency_symbol']; ?></th>
        </tr>
    </table>
    <div align='right'> <?php echo $PAID." ".$PAIDVIA; ?></div>
    <br>
   
    <nobreak>
        <br>
        
        <br>
        <table cellspacing="0" style="width: 100%; text-align: left;">
            <tr>
                <td style="width:65%;"></td>
                <td style="width:35%; ">
                    <?php echo $invoice_options['politeness2']; ?><br>
                    <br>
                    &nbsp;&nbsp;<?php echo $invoice_options['signature']; ?><br>
                </td>
            </tr>
        </table>
    </nobreak>
</page>