function todoListItemHTML(todo) {
    return  "<li id=todoLi" + todo.id + ">" + 
                todo.description + 
                '<input id="deleteTodoBtn" type="button" value="delete" ' +
                    'onclick="deleteTodo(' + todo.id + ')"/>' + 
            "</li>";
}

function submitTodoForm(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: "ajaxProcessTodo.php", 
        type: "POST",
        data: formData,
        success: function(response) {
            console.log(response);
            if (response.id != -1) {
                var newLiItem = $(todoListItemHTML(response)).hide();
                $('ul#todo-list').append(newLiItem);
                newLiItem.fadeIn("slow");
            } else {
                alert('Unable to create todo. Please try again.');
            }
        },
        error: function(xhr, status, error) {
            alert('Unable to create todo. Please try again.');
            console.error(xhr.responseText);
        }
    });
}

function fetchAllTodos() {
    $.ajax({
        url: "ajaxProcessTodo.php",
        type: "GET",
        data: {}, // Do not include id to fetch all records 
        dataType: "json",
        success: function(response) {
            response.forEach(todo => {
                $('ul#todo-list').append(
                    todoListItemHTML(todo)
                );
            });
        },
        error: function(xhr, status, error) {
            alert('Unable to retrieve todo items. Please try again.');
            console.error(xhr.responseText);
        }
    }); 
}

function deleteTodo(todoId) {
    $.ajax({
        url: "ajaxProcessTodo.php",
        type: "DELETE",
        data: JSON.stringify({ id: todoId }),
        contentType: "application/json",
        success: function(response) {
            $('li#todoLi'+response.id).fadeOut("slow", function(){
                $(this).remove();
            });
        },
        error: function(xhr, status, error) {
            alert('Unable to delete todo item. Please try again.');
            console.error(xhr.responseText);
        }
    }); 

}

$(document).ready(function(){
    $('#todoForm').submit(submitTodoForm);
    fetchAllTodos();
});
