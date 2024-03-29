<?php
/**
 * @var string $svg_path Path to the plugin SVG icons with trailing slash.
 * @var string|null $content Optional pass-through content from wrapping shortcode usage.
 * @var string $url onepagebooking.com URL to use as a form destination.
 * @var string $button_text Text for the submit button.
 * @var boolean $show_booking_code Whether the booking code input should be rendered.
 */
if ( $content ) {
	echo '<p><?php _e($content) ?></p>';
}
?>
<form id="opbj-form" class="form<?php if ($show_booking_code): echo ' has-booking-code'; endif; ?>" action="<?php echo esc_url( $url, protocols: [ 'https' ] ); ?>" target="_blank">
	<fieldset id="calendar" class="calendar form__group form__group--shadow">
		<div class="calendar__date">
			<?php echo file_get_contents( $svg_path . 'checkin.svg' ); ?>
			<div>
				<div class="date__label"><?php _e( 'Arrival', 'onepagebooking-wp' ); ?></div>
				<b id="arrival-formatted" class="form__selection">
					<?php _e( 'choose', 'onepagebooking-wp' ); ?>
				</b>
			</div>
		</div>
		<div class="calendar__date">
			<?php echo file_get_contents( $svg_path . 'checkout.svg' ); ?>
			<div>
				<div class="date__label"><?php _e( 'Departure', 'onepagebooking-wp' ); ?></div>
				<b id="departure-formatted" class="form__selection">
					<?php _e( 'choose', 'onepagebooking-wp' ); ?>
				</b>
			</div>
		</div>
		<!-- hidden inputs filled from calendar widget. We cannot require hidden fields. -->
		<input type="hidden" id="arrival" name="arrival"/>
		<input type="hidden" id="departure" name="departure"/>
	</fieldset>
	<fieldset class="form__group form__group--shadow form__group--flex" id="guest-selection-trigger">
		<?php echo file_get_contents( $svg_path . 'guests.svg' ); ?>
		<span class="counter__wrapper"><input data-display="adults-counter" name="adults" id="adults"
											  class="input--disabled text--bold"
											  value="2" readonly tabindex="-1"/>&nbsp;<label
					for="adults"><?php _e( 'Adults', 'onepagebooking-wp' ); ?></label></span><span
				class="counter__wrapper"><input
					data-display="children-counter" name="children" id="children" value="0" readonly tabindex="-1"
					class="input--disabled text--bold"/>&nbsp;<label
					for="children"><?php _e( 'Children', 'onepagebooking-wp' ) ?></label></span>
	</fieldset>

	<?php if ($show_booking_code): ?>
	<label class="show-for-sr" for="bookingcode"><?php _e( 'Booking code', 'onepagebooking-wp' ); ?></label>
	<input class="input--standalone" type="text" name="bookingcode" id="bookingcode" placeholder="<?php _e( 'Booking code', 'onepagebooking-wp' ); ?>"/>
	<?php endif; ?>

	<input type="hidden" value="" id="ages" name="ages"/>
	<input type="hidden" value="true" name="filter"/>
	<input type="hidden" value="<?php echo get_locale(); ?>" name="lang"/>
	<input type="submit" class="form__group form__submit" value="<?php esc_html_e( $button_text ); ?>"/>
</form>

<dialog id="guest-selection" class="popover">
	<p class="popover__heading popover__section">
		<span>Belegung</span>
		<button type="button" onclick="this.closest('dialog').close('cancel')" class="popover__close">
			<?php echo file_get_contents( $svg_path . 'close.svg' ); ?>
		</button>
	</p>
	<form method="dialog" id="guest-selection-form">
		<section class="popover__section popover__section--flex">
			<label for="adults-counter" autofocus><?php _e( 'Adults', 'onepagebooking-wp' ); ?></label>
			<div class="stepper">
				<button type="button" class="stepper__button" data-decrement="adults-counter">–</button>
				<input type="number" name="adults-counter" id="adults-counter" required min="1" max="30" value="2"
					   disabled
					   class="stepper__input">
				<button type="button" class="stepper__button" data-increment="adults-counter">+</button>
			</div>
		</section>

		<section class="popover__section popover__section--flex">
			<label for="children-counter"><?php _e( 'Children', 'onepagebooking-wp' ); ?></label>
			<div class="stepper">
				<button type="button" class="stepper__button" data-decrement="children-counter">–</button>
				<input type="number" name="children-counter" id="children-counter" max="10" value="0" disabled
					   class="stepper__input">
				<button type="button" class="stepper__button" data-increment="children-counter">+</button>
			</div>
		</section>

		<section class="popover__section" id="children-section" style="display: none">
			<p class="section__heading"><?php _e( 'Children\'s age at checkout', 'onepagebooking-wp' ) ?></p>
			<p>
				<?php _e( 'Please enter the correct age of your children at checkout. This will help us to show you the best price and all important options.', 'onepagebooking-wp' ); ?>
			</p>
			<div id="children-age-inputs" class="select-list"></div>
		</section>
		<section class="popover__section">
			<button type="submit" class="form__submit button"><?php _e( 'Continue', 'onepagebooking-wp' ); ?></button>
		</section>
	</form>
</dialog>
