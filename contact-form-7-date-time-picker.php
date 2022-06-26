<?php

/**
 * Plugin Name: Contact Form 7 Date Time Picker
 * Plugin URI: https://wpapplab.com/
 * Description: This plugin can be used to display date and time picker into Contact Form 7 text input field by using css class. This plugin specifically designed to work with Contact Form 7.
 * Version: 1.0.0
 * Author: Arafat Rahman
 * Author URI: https://riyadly.com
 * Text Domain: rmcf7-datetimepicker
 *
 * @package Date Timepicker Demo
 */

/* Tag generator */

add_action( 'wpcf7_admin_init', 'current_date_time_tag_menu', 25, 0 );

function current_date_time_tag_menu() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'currentdt', __( 'current date-time', 'contact-form-7' ),
		'wpcf7_current_date_time' );
}

function wpcf7_current_date_time( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );

   

	$description = __( "Generate a form-tag for Current date & time. For more details, see how to add for contact form 7 %s.", 'contact-form-7' );

	$desc_link = wpcf7_link( __( 'https://contactform7.com/checkboxes-radio-buttons-and-menus/', 'contact-form-7' ), __( 'currentdt', 'contact-form-7' ) );

?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

<table class="form-table">
<tbody>


	<tr>
	<th scope="row"><?php echo esc_html( __( 'Display Options', 'contact-form-7' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Display Options', 'contact-form-7' ) ); ?></legend>
		<label><input type="checkbox" name="onlyTime" class="option" /> <?php echo esc_html( __( 'Show only time', 'contact-form-7' ) ); ?></label><br />
		<label><input type="checkbox" name="onlyDate" class="option" /> <?php echo esc_html( __( 'Show only date', 'contact-form-7' ) ); ?></label><br />
        <label><input type="checkbox" name="dateTime" class="option" /> <?php echo esc_html( __( 'Show datetime', 'contact-form-7' ) ); ?></label>
		</fieldset>
	</td>
	</tr>

    
	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label></th>
	<td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?></label></th>
	<td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
	</tr>

</tbody>
</table>
</fieldset>
</div>

<div class="insert-box">
	<input type="text" name="currentdt" class="tag code" readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>

	<br class="clear" />

	<p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding current date time tag <b>[currentdt]</b> into the field on the currentdt tab", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
</div>
<?php
}

add_action( 'wpcf7_init', 'custom_add_form_tag_currentdt' );

function custom_add_form_tag_currentdt() {
  wpcf7_add_form_tag( 'currentdt', 'custom_currentdt_form_tag_handler' ); // "currentdt" is the type of the form-tag
}

function custom_currentdt_form_tag_handler( $tag ) {


    if (!empty($tag->options)) {

       
        $onlyDate = in_array('onlyDate',$tag->options);
		$onlyTime = in_array('onlyTime',$tag->options);
		$displayBoth = in_array('dateTime',$tag->options);

        if(!empty($displayBoth)){
            return getDateTime();
        }elseif(!empty($onlyDate)){
            return date (get_option( 'date_format' ));
        }elseif(!empty($onlyTime)){
            return date_i18n( get_option( 'time_format' ) );
        }
    }

    return getDateTime();
}

function getDateTime() {
    return ' '.date (get_option( 'date_format' )).' - '.date_i18n( get_option( 'time_format' ) );
}

