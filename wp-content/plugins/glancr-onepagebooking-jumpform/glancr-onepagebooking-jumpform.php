<?php
/*
* Plugin Name: Jump Form
*/

add_shortcode( 'opb_jumpform', 'opb_jumpform_shortcode' );

wp_register_script( 'VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js' );

wp_register_style('VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.css');
wp_register_style('VanillaCalendarLightTheme', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/themes/light.min.css');
wp_register_style('GlancrOnepagebookingJumpform', plugin_dir_url( __FILE__ ) . '/style.css');

function opb_jumpform_shortcode( $attributes = [], $content = null ): string {
	wp_enqueue_style( 'VanillaCalendar' );
	wp_enqueue_style( 'VanillaCalendarLightTheme' );
	wp_enqueue_style( 'GlancrOnepagebookingJumpform', deps: ['skin-material-css'] );

	wp_enqueue_script( 'VanillaCalendar', args: ['strategy' => 'defer'] );
	wp_enqueue_script(
		'glancr-onepagebooking-jumpform-script',
		plugin_dir_url( __FILE__ ) . 'js/plugin.js',
		['VanillaCalendar'],
		time(), // Change this to null for production
		true
	);

	return <<<HTML
<p>$content</p>
<form id="opbj-form" class="form" action="https://onepagebooking.com/reet-traum-prerow" target="_blank">
        <fieldset id="calendar" class="calendar form__group form__group--shadow">
            <div class="calendar__date">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36">
                    <path fill="#4B4F63"
                        d="M16.0714286,25.2722962 L19.6004464,21.7432818 C20.015625,21.3214073 20.6986607,21.3214073 21.1138393,21.7432818 C21.5357143,22.15846 21.5357143,22.841495 21.1138393,23.2566732 L15.7566964,28.6138107 C15.3415179,29.0356853 14.6584821,29.0356853 14.2433036,28.6138107 L8.88616071,23.2566732 C8.46428571,22.841495 8.46428571,22.15846 8.88616071,21.7432818 C9.30133929,21.3214073 9.984375,21.3214073 10.3995536,21.7432818 L13.9285714,25.2722962 L13.9285714,17.14284 C13.9285714,16.5535549 14.4107143,16.0714125 15,16.0714125 C15.5892857,16.0714125 16.0714286,16.5535549 16.0714286,17.14284 L16.0714286,25.2722962 Z M8.57142857,4.28571 L21.4285714,4.28571 L21.4285714,1.0714275 C21.4285714,0.479731663 21.9107143,0 22.5,0 C23.0892857,0 23.5714286,0.479731663 23.5714286,1.0714275 L23.5714286,4.28571 L25.7142857,4.28571 C28.078125,4.28571 30,6.20423487 30,8.57142 L30,29.99997 C30,32.3638069 28.078125,34.28568 25.7142857,34.28568 L4.28571429,34.28568 C1.91852679,34.28568 0,32.3638069 0,29.99997 L0,8.57142 C0,6.20423487 1.91852679,4.28571 4.28571429,4.28571 L6.42857143,4.28571 L6.42857143,1.0714275 C6.42857143,0.479731663 6.91071429,0 7.5,0 C8.08928571,0 8.57142857,0.479731663 8.57142857,1.0714275 L8.57142857,4.28571 Z M2.14285714,29.99997 C2.14285714,31.1852367 3.10245536,32.142825 4.28571429,32.142825 L25.7142857,32.142825 C26.8995536,32.142825 27.8571429,31.1852367 27.8571429,29.99997 L27.8571429,12.85713 L2.14285714,12.85713 L2.14285714,29.99997 Z M2.14285714,8.57142 L2.14285714,10.714275 L27.8571429,10.714275 L27.8571429,8.57142 C27.8571429,7.38615333 26.8995536,6.428565 25.7142857,6.428565 L4.28571429,6.428565 C3.10245536,6.428565 2.14285714,7.38615333 2.14285714,8.57142 Z"
                        transform="translate(3 1)" />
                </svg>
                <div>
                    <div class="date__label">Anreise</div>
                    <div id="arrival-formatted" class="form__selection">
                        wählen
                    </div>
                </div>
            </div>
            <div class="calendar__date">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36">
                    <path fill="#4B4F63"
                        d="M16.0714286,25.2722962 L19.6004464,21.7432818 C20.015625,21.3214073 20.6986607,21.3214073 21.1138393,21.7432818 C21.5357143,22.15846 21.5357143,22.841495 21.1138393,23.2566732 L15.7566964,28.6138107 C15.3415179,29.0356853 14.6584821,29.0356853 14.2433036,28.6138107 L8.88616071,23.2566732 C8.46428571,22.841495 8.46428571,22.15846 8.88616071,21.7432818 C9.30133929,21.3214073 9.984375,21.3214073 10.3995536,21.7432818 L13.9285714,25.2722962 L13.9285714,17.14284 C13.9285714,16.5535549 14.4107143,16.0714125 15,16.0714125 C15.5892857,16.0714125 16.0714286,16.5535549 16.0714286,17.14284 L16.0714286,25.2722962 Z M8.57142857,4.28571 L21.4285714,4.28571 L21.4285714,1.0714275 C21.4285714,0.479731663 21.9107143,0 22.5,0 C23.0892857,0 23.5714286,0.479731663 23.5714286,1.0714275 L23.5714286,4.28571 L25.7142857,4.28571 C28.078125,4.28571 30,6.20423487 30,8.57142 L30,29.99997 C30,32.3638069 28.078125,34.28568 25.7142857,34.28568 L4.28571429,34.28568 C1.91852679,34.28568 0,32.3638069 0,29.99997 L0,8.57142 C0,6.20423487 1.91852679,4.28571 4.28571429,4.28571 L6.42857143,4.28571 L6.42857143,1.0714275 C6.42857143,0.479731663 6.91071429,0 7.5,0 C8.08928571,0 8.57142857,0.479731663 8.57142857,1.0714275 L8.57142857,4.28571 Z M2.14285714,29.99997 C2.14285714,31.1852367 3.10245536,32.142825 4.28571429,32.142825 L25.7142857,32.142825 C26.8995536,32.142825 27.8571429,31.1852367 27.8571429,29.99997 L27.8571429,12.85713 L2.14285714,12.85713 L2.14285714,29.99997 Z M2.14285714,8.57142 L2.14285714,10.714275 L27.8571429,10.714275 L27.8571429,8.57142 C27.8571429,7.38615333 26.8995536,6.428565 25.7142857,6.428565 L4.28571429,6.428565 C3.10245536,6.428565 2.14285714,7.38615333 2.14285714,8.57142 Z"
                        transform="translate(3 1)" />
                </svg>
                <div>
                    <div class="date__label">Abreise</div>
                    <div id="departure-formatted" class="form__selection">
                        wählen
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="form__group form__group--shadow form__group--flex" onclick="showDialog()">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 36 36">
                <path fill="#4B4F63"
                    d="M12.8765625,14.25 L8.1234375,14.25 C3.63609375,14.25 0,17.8875 0,22.3734375 C0,23.2734375 0.7275,24 1.6246875,24 L19.3734375,24 C20.2734375,24 21,23.2734375 21,22.3734375 C21,17.8875 17.3625,14.25 12.8765625,14.25 Z M19.3734375,22.5 L1.6246875,22.5 C1.55625,22.5 1.5,22.44375 1.5,22.3734375 C1.5,18.721875 4.471875,15.75 8.1234375,15.75 L12.8765625,15.75 C16.528125,15.75 19.5,18.721875 19.5,22.3734375 C19.5,22.44375 19.44375,22.5 19.3734375,22.5 Z M10.5,12 C13.8140625,12 16.5,9.31359375 16.5,6 C16.5,2.68640625 13.8140625,0 10.5,0 C7.1859375,0 4.5,2.68640625 4.5,6 C4.5,9.31359375 7.1859375,12 10.5,12 Z M10.5,1.5 C12.9815625,1.5 15,3.5184375 15,6 C15,8.48109375 12.9815625,10.5 10.5,10.5 C8.0184375,10.5 6,8.4796875 6,6 C6,3.5184375 8.0203125,1.5 10.5,1.5 Z M17.5828125,11.296875 C18.4171875,11.75625 19.3265625,12 20.25,12 C23.146875,12 25.5,9.646875 25.5,6.75 C25.5,3.853125 23.146875,1.5 20.25,1.5 C19.6485937,1.5 19.0598437,1.6010625 18.4996875,1.79957813 C18.1093125,1.938 17.9048437,2.36629687 18.0434062,2.75676562 C18.1818281,3.14789063 18.6115312,3.35020313 19.0005937,3.21304687 C19.4015625,3.07171875 19.81875,3 20.25,3 C22.3171875,3 24,4.68234375 24,6.75 C24,8.81765625 22.3171875,10.5 20.25,10.5 C19.59,10.5 18.9417187,10.3264219 18.3759375,9.99890625 C18.0170625,9.79017188 17.5584375,9.91321875 17.35125,10.2720937 C17.1421875,10.63125 17.2640625,11.090625 17.5828125,11.296875 Z M23.0015625,15 L21,15 C20.5854375,15 20.25,15.3354375 20.25,15.75 C20.25,16.1645625 20.5875,16.5 21,16.5 L23.0001562,16.5 C26.034375,16.5 28.5,18.965625 28.5,21.9984375 C28.5,22.275 28.275,22.5 27.9984375,22.5 L23.25,22.5 C22.8354375,22.5 22.5,22.8354375 22.5,23.25 C22.5,23.6645625 22.8354375,24 23.25,24 L27.9984375,24 C29.1046875,24 30,23.1046875 30,21.9984375 C30,18.0984375 26.859375,15 23.0015625,15 Z"
                    transform="translate(3 6)" />
            </svg>
            <span><b>2</b>&nbsp;Erwachsene</span><span><b>0</b>&nbsp;Kinder</span>
        </fieldset>

        <!-- hidden inputs filled from calendar widget. -->
        <input type="hidden" id="arrival" name="arrival" required />
        <input type="hidden" id="departure" name="departure" required />
        <input type="hidden" value="" id="ages" name="ages" />

        <button type="submit" class="form__group form__submit">Suchen</button>
    </form>

<dialog id="guest-selection" class="popover">
    <p class="popover__heading popover__section">
        <span>Belegung</span>
        <button type="button" onclick="closeDialog()" class="popover__close">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22"
                 viewBox="0 0 36 36">
                <defs>
                    <filter id="b" width="108.3%" height="108.3%" x="-4.2%" y="-4.2%" filterUnits="objectBoundingBox">
                        <feOffset in="SourceAlpha" result="shadowOffsetOuter1"/>
                        <feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation=".5"/>
                        <feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.5 0"/>
                    </filter>
                    <circle id="a" cx="18" cy="18" r="18"/>
                </defs>
                <g fill="none" fill-rule="evenodd">
                    <use xlink:href="#a" fill="#000" filter="url(#b)"/>
                    <use xlink:href="#a" fill="#FFF"/>
                    <path fill="#4B4F63" fill-rule="nonzero"
                          d="M11.8228373,11.8228258 C11.5883826,12.0572803 11.2090481,12.0572803 10.9743309,11.8228258 L5.99990158,6.84727643 L1.02434738,11.8228258 C0.789892663,12.0572803 0.410558211,12.0572803 0.175841035,11.8228258 C-0.0586136782,11.5883713 -0.0586136782,11.2090372 0.175841035,10.9743203 L5.15252008,5.99989575 L0.17659093,1.02434638 C-0.0578637831,0.789891897 -0.0578637831,0.410557813 0.17659093,0.175840864 C0.411045643,-0.0586136214 0.790380095,-0.0586136214 1.02509727,0.175840864 L5.99990158,5.15251508 L10.9754558,0.176965706 C11.2099105,-0.0574887798 11.5892449,-0.0574887798 11.8239621,0.176965706 C12.0584168,0.411420191 12.0584168,0.790754276 11.8239621,1.02547122 L6.84728308,5.99989575 L11.8228373,10.9754451 C12.0590542,11.2079124 12.0590542,11.5903585 11.8228373,11.8228258 Z"
                          transform="translate(12 12)"/>
                </g>
            </svg>
        </button>
    </p>
    <form method="dialog" id="guest-selection-form">
        <section class="popover__section popover__section--flex">
            <label for="adults" autofocus>Erwachsene</label>
            <div class="stepper">
                <button type="button" class="stepper__button" onclick="decrement('adults')">–</button>
                <input type="number" required min="1" max="30" value="2" name="adults" id="adults" disabled
                       class="stepper__input">
                <button type="button" class="stepper__button" onclick="increment('adults')">+</button>
            </div>
        </section>

        <section class="popover__section popover__section--flex">
            <label for="children">Kinder</label>
            <div class="stepper">
                <button type="button" class="stepper__button" onclick="decrement('children')">–</button>
                <input type="number" name="children" id="children" max="10" value="0" disabled class="stepper__input">
                <button type="button" class="stepper__button" onclick="increment('children')">+</button>
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
HTML;
}
