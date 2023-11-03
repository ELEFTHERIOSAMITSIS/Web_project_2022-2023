const password=document.getElementById('newPassword')
password.addEventListener('mouseover',function() {
    password.innerText='Your password must contain an upercase letter, a number and a special character(e.g.!@#)';
    password.style.color="red"; 
    password.style.fontSize='16px';
});
password.addEventListener('mouseleave',function() {
    password.innerText='Password';
    password.style.color="black"; 
    password.style.fontSize='18px';
});

var timeoutDuration = 600000; //10 minutes
var timeout = setTimeout(function() {
    window.location.href = "../login_register/log_in.php";
}, timeoutDuration);

window.addEventListener('mousemove', resetTimer);
window.addEventListener('click', resetTimer);

function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(function() {
        window.location.href = "../login_register/log_in.php";
    }, timeoutDuration);
}