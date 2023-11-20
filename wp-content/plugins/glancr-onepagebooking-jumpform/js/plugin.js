import {calendar} from './vanilla-calendar.js';

function showDialog(event) {
    dialog.show();
    event.stopPropagation();
    window.addEventListener('click', (event) => {
        if (!dialog.contains(event.target)) {
            dialog.close();
            window.removeEventListener('click', this)
        }
    })
}

function closeDialog() {
    dialog.close();
}

function decrement(event) {
    const inputName = event.target.dataset.decrement;
    const input = dialogForm.elements.namedItem(inputName);
    if (input.valueAsNumber === 0) {
        return;
    }
    const newValue = input.valueAsNumber - 1;
    input.value = newValue;
    input.dispatchEvent(new InputEvent('input'));
    const displayInput = form.querySelector(`[data-display=${CSS.escape(inputName)}]`);
    displayInput.value = newValue;
    displayInput.dispatchEvent(new InputEvent('input'));
}

function increment(event) {
    const inputName = event.target.dataset.increment;
    const input = dialogForm.elements.namedItem(inputName);
    const newValue = input.valueAsNumber + 1;
    input.value = newValue;
    input.dispatchEvent(new InputEvent('input'));
    const displayInput = form.querySelector(`[data-display=${CSS.escape(inputName)}]`);
    displayInput.value = newValue;
    displayInput.dispatchEvent(new InputEvent('input'));
}

function toggleChildrenAgeInputSection(event) {
    const inputAmount = event.target.valueAsNumber;
    document.getElementById('children-section').style.display = inputAmount > 0 ? 'block': 'none';
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
            newInput.setAttribute('required', "required");
            newInput.classList.add('select-list__input')
            const defaultSelection = new Option('Alter auswählen', '', true, true);
            defaultSelection.disabled = true;
            newInput.add(defaultSelection);
            for (let i = 0; i < 18; i++) {
                newInput.add(new Option(i + ' Jahre alt', i.toString()))
            }
            // We wrap the select inside a container for the cross-browser chevron.
            let container = document.createElement('div');
            container.classList.add('select-list__select');

            // Label for improved accessibility.
            let newLabel = document.createElement('label');
            newLabel.innerText = `Alter für das ${i + 1}. Kind`;
            newLabel.classList.add('select-list__label');

            container.appendChild(newLabel);
            container.appendChild(newInput);
            ageInputContainer.appendChild(container);
        }
    }
}

function fillHiddenInputsFromDialog(event) {
    const dialogForm = event.target.querySelector('form');
    const ageInputs = dialogForm.querySelectorAll('#children-age-inputs > select');
    agesParameterInput.value = Array.from(ageInputs).map(input => input.value).join(',');
}

const form = document.forms['opbj-form'];
const dialog = document.getElementById('guest-selection');
const dialogForm = document.forms['guest-selection-form'];
const childrenCounter = dialog.querySelector('#children-counter');
const agesParameterInput = form.querySelector('#ages');

form.querySelector('#guest-selection-trigger').addEventListener('click', showDialog);

childrenCounter.addEventListener('input', addChildrenAgeInput);
childrenCounter.addEventListener('input', toggleChildrenAgeInputSection);
dialog.addEventListener('close', fillHiddenInputsFromDialog);
dialog.querySelectorAll('.stepper__button[data-increment]').forEach(button => button.addEventListener('click', increment));
dialog.querySelectorAll('.stepper__button[data-decrement]').forEach(button => button.addEventListener('click', decrement));

// Avoid stale values from previous visits, as browsers do cache them.
form.reset();
dialog.querySelector('form').reset();

calendar.init();