function openNav() {
    let sideNav = document.getElementById('mySidenav');
    sideNav.setAttribute("style","width:340px");
    let closebtn = document.getElementById('closebtn');
    closebtn.style.display = "block";
}
function closeNav() {
    let sideNav = document.getElementById('mySidenav');
    sideNav.setAttribute("style","width:0");
    let closebtn = document.getElementById('closebtn');
    closebtn.style.display = "none";
}
