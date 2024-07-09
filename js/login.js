const centerInput = document.getElementById('center');
const suggestionsBox = document.getElementById('centerSuggestions');


centerInput.addEventListener('input', function () {
    const value = this.value.toLowerCase();
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
});

document.addEventListener('click', function (event) {
    if (!suggestionsBox.contains(event.target) && event.target !== centerInput) {
        suggestionsBox.innerHTML = '';
    }
});

centerInput.addEventListener('blur', function () {
    if (!suggestions.includes(centerInput.value)) {
        centerInput.value = '';
    }
});