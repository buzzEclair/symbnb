$('#add-image').click(function(){
   const index = $('#widgets-counter').val();
   const tmpl = $('#other_images').data('prototype').replace(/__name__/g, index);
   $('#other_images').append(tmpl);

   $('#widgets-counter').val(index + 1);
   console.log("lol");
   handleDeleteButtons();
});

function updateCounter(){
   const count = + $('#other_images div.form-group').length;
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