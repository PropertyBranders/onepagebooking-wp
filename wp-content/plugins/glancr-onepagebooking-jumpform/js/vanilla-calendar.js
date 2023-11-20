const options = {
    input: true,
    type: 'multiple',
    months: 2,
    jumpMonths: 1,
    settings: {
        lang: 'de',
        range: {
            disablePast: true,
        },
        selection: {
            day: 'multiple-ranged',
        },
        visibility: {
            daysOutside: false,
            weekend: false,
            theme: 'light'
        },
    },
    actions: {
        changeToInput(e, calendar, dates, time, hours, minutes, keeping) {
            // Start date handling.
            if (dates.length > 0) {
                const startDate = Date.parse(dates[0]);
                // onepagebooking requires dd.mm.yyyy format instead of a sane standard.
                form.elements.namedItem('arrival').value = germanDateFormatter.format(startDate);
                calendar.HTMLInputElement.querySelector('#arrival-formatted').innerHTML = germanDateDisplayFormatter.format(startDate);
            } else {
                form.elements.namedItem('arrival').value = '';
            }
            // End date handling.
            if (dates.length > 1) {
                const endDate = Date.parse(dates.at(-1));
                // onepagebooking requires dd.mm.yyyy format instead of a sane standard.
                form.elements.namedItem('departure').value = germanDateFormatter.format(endDate);
                calendar.HTMLInputElement.querySelector('#departure-formatted').innerHTML = germanDateDisplayFormatter.format(endDate);

                const mobileFooter = calendar.HTMLElement.querySelector('.vanilla-calendar-custom-footer');
                if (mobileFooter) {
                    const arrival = Date.parse(dates[0]);
                    const departure = Date.parse(dates.at(-1));
                    const difference  = (departure - arrival) / 86400000;
                    mobileFooter.querySelector('#mobile-calendar-selection').innerText = `${germanDatePopoverFormatter.format(arrival)} – ${germanDatePopoverFormatter.format(departure)} (${difference} Nächte)`;
                    const footerButton = mobileFooter.querySelector('button');
                    footerButton.disabled = false;
                    footerButton.addEventListener('click', () => calendar.hide());
                } else {
                    calendar.hide();
                }

            } else {
                form.elements.namedItem('departure').value = '';
            }
        },
    },
};

if (window.innerWidth <= 500) {
    //options.type = 'default';
    //options.months = 1;
    options.actions.showCalendar = function (input, element) {
        element.querySelector('.popover__close').addEventListener('click', () => {
            element.classList.add('vanilla-calendar_hidden')
        })
    },
    options.DOMTemplates = {
        multiple: `
      <header class="vanilla-calendar-custom-header popover__heading popover__section">
        <span>Belegung</span>
        <button type="button" class="popover__close"">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" viewBox="0 0 36 36"><defs><filter id="b" width="108.3%" height="108.3%" x="-4.2%" y="-4.2%" filterUnits="objectBoundingBox"><feOffset in="SourceAlpha" result="shadowOffsetOuter1"/><feGaussianBlur in="shadowOffsetOuter1" result="shadowBlurOuter1" stdDeviation=".5"/><feColorMatrix in="shadowBlurOuter1" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.5 0"/></filter><circle id="a" cx="18" cy="18" r="18"/></defs><g fill="none" fill-rule="evenodd"><use xlink:href="#a" fill="#000" filter="url(#b)"/><use xlink:href="#a" fill="#FFF"/><path fill="#4B4F63" fill-rule="nonzero" d="M11.8228373,11.8228258 C11.5883826,12.0572803 11.2090481,12.0572803 10.9743309,11.8228258 L5.99990158,6.84727643 L1.02434738,11.8228258 C0.789892663,12.0572803 0.410558211,12.0572803 0.175841035,11.8228258 C-0.0586136782,11.5883713 -0.0586136782,11.2090372 0.175841035,10.9743203 L5.15252008,5.99989575 L0.17659093,1.02434638 C-0.0578637831,0.789891897 -0.0578637831,0.410557813 0.17659093,0.175840864 C0.411045643,-0.0586136214 0.790380095,-0.0586136214 1.02509727,0.175840864 L5.99990158,5.15251508 L10.9754558,0.176965706 C11.2099105,-0.0574887798 11.5892449,-0.0574887798 11.8239621,0.176965706 C12.0584168,0.411420191 12.0584168,0.790754276 11.8239621,1.02547122 L6.84728308,5.99989575 L11.8228373,10.9754451 C12.0590542,11.2079124 12.0590542,11.5903585 11.8228373,11.8228258 Z" transform="translate(12 12)"/></g></svg>
        </button>
      </header>
      <div class="vanilla-calendar-controls">
        <#ArrowPrev />
        <#ArrowNext />
      </div>
      <div class="vanilla-calendar-grid">
        <#Multiple>
          <div class="vanilla-calendar-column">
            <div class="vanilla-calendar-header">
              <div class="vanilla-calendar-header__content">
                <#Month />
                <#Year />
              </div>
            </div>
            <div class="vanilla-calendar-wrapper">
              <#WeekNumbers />
              <div class="vanilla-calendar-content">
                <#Week />
                <#Days />
              </div>
            </div>
          </div>
        <#/Multiple>
      </div>
      <#ControlTime />
    
      <footer class="vanilla-calendar-custom-footer">
        <div id="mobile-calendar-selection">&nbsp;</div>
        <button type="button" class="form__submit button" disabled>Weiter</button>
      </footer>
    `
    }
}

const form = document.forms['opbj-form'];
const germanDateFormatter = new Intl.DateTimeFormat('de-DE', { year: "numeric", month: "2-digit", day: "2-digit"});
const germanDateDisplayFormatter = new Intl.DateTimeFormat('de-DE', {weekday: 'short', day: 'numeric', 'month': 'short'});
const germanDatePopoverFormatter = new Intl.DateTimeFormat('de-DE', {day: 'numeric', month: 'short', year: 'numeric'})
export let calendar = new VanillaCalendar('#calendar', options);
