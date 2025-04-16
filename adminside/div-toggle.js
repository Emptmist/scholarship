//switching divs
function replaceDiv() {
    const div1 = document.getElementById('div1');
    const div2 = document.getElementById('div2');

    if (div1.style.display === 'none') {
        div1.style.display = 'block';
        div2.style.display = 'none';
    } else {
        div1.style.display = 'none';
        div2.style.display = 'flex';
    }
}
