window.addEventListener('load', function () {
    var switchButton = $('.toggleInscription');
    switchButton.click(function(event){
        event.preventDefault();
        $('#inscriptionForm').toggle();
        $('#connexionForm').toggle();
        switchButton.toggle();
    });
});