    $('#add-image').click(function(){
        const index = +$('#widgets-counter').val();
        const tmpl = $('#ads_images').data('prototype').replace(/__name__/g, index);
        $('#ads_images').append(tmpl);

        $('#widgets-counter').val(index + 1);

        handleDeleteButtons();
    });

function updateCounter(){
    const count = +$('#ads_images div.form-group').length;

    $('#widgets-counter').val(count);
}

function handleDeleteButtons(){
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target
        console.log(target);
        $(target).remove();
    });
}
updateCounter();
handleDeleteButtons();