<?php
/*
Plugin Name: eShop Invoice
Plugin URI: http://www.pyphp.be/wordpress/eshop-invoice/
Description: eShop Invoice is a plugin to the eShop Plugin by Rich Pedley (http://quirm.net/)
Version: 0.3.3
Author: Thomas Lecocq
Author URI: http://pyphp.be

    Copyright 2012  T LECOCQ  (email : thlecocq@gmail.com)
    
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

include('eshop-user-frontend.php');
include('myorder-widget.php');

// add the admin options page
add_action('admin_menu', 'eShopInvoice_admin_add_page');
function eShopInvoice_admin_add_page() {
$eshopinvoice = add_options_page('eShop Invoice Options', 'eShop Invoice', 'manage_options', 'eShopInvoice', 'eShopInvoice_options_page');
add_action('admin_head-{$eshopinvoice}', 'embedUploaderCode');
}


function embedUploaderCode() {
?>
    <script type="text/javascript">
    function send_to_editor(html){
            url = jQuery(html).attr('href');
            jQuery('#myInputField').val(url);
            tb_remove(); } 
    </script>
<?php 
}

// display the admin options page
function eShopInvoice_options_page() {
?>
<div>
<h1>eShop Invoice Configuration</h1>

<form action="options.php" method="post">
<?php settings_fields('eShopInvoice_options'); ?>
<br>
<?php do_settings_sections('eShopInvoice'); ?>
<div align='center'>
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" class="button-primary"/>
</div>
</form>
<?php $options = get_option('eShopInvoice_options'); $template = $options['template']; ?>

<form action="<?php echo plugin_dir_url( __FILE__ ); ?>templates/<?php echo $template;?>/invoice.php" method='GET'>
Transaction ID : <input type='text' name='invoice' size=50>
<input type='hidden' name='admin_override' value='yes'>
<input type='submit' class="button-primary" value="Show Invoice">
</form>
</div>
<?php
}


function eShopInvoice_defined_options() {
    $eShopInvoice_options = array(
            array("name" => __('Company Name'),
                            "desc" => __('This will be used many times in the ouput'),
                            "id" => 'company_name',
                            "std" => "My Company Name",
                            "type" => "text",
                            "section" => "general_settings"),
            array("name" => __('Company Logo'),
                            "desc" => __('URL of the logo for you invoice'),
                            "id" => 'company_logo',
                            "std" => "",
                            "type" => "image",
                            "section" => "general_settings"),
            array(	"name" => __('Emitter'),
                            "desc" => __('The person/departemnt emitting the invoice'),
                            "id" => 'invoice_emitter',
                            "std" => "Order Dept",
                            "type" => "text",
                            "section" => "general_settings"),
            array(	"name" => __('Company Address (line 1)'),
                            "desc" => __('The mailing address of your company'),
                            "id" => 'address1',
                            "std" => "Nowhere road, 6",
                            "type" => "text",
                            "section" => "general_settings"),
            array(	"name" => __('Company Address (line 2)'),
                            "desc" => __('The mailing address of your company'),
                            "id" => 'address2',
                            "std" => "Office X/123",
                            "type" => "text",
                            "section" => "general_settings"),
            array(	"name" => __('Company Address (line 3)'),
                            "desc" => __('The mailing address of your company'),
                            "id" => 'address3',
                            "std" => "BE-1160 Brussels",
                            "type" => "text",
                            "section" => "general_settings"),
            array(	"name" => __('Politeness'),
                            "desc" => __('The first line that will be displayed'),
                            "id" => 'politeness',
                            "std" => "Dear Madam, Dear Sir, Dear Client",
                            "type" => "text",
                            "section" => "general_settings"),            
            
            array(	"name" => __('Politeness 2'),
                            "desc" => __('The last line that will be displayed'),
                            "id" => 'politeness2',
                            "std" => "Sincerely,",
                            "type" => "text",
                            "section" => "general_settings"),            
            
            array(	"name" => __('Signature'),
                            "desc" => __('The signature at the bottom'),
                            "id" => 'signature',
                            "std" => "Your Company",
                            "type" => "text",
                            "section" => "general_settings"),
            
            array(	"name" => __('Template'),
                            "desc" => __('The template of the invoice'),
                            "id" => 'template',
                            "std" => "default",
                            "type" => "template",
                            "section" => "general_settings"),
            
// STATUS SETTINGS :
            array(	"name" => __('Completed'),
                            "desc" => __('If the status is "Completed"'),
                            "id" => 'status_completed',
                            "std" => "Thank you for your order, which is successful",
                            "type" => "text",
                            "section" => "status_settings"),
            array(	"name" => __('Completed Invoice Title'),
                            "desc" => __('The word(s) that will be written in uppercase on the left'),
                            "id" => 'status_completed_title',
                            "std" => "INVOICE",
                            "type" => "text",
                            "section" => "status_settings"), 
                            
            array(	"name" => __('Pending'),
                            "desc" => __('If the status is').' "'.__('Pending').'"',
                            "id" => 'status_pending',
                            "std" => "Thank you for your order, which is pending...",
                            "type" => "text",
                            "section" => "status_settings"),
            array(	"name" => __('Pending Invoice Title'),
                            "desc" => __('The word(s) that will be written in uppercase on the left'),
                            "id" => 'status_pending_title',
                            "std" => "ORDER",
                            "type" => "text",
                            "section" => "status_settings"), 
                            
            array(	"name" => __('Waiting'),
                            "desc" => __('If the status is').' "'.__('Waiting').'"',
                            "id" => 'status_waiting',
                            "std" => "Thank you for your order, we are now waiting for your payment",
                            "type" => "text",
                            "section" => "status_settings"),
            array(	"name" => __('Waiting Invoice Title'),
                            "desc" => __('The word(s) that will be written in uppercase on the left'),
                            "id" => 'status_waiting_title',
                            "std" => "ORDER",
                            "type" => "text",
                            "section" => "status_settings"),            
            array(	"name" => __('Merchant Copy'),
                            "desc" => __('The word(s) that will be written on the left when the order is Pending/Waiting (Merchant Copy)'),
                            "id" => 'merchant_copy',
                            "std" => "COPY for",
                            "type" => "text",
                            "section" => "status_settings"),
            array(	"name" => __('To be Paid'),
                            "desc" => __('The word(s) that will be written before the Payment Type under the total when invoice hasn\'t been paid'),
                            "id" => 'tobepaid',
                            "std" => "To be paid via",
                            "type" => "text",
                            "section" => "status_settings"),
            array(	"name" => __('Paid'),
                            "desc" => __('The word(s) that will be written before the Payment Type under the total when invoice is paid'),
                            "id" => 'paid',
                            "std" => "Paid via",
                            "type" => "text",
                            "section" => "status_settings"),
    
            array(	"name" => __('Sent'),
                            "desc" => __('If the status is "Sent"'),
                            "id" => 'status_sent',
                            "std" => "Thank you for your order, which is successful and has been shipped already",
                            "type" => "text",
                            "section" => "status_settings"),
            array(	"name" => __('Sent Invoice Title'),
                            "desc" => __('The word(s) that will be written in uppercase on the left'),
                            "id" => 'status_sent_title',
                            "std" => "INVOICE",
                            "type" => "text",
                            "section" => "status_settings"),

        );
    return $eShopInvoice_options;
}

function eShopInvoice_defined_sections() {
    $eShopInvoice_sections = array(
        array(
                "name" => "General Settings",
                "id" => "general_settings",
                "desc" => "General Settings will be set up in this section",),
        array(
                "name" => "Status Settings",
                "id" => "status_settings",
                "desc" => "Text that will be output according to the status",)
        );
    return $eShopInvoice_sections;
    }
    

function eShopInvoice_get_default_options() {
    $options = array();
 
    foreach(eShopInvoice_defined_options() as $option) {
     $options[$option['id']]=$option['std'];
    }
    
 return $options;
}

function eShopInvoice_options_init() {
     // set options equal to defaults
     $options = get_option( 'eShopInvoice_options' );
     if ( false === $options ) {
        $options = eShopInvoice_get_default_options();
     }
     update_option( 'eShopInvoice_options', $options );
}
// Initialize Plugin options
register_activation_hook( __FILE__, 'eShopInvoice_options_init' );

// add the admin settings and such
add_action('admin_init', 'eShopInvoice_admin_init');

function eShopInvoice_admin_init(){
    $eShopInvoice_options = eShopInvoice_get_default_options();
    register_setting( 'eShopInvoice_options', 'eShopInvoice_options', 'eShopInvoice_options_validate' );

    foreach(eShopInvoice_defined_sections() as $settings) {
        add_settings_section($settings['id'], $settings['name'], "eShopInvoice_settings_section", 'eShopInvoice');
        foreach(eShopInvoice_defined_options() as $setting) {
            if($setting['section'] == $settings['id'])
                add_settings_field('eShopInvoice_'.$setting['id'], "<h2>".$setting['name']."</h2><i>".$setting['desc']."</i>", 'eShopInvoice_setting_'.$setting['type'], 'eShopInvoice', $settings['id'],array( 'id' => $setting['id'], label_for=>'eShopInvoice_'.$setting['id']));
        }
};

}

function eShopInvoice_settings_section() {
    echo "<hr>";
}


function eShopInvoice_setting_text($args) {

extract( $args);
$name = "eShopInvoice_options[$id]";
$inputid = "eShopInvoice_$id";
$options = get_option('eShopInvoice_options');
$value = $options[$id];

echo "<input id='$inputid' name='$name' size='80' type='text' value='$value' />";
} 

function eShopInvoice_setting_image($args) {

extract( $args);
$name = "eShopInvoice_options[$id]";
$inputid = "eShopInvoice_$id";
$options = get_option('eShopInvoice_options');
$value = $options[$id];

echo "<input id='myInputField' class='myInputField' name='$name' size='80' type='text' value='$value' /><br>";
echo '<a href="#" onclick="tb_show(\'\', \'media-upload.php?TB_iframe=true\');">Upload/Select from Media Library</a>';
}

function eShopInvoice_setting_template($args) {

extract( $args);
$name = "eShopInvoice_options[$id]";
$inputid = "eShopInvoice_$id";
$options = get_option('eShopInvoice_options');
$value = $options[$id];
$dirs = scandir(plugin_dir_path( __FILE__ ).'templates');

echo "<select id='$inputid' name='$name'>";

foreach($dirs as $dir) {
   if($dir != '.' and $dir != '..') { 
        if($dir == $value)
            $selected = 'SELECTED';
        else
            $selected = '';
        echo "<option value='".$dir."' $selected>".$dir."</option>";
        }
}
echo "</select><br>";

}

// validate our options
function eShopInvoice_options_validate($input) {
$options = get_option('eShopInvoice_options');
$defined_options = eShopInvoice_defined_options();
foreach($defined_options as $defined_option) {
    $options[$defined_option['id']] = $input[$defined_option['id']];
    }
return $options;
}
?>