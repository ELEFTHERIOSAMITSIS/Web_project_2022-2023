const email=document.getElementById('Some');
email.addEventListener('mouseover',function() {
   email.innerText='Choose a valid email! E.g. example@email.com';
   email.style.color="red";
  });
  email.addEventListener('mouseleave',function() {
    email.innerText='Email';
    email.style.color="black";

   });
   
const password=document.getElementById('pass_txt')
password.addEventListener('mouseover',function() {
    password.innerText='Your password must contain an upercase letter and a special character(e.g.!@#)';
    password.style.color="red"; 
    password.style.fontSize='16px';
});
password.addEventListener('mouseleave',function() {
    password.innerText='Password';
    password.style.color="black"; 
    password.style.fontSize='18px';
});

