const centerInput = document.getElementById('center');
const suggestionsBox = document.getElementById('centerSuggestions');

function updateSuggestions(value) {
    suggestionsBox.innerHTML = '';
    if (value) {
        const filteredSuggestions = suggestions.filter(suggestion => suggestion.toLowerCase().includes(value));
        filteredSuggestions.forEach(suggestion => {
            const div = document.createElement('div');
            div.classList.add('suggestion');
            div.textContent = suggestion;
            div.addEventListener('click', function () {
                centerInput.value = suggestion;
                suggestionsBox.innerHTML = '';
            });
            suggestionsBox.appendChild(div);
        });
    }
}

centerInput.addEventListener('input', function () {
    const value = this.value.toLowerCase();
    updateSuggestions(value);
});

centerInput.addEventListener('focus', function () {
    const value = this.value.toLowerCase();
    updateSuggestions(value);
});

document.addEventListener('click', function (event) {
    try {
        if (!suggestionsBox.contains(event.target) && event.target !== centerInput) {
            suggestionsBox.innerHTML = '';
        }
    } catch (error) {
        console.error(error);
    }
});

centerInput.addEventListener('blur', function () {
    if (!suggestions.includes(centerInput.value)) {
        centerInput.value = '';
    }
});
