<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo Azericard Task</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <style>
        /* Basic Style */
        body {
            background: #fff;
            color: #333;
            font-family: Lato, sans-serif;
        }
        .container {
            display: block;
            width: 500px;
            margin: 20px auto 0;
        }
        ul {
            margin: 0;
            padding: 0;
        }
        li * {
            float: left;
        }
        li, h3 {
            clear:both;
            list-style:none;
        }
        input, button {
            outline: none;
        }
        button {
            background: none;
            border: 0px;
            color: #888;
            font-size: 15px;
            width: 60px;
            margin: 10px 0 0;
            font-family: Lato, sans-serif;
            cursor: pointer;
        }
        button:hover {
            color: #333;
        }
        /* Heading */
        h3,
        label[for='new-task'] {
            color: #333;
            font-weight: 700;
            font-size: 15px;
            border-bottom: 2px solid #333;
            padding: 30px 0 10px;
            margin: 0;
            text-transform: uppercase;
        }
        input[type="text"] {
            margin: 0;
            font-size: 18px;
            line-height: 18px;
            height: 18px;
            padding: 10px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 6px;
            font-family: Lato, sans-serif;
            color: #888;
        }
        input[type="text"]:focus {
            color: #333;
        }

        /* New Task */
        label[for='new-task'] {
            display: block;
            margin: 0 0 20px;
        }
        input#new-task {
            float: left;
            width: 318px;
        }
        p > button:hover {
            color: #0FC57C;
        }

        /* Task list */
        li {
            overflow: hidden;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        li > input[type="checkbox"] {
            margin: 0 10px;
            position: relative;
            top: 15px;
        }
        li > label {
            font-size: 18px;
            line-height: 40px;
            width: 237px;
            padding: 0 0 0 11px;
        }
        li >  input[type="text"] {
            width: 226px;
        }
        li > .delete:hover {
            color: #CF2323;
        }

        /* Completed */
        #completed-tasks label {
            text-decoration: line-through;
            color: #888;
        }

        /* Edit Task */
        ul li input[type=text] {
            display:none;
        }

        ul li.editMode input[type=text] {
            display:block;
        }

        ul li.editMode label {
            display:none;
        }
    </style>
</head>
<body>
<div class="container">
    <p>
        <label for="new-task">Add Item</label><input id="new-task" type="text"><button>Add</button>
    </p>

    <h3>Todo</h3>
    <ul id="incomplete-tasks">
        @if(!empty($todolist))
            @foreach($todolist as $todo)
        <li data-id="{{$todo->id}}">
            <input type="checkbox">
            <label>{{$todo->content}}</label>
            <input type="text">
            <button class="edit">Edit</button>
            <button class="delete">Delete</button>
        </li>
            @endforeach
        @endif
    </ul>

    <h3>Completed</h3>
    <ul id="completed-tasks">
        @if(!empty($completed))
            @foreach($completed as $todo)
                <li data-id="{{$todo->id}}">
                    <input type="checkbox">
                    <label>{{$todo->content}}</label>
                    <input type="text">
                    <button class="edit">Edit</button>
                    <button class="delete">Delete</button>
                </li>
            @endforeach
        @endif
    </ul>
</div>

