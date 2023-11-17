function showDialog() {
    dialog.show();
}

function closeDialog() {
    dialog.close();
}

function decrement(inputName) {
    const input = dialogForm.elements.namedItem(inputName);
    if (input.valueAsNumber === 0) {
        return;
    }
    input.value = input.valueAsNumber - 1;
    input.dispatchEvent(new InputEvent('input'));
}

function increment(inputName) {
    const input = dialogForm.elements.namedItem(inputName);
    input.value = input.valueAsNumber + 1;
    input.dispatchEvent(new InputEvent('input'));
}

function serializeChildrenAge(event) {
    const ageInputs = dialog.querySelectorAll('#children-age-inputs > select');
    agesParameterInput.value = Array.from(ageInputs).map(input => input.value).join(',');
}

function toggleChildrenAgeInputSection(event) {
    const inputAmount = event.target.valueAsNumber;
    template = document.getElementById('children-section').style.display = inputAmount > 0 ? 'block': 'none';
}

function addChildrenAgeInput(event) {
    const inputAmount = event.target.valueAsNumber;
    const ageInputContainer = dialog.querySelector('#children-age-inputs');
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

const form = document.forms['opbj-form'];
const germanDateFormatter = new Intl.DateTimeFormat('de-DE', { year: "numeric", month: "2-digit", day: "2-digit"});
const germanDateDisplayFormatter = new Intl.DateTimeFormat('de-DE', {weekday: 'short', day: 'numeric', 'month': 'short'});

const dialog = document.getElementById('guest-selection');
const dialogForm = document.forms['guest-selection-form'];
const childrenCounter = dialog.querySelector('#children');
childrenCounter.addEventListener('input', addChildrenAgeInput);
childrenCounter.addEventListener('input', toggleChildrenAgeInputSection);
const agesParameterInput = dialog.querySelector('#ages');

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
                calendar.hide();
            } else {
                form.elements.namedItem('departure').value = '';
            }
        },
    },
};

const calendar = new VanillaCalendar('#calendar', options);
calendar.init();
