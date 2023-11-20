<?php
/**
* @var string $svg_path  Path to the plugin SVG icons with trailing slash.
 * @var string|null $content  Optional pass-through content from wrapping shortcode usage.
 */
	if ($content) {
		echo '<p><?php _e($content) ?></p>';
	}
?>
<form id="opbj-form" class="form" action="https://onepagebooking.com/reet-traum-prerow" target="_blank">
        <fieldset id="calendar" class="calendar form__group form__group--shadow">
            <div class="calendar__date">
                <?php echo file_get_contents($svg_path . 'checkin.svg'); ?>
                <div>
                    <div class="date__label">Anreise</div>
                    <b id="arrival-formatted" class="form__selection">
                        wählen
                    </b>
                </div>
            </div>
            <div class="calendar__date">
	            <?php echo file_get_contents($svg_path . 'checkout.svg'); ?>
                <div>
                    <div class="date__label">Abreise</div>
                    <b id="departure-formatted" class="form__selection">
                        wählen
                    </b>
                </div>
            </div>
        </fieldset>
        <fieldset class="form__group form__group--shadow form__group--flex" id="guest-selection-trigger">
	        <?php echo file_get_contents($svg_path . 'guests.svg'); ?>
            <span><input data-display="adults-counter" name="adults" id="adults" class="input--disabled text--bold"
                         value="2" readonly tabindex="-1" />&nbsp;<label for="adults">Erwachsene</label></span><span><input
                        data-display="children-counter" name="children" id="children" value="0" readonly tabindex="-1" class="input--disabled text--bold" />&nbsp;<label>Kinder</label></span>
        </fieldset>

        <!-- hidden inputs filled from calendar widget. We cannot require hidden fields. -->
        <input type="hidden" id="arrival" name="arrival" />
        <input type="hidden" id="departure" name="departure" />
        <input type="hidden" value="" id="ages" name="ages" />

        <input type="submit" class="form__group form__submit" value="Suchen"/>
    </form>

<dialog id="guest-selection" class="popover">
    <p class="popover__heading popover__section">
        <span>Belegung</span>
        <button type="button" onclick="this.closest('dialog').close('cancel')" class="popover__close">
	        <?php echo file_get_contents($svg_path . 'close.svg'); ?>
        </button>
    </p>
    <form method="dialog" id="guest-selection-form">
        <section class="popover__section popover__section--flex">
            <label for="adults-counter" autofocus>Erwachsene</label>
            <div class="stepper">
                <button type="button" class="stepper__button" data-decrement="adults-counter">–</button>
                <input type="number" name="adults-counter" id="adults-counter" required min="1" max="30" value="2" disabled
                       class="stepper__input">
                <button type="button" class="stepper__button" data-increment="adults-counter">+</button>
            </div>
        </section>

        <section class="popover__section popover__section--flex">
            <label for="children-counter">Kinder</label>
            <div class="stepper">
                <button type="button" class="stepper__button" data-decrement="children-counter">–</button>
                <input type="number" name="children-counter" id="children-counter" max="10" value="0" disabled class="stepper__input">
                <button type="button" class="stepper__button" data-increment="children-counter">+</button>
            </div>
        </section>

        <section class="popover__section" id="children-section" style="display: none">
            <p class="section__heading">Alter der Kinder beim Checkout</p>
            <p>
                Bitte geben Sie das richtige Alter Ihrer Kinder beim Checkout an. Das hilft uns den für Sie besten
                Preis und
                alle wichtigen Optionen anzuzeigen.
            </p>
            <div id="children-age-inputs" class="select-list"></div>
        </section>
        <section class="popover__section">
            <button type="submit" class="form__submit button">Weiter</button>
        </section>
    </form>
</dialog>