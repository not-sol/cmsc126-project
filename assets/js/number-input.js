function isNumber(event) {
    const char = String.fromCharCode(event.keyCode);
    if (!/^\d$/.test(char) && event.keyCode !== 8) {
      event.preventDefault();
    }
}