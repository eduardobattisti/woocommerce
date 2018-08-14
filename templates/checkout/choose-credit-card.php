<?php
if ( ! function_exists( 'add_action' ) ) {
	exit( 0 );
}

use Woocommerce\Mundipagg\Core;
use Woocommerce\Mundipagg\Model\Customer;
use Woocommerce\Mundipagg\Model\Setting;
use Woocommerce\Mundipagg\Helper\Utils;

if ( ! is_user_logged_in() ) {
	return;
}

$setting = Setting::get_instance();

if ( ! $setting->is_allowed_save_credit_card() ) {
	return;
}

$customer = new Customer( get_current_user_id() );
$suffix   = isset( $suffix ) ? $suffix : '';

if ( ! $customer->cards ) {
	return;
}

?>

 <p class="form-row form-row-wide">

 	<?php _e( 'Credit cards save', 'woo-mundipagg-payments' ); ?><br>

	<select name="card_id<?php echo $suffix; ?>" id="field-choose-card"
			data-action="select2"
			data-installments-type="<?php echo Setting::get_instance()->cc_installment_type; ?>"
			data-element="choose-credit-card">
		<option value="">
			<?php _e( 'Saved credit card', 'woo-mundipagg-payments' ) ?>
		</option>

		<?php
			foreach ( $customer->cards as $id => $card ) :
				printf(
					'<option data-brand="%s" value="%s">(%s) •••• •••• •••• %s</option>',
					strtolower( $card['brand'] ),
					$id,
					strtoupper( $card['brand'] ),
					$card['last_four_digits']
				);
			endforeach;
		?>
	</select>
 </p>
