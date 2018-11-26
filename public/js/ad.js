$('#add-image').click(function(){
    // Récupération du numéro du futur champ à créer
    const index = +$('#widgets-counter').val();
    // Récupération du prototype
    const tmplt = $('#ad_images').data('prototype').replace(/__name__/g, index);

    console.log(tmplt);
    $('#ad_images').append(tmplt);

    $('#widgets-counter').val(index + 1);

    handleDeleteButton();
});

function handleDeleteButton() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

handleDeleteButton();