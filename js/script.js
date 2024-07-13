
function onlyDigits(event) {
    // Allow only backspace, delete, left arrow, and right arrow keys
    if (event.key === 'Backspace' || event.key === 'Delete' || event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
        return true;
    }

    // Check if the key pressed is a digit (0-9)
    const isDigit = /\d/.test(event.key);

    // Limit input to 10 digits
    const inputField = event.target;
    if (inputField.value.length >= 10 && !isDigit) {
        event.preventDefault();
        return false;
    }

    return isDigit;
}