<script type="text/javascript">
    var taskInput = document.getElementById("new-task");
    var addButton = document.getElementsByTagName("button")[0];
    var incompleteTasksHolder = document.getElementById("incomplete-tasks");
    var completedTasksHolder = document.getElementById("completed-tasks");

    //New Task List Item
    var createNewTaskElement = function(taskString,taskid) {
        //Create List Item
        var listItem = document.createElement("li");
        listItem.setAttribute('data-id', taskid);
        //input (checkbox)
        var checkBox = document.createElement("input"); // checkbox
        //label
        var label = document.createElement("label");
        //input (text)
        var editInput = document.createElement("input"); // text
        //button.edit
        var editButton = document.createElement("button");
        //button.delete
        var deleteButton = document.createElement("button");

        //Each element needs modifying

        checkBox.type = "checkbox";
        editInput.type = "text";

        editButton.innerText = "Edit";
        editButton.className = "edit";
        deleteButton.innerText = "Delete";
        deleteButton.className = "delete";

        label.innerText = taskString;


        // each element needs appending
        listItem.appendChild(checkBox);
        listItem.appendChild(label);
        listItem.appendChild(editInput);
        listItem.appendChild(editButton);
        listItem.appendChild(deleteButton);

        return listItem;
    }

    // Add a new task
    var addTask = function() {
        console.log("Add task...");
        //Create a new list item with the text from #new-task:
        var content = taskInput.value;
        var csrf    = document.querySelector("meta[name='csrf-token']").getAttribute("content");
        console.log(csrf);
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                //Append listItem to incompleteTasksHolder
                var listItem = createNewTaskElement(content,response);
                incompleteTasksHolder.appendChild(listItem);
                bindTaskEvents(listItem, taskCompleted);
            }
        }
        xhttp.open("GET", "task/store?content="+content+"&_token="+csrf);
        xhttp.send();
        taskInput.value = "";
    }

    // Edit an existing task
    var editTask = function() {
        console.log("Edit Task...");

        var listItem = this.parentNode;
        var data_id  = listItem.getAttribute('data-id');
        var editInput = listItem.querySelector("input[type=text]")
        var label = listItem.querySelector("label");
        var containsClass = listItem.classList.contains("editMode");
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                if(containsClass) {
                    //switch from .editMode
                    //Make label text become the input's value
                    label.innerText = response;
                } else {
                    //Switch to .editMode
                    //input value becomes the label's text
                    editInput.value = label.innerText;
                }
            }
        }
        xhttp.open("GET", "task/edit?content="+editInput.value+"&id="+data_id);
        xhttp.send();

        // Toggle .editMode on the parent
        listItem.classList.toggle("editMode");

    }


    // Delete an existing task
    var deleteTask = function() {
        console.log("Delete task...");
        var listItem = this.parentNode;
        var ul = listItem.parentNode;
        var data_id  = listItem.getAttribute('data-id');
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if(this.responseText == 'ok')
            {
                //Remove the parent list item from the ul
                ul.removeChild(listItem);
            }
        }
        xhttp.open("GET", "task/delete?id="+data_id);
        xhttp.send();
    }

    // Mark a task as complete
    var taskCompleted = function() {
        console.log("Task complete...");
        //Append the task list item to the #completed-tasks
        var listItem = this.parentNode;
        var data_id  = listItem.getAttribute('data-id');
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if(this.responseText == 'ok')
            {
                completedTasksHolder.appendChild(listItem);
                bindTaskEvents(listItem, taskIncomplete);
            }
        }
        xhttp.open("GET", "task/mark?id="+data_id);
        xhttp.send();

    }

    // Mark a task as incomplete
    var taskIncomplete = function() {
        console.log("Task Incomplete...");
        // When checkbox is unchecked
        // Append the task list item #incomplete-tasks
        var listItem = this.parentNode;
        var data_id  = listItem.getAttribute('data-id');
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if(this.responseText == 'ok')
            {
                incompleteTasksHolder.appendChild(listItem);
                bindTaskEvents(listItem, taskCompleted);
            }
        }
        xhttp.open("GET", "task/mark?id="+data_id);
        xhttp.send();
    }

    var bindTaskEvents = function(taskListItem, checkBoxEventHandler) {
        console.log("Bind list item events");
        //select taskListItem's children
        var checkBox = taskListItem.querySelector("input[type=checkbox]");
        var editButton = taskListItem.querySelector("button.edit");
        var deleteButton = taskListItem.querySelector("button.delete");

        //bind editTask to edit button
        editButton.onclick = editTask;

        //bind deleteTask to delete button
        deleteButton.onclick = deleteTask;

        //bind checkBoxEventHandler to checkbox
        checkBox.onchange = checkBoxEventHandler;
    }

    // Set the click handler to the addTask function
    addButton.addEventListener("click", addTask);


    // Cycle over the incompleteTaskHolder ul list items
    for(var i = 0; i <  incompleteTasksHolder.children.length; i++) {
        bindTaskEvents(incompleteTasksHolder.children[i], taskCompleted);
    }
    // Cycle over the completeTaskHolder ul list items
    for(var i = 0; i <  completedTasksHolder.children.length; i++) {
        bindTaskEvents(completedTasksHolder.children[i], taskIncomplete);

    }
</script>

</body>
</html>
