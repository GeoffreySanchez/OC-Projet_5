$(window).scroll(function ()
{
    if ($(this).scrollTop() >= 50)  // Si scroll > 50px
    {
        $('#return-to-top').fadeIn(200);    // animation à l'apparition
    } else
        {
            $('#return-to-top').fadeOut(200);   // animation à la disparition
        }
});

$('#return-to-top').click(function ()   // Quand on click sur le bouton
{
    $('body,html').animate(
        {
        scrollTop: 0    // Scroll au top de la page
    }, 600);    // vitesse du scroll
});