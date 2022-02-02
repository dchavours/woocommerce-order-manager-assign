# Readme




Need to use : includes\admin\class-wc-bookings-ajax.php

to populate said array

use this to figure out how to use the blocks Parameter.
	/**
	 * Gets the end time html dropdown.
	 *
	 * @since 1.13.0
	 * @return HTML
	 */
	public function get_end_time_html() {
		$nonce = $_POST['security'];

		if ( ! wp_verify_nonce( $nonce, 'get_end_time_html' ) ) {
			// This nonce is not valid.
			wp_die( esc_html__( 'Cheatin&#8217; huh?', 'woocommerce-bookings' ) );
		}

		$start_date_time      = wc_clean( $_POST['start_date_time'] );
		$product_id           = intval( $_POST['product_id'] );
		$blocks               = wc_clean( $_POST['blocks'] );
		$bookable_product     = wc_get_product( $product_id );
		$booking_form         = new WC_Booking_Form( $bookable_product );
		$resource_id_to_check = absint( wc_clean( $_POST['resource_id'] ) );
		$html                 = $booking_form->get_end_time_html( $blocks, $start_date_time, array(), $resource_id_to_check );

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput
		exit;
	}
