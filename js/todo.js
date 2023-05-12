$(document).ready(function(){
    $('#todoForm').submit(function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          url: "ajaxProcessTodo.php", 
          type: "POST",
          data: formData,
          success: function(response) {
            if (response.id != -1) {
                $('ul#todo-list').append("<li>" + response.description + "</li>");
            } else {
                alert('Unable to create todo. Please try again.')
            }
          },
          error: function(xhr, status, error) {
            alert('Unable to create todo. Please try again.')
            console.error(xhr.responseText);
          }
        });
    });
});
