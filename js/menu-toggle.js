const menu = document.getElementsByClassName('menu-toggle')[0];
// console.log(menu);
menu.addEventListener('click', (e) => {
    let icon = e.target.classList;
    icon.toggle('fa-close');
    icon.toggle('fa-bars');
})