<?php

?>
<style type="text/css">
<!--
    div.zone { border: none; border-radius: 1mm; background: #FFFFFF; border-collapse: collapse; padding:3mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: #DD0000; font-size: 7mm; }
    h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative; }
-->
</style>
<page format="a4" orientation="L" backcolor="#EEEEEE" style="font: arial;">
<bookmark title="Reservation <?php echo $TITLE;?>" level="0" ></bookmark>
<a name="reservation_<?php echo $TITLE;?>"></a>
    <table style="width: 99%;border: none;" cellspacing="4mm" cellpadding="0">
        <tr>
            <td style="width: 100%">
                <div class="zone" style="height: 34mm;position: relative;font-size: 5mm;">
                    <div style="position: absolute; right: 3mm; bottom: 3mm; text-align: right; font-size: 4mm; ">
                        <b><?php echo $NUMBER;?></b> items<br>
                        Price: <b><?php echo $value; ?>  <?php echo $eshopoptions['currency_symbol']; ?></b><br>
                        Date: <b><?php echo $DATE; ?></b><br>
                        Order Number: <b><?php echo $TRANSID; ?></b><br>
                    </div>
                    <img src="<?php echo $invoice_options['company_logo']; ?> alt='logo'">
                    <h1><?php echo $TITLE;?></h1>
                    &nbsp;&nbsp;&nbsp;&nbsp;<b>Option: <?php echo $item; ?></b><?php echo $optsets; ?><br>
                </div>
            </td>
        </tr>
    
    </table>
</page>
<?php

?>