
function dropDown() {
    var item = document.getElementById('nav-links');

    if (item.className === 'nav-links')
        item.className += ' toggle-menu';
    else
        item.className = 'nav-links';
}