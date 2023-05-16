function editableTodoHTML(todo) {
    return  '<div class="editable" data-todoid="' + todo.id + '">' + 
                todo.description + 
            '</div>'; 
}

function todoListItemHTML(todo) {
    return  '<li id="todoLi' + todo.id + '" style="white-space: nowrap">' + 
                editableTodoHTML(todo) +
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

function updateTodo(todoId, $inputField) {
    var newDescription = $inputField.val();
    $.ajax({
        url: "ajaxProcessTodo.php",
        type: "UPDATE",
        data: JSON.stringify({ id: todoId, description: newDescription }),
        contentType: "application/json",
        success: function(todo) {
            var $newEditableText = editableTodoHTML(todo);
            $inputField.replaceWith($newEditableText);
            $('li#todoLi' + todo.id).hide().fadeIn("slow");
        },
        error: function(xhr, status, error) {
            alert('Unable to update todo item. Please try again.');
            console.error(xhr.responseText);
        }
    }); 
}

function makeTodosEditable(){
    var $editableText = $(this);
    var todoId = $editableText.data("todoid");
    var currentText = $editableText.text();
    var $inputField = $("<input type='text'>").val(currentText);

    $editableText.replaceWith($inputField);
    $inputField.focus();

    // Update when user clicks away
    $inputField.blur(function() {
        updateTodo(todoId, $inputField);
    });
    // Update when user hits enter
    $inputField.keypress(function(e){
        if (e.which === 13) {
            e.preventDefault();
            updateTodo(todoId, $inputField);
        }
    });
}

function clearTodoForm() {
    $('#todoDescription').val('');
}

$(document).ready(function(){
    $('#todoForm #todoDescription').focus(clearTodoForm);
    $('#todoForm').submit(submitTodoForm);
    fetchAllTodos();
    $(document).on("click", ".editable", makeTodosEditable);
});
