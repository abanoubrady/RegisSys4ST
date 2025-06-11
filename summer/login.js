let backBtn = document.getElementById('backToHome');
backBtn.addEventListener('click', function () {
   
    document.body.style.opacity = '0';

    setTimeout(function () {
        window.location.href = 'style.html'; 
    }, 300); 
});
 

