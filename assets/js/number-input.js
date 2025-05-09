function isNumber(event) {
    const key = event.key;
    const allowedKeys = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Delete', '.'];

    if (!/^\d$/.test(key) && !allowedKeys.includes(key)) {
        event.preventDefault();
    }
}