function serializeChildrenAge(event) {
    const ageInputs = form.querySelectorAll('#children-age-inputs > select');
    agesParameterInput.value = Array.from(ageInputs).map(input => input.value).join(',');
}

function addChildrenAgeInput(event) {
    const inputAmount = event.target.valueAsNumber;

    const ageInputContainer = form.querySelector('#children-age-inputs');
    const existingInputs = ageInputContainer.childElementCount;

    if (existingInputs > inputAmount) {
        for (let i = existingInputs; i > inputAmount; i--) {
            ageInputContainer.removeChild(ageInputContainer.lastChild);
        }
    } else {
        for (let i = existingInputs; i < inputAmount; i++) {
            let newInput = document.createElement('select');
            newInput.id = 'age-input-child-' + (i + 1);
            // newInput.name = 'ages[]'
            newInput.addEventListener('change', serializeChildrenAge)

            for (let i = 0; i < 18; i++) {
                newInput.add(new Option(i + ' Jahre alt', i.toString()))
            }
            ageInputContainer.appendChild(newInput);
        }
    }
}

function formatDisplayDateHTML(date) {
    return germanDateDisplayFormatter
        .formatToParts(date)
        .filter(part => ['day', 'month', 'year'].includes(part.type))
        .map(part => {
            switch (part.type) {
                case "day":
                    return `<p class="big">${part.value}</p>`;
                default:
                    return part.value;
            }
        }).join(' ');
}

const form = document.forms['opb-booking-form'];
const germanDateFormatter = new Intl.DateTimeFormat('de-DE', { year: "numeric", month: "2-digit", day: "2-digit"});
const germanDateDisplayFormatter = new Intl.DateTimeFormat('de-DE', { year: "numeric", month: "short", day: "2-digit"});

//const childrenCounter = form.querySelector('#children');
//childrenCounter.addEventListener('input', addChildrenAgeInput);
//const agesParameterInput = form.querySelector('#ages');

const options = {
    lang: 'de',
    input: true,
    type: 'multiple',
    settings: {
        range: {
            disablePast: true,
        },
        selection: {
            day: 'multiple-ranged',
        },
        visibility: {
            daysOutside: false,
        },
    },
    actions: {
        changeToInput(e, calendar, dates, time, hours, minutes, keeping) {
            // Start date handling.
            if (dates.length > 0) {
                const startDate = Date.parse(dates[0]);
                // onepagebooking requires dd.mm.yyyy format instead of a sane standard.
                form.elements.namedItem('arrival').value = germanDateFormatter.format(startDate);
                calendar.HTMLInputElement.querySelector('#arrival-formatted').innerHTML = formatDisplayDateHTML(startDate);

            } else {
                form.elements.namedItem('arrival').value = '';
            }
            // End date handling.
            if (dates.length > 1) {
                const endDate = Date.parse(dates.at(-1));
                // onepagebooking requires dd.mm.yyyy format instead of a sane standard.
                form.elements.namedItem('departure').value = germanDateFormatter.format(endDate);
                calendar.HTMLInputElement.querySelector('#departure-formatted').innerHTML = formatDisplayDateHTML(endDate);
                calendar.hide();
            } else {
                console.debug('no end date');
                form.elements.namedItem('departure').value = '';
            }
        },
    },
};

const calendar = new VanillaCalendar('#calendar', options);
calendar.init();
