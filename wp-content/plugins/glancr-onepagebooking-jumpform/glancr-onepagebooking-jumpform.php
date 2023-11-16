<?php
/*
* Plugin Name: Jump Form
*/

add_shortcode( 'opb_jumpform', 'opb_jumpform_shortcode' );

wp_register_style('VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.css');
wp_register_style('VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/themes/light.min.css');
wp_register_script( 'VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js' );

function opb_jumpform_shortcode( $attributes = [], $content = null ): string {
	wp_enqueue_style( 'VanillaCalendar' );
	wp_enqueue_script( 'VanillaCalendar', args: ['strategy' => 'defer'] );
	wp_enqueue_script(
		'glancr-onepagebooking-jumpform-script',
		plugin_dir_url( __FILE__ ) . 'js/plugin.js',
		['VanillaCalendar'],
		time(), // Change this to null for production
		true
	);

	return <<<HTML
<!-- FIXME: check why calendar always renders below other elements -->
<style>
.vanilla-calendar {
	z-index: 1000; 
	background-color: white;
	max-width: 40rem;
}

fieldset {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 2.25rem;
            max-width: 540px;

        }

        #calendar {
            display: flex;
            gap: 2.25rem;
        }

        .label {
            color: gray;
            text-transform: uppercase;
        }

        .big {
            font-size: 2rem;
            font-weight: 700;
        }
</style>

<form id="opb-booking-form" action="https://onepagebooking.com/reet-traum-prerow" target="_blank">
<legend>$content</legend>
<fieldset>
        <div id="calendar">
            <div>
                <p class="label">Check-in</p>
                <div id="arrival-formatted">
                    Anreise wählen
                </div>
                <!-- hidden inputs filled from calendar widget. -->
				<input type="hidden" id="arrival" name="arrival" required />
            </div>
            <div>
                <p class="label">Check-Out</p>
                <div id="departure-formatted">
                    <p>Abreise wählen</p>
                </div>
				<input type="hidden" id="departure" name="departure" required />
            </div>
        </div>
        <div>
            <p class="label">Gäste</p>
            <p class="big">2+1</span>
        </div>


<input type="submit" value="Jetzt buchen" />
</fieldset>
</form>

<dialog>
<label for="adults">Anzahl der anreisenden erwachsenen Personen</label>
<input type="number" required min="1" max="30" value="2" name="adults" id="adults">

<label for="children">Anzahl der anreisenden Kinder</label>
<input type="number" name="children" id="children" max="10">

<div id="children-age-inputs" style="display: grid;"></div>
<input type="hidden" value="" id="ages" name="ages" />
</dialog>
HTML;
}
