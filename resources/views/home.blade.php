<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>ToDO app</title>

</head>
<body>

<!-- Button trigger modal -->
<div class="container-fluid ">
    <div class="row task-head">
        <div class="col-xl-2 offset-xl-5"><h1>To Do List</h1></div>
        <div class="col-xl-1 offset-xl-4 task-add"> Add New</div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="row ul-header">
                <div class="task-name col-xl-2"><b>Name</b></div>
                <div class="task-due-date col-xl-1"><b>Due Date</b></div>
                <div class="task-person col-xl-1"><b>Person</b></div>
                <div class="task-description col-xl-5"><b>Description</b></div>
                <div class="task-description col-xl-1"><b>Status</b></div>
                <div class="task-description col-xl-2"><b>Options</b></div>
            </div>
            <div class="row">
                <ul id="list-task" class="container-fluid">
                    <li class="row">
                        <div class="task-name col-xl-2"></div>
                        <div class="task-due-date col-xl-1"></div>
                        <div class="task-person col-xl-1"></div>
                        <textarea readonly class="task-description col-xl-5"></textarea>
                        <div class="task-status col-xl-1"></div>
                        <div class="col-xl-2">
                            <div class="container-fluid">
                                <div class="row">
                                    <div id="task-edit" class="task-edit col-xl-4">Edit</div>
                                    <div class="task-delete col-xl-4">Delete</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="add-edit-modal" tabindex="-1" role="dialog" aria-labelledby="add-edit-modal-label"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-edit-modal-title">Add Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-edit-form">
                    <div class="container-fluid">
                        <div class="row modal-row">
                            <div class="col-xl-2">Name</div>
                            <input class="col-xl-4" type="text" name="name" id="name" placeholder="Fix add field">
                            <div class="col-xl-2">Person</div>
                            <input class="col-xl-4" type="text" name="person" id="person" placeholder="Janez">
                        </div>

                        <div class="row">
                            <label id="name-error" class="error col-xl-4 offset-xl-2" for="name"></label>
                            <label id="person-error " class="error col-xl-4 offset-xl-2" for="person"></label>
                        </div>

                        <div class="row modal-row">
                            <div class="col-xl-2 due-date-label">Due Date</div>
                            <input class="col-xl-4" name="dueDate" id="due-date" type="text" autocomplete="off">
                            <label class="set-as-done col-xl-4">Set As Done <input class="" type="checkbox"
                                                                                   name="status" id="status"/></label>
                        </div>

                        <div class="row">
                            <label id="due-date-error" class="error col-xl-4" for="due-date"></label>
                        </div>

                        <div class="row modal-row">
                            <div class="col-xl-2">Description</div>
                            <textarea class="col-xl-12" type="text" rows="4" name="description"
                                      placeholder="Add validation allowing numbers only (Max 400 characters)"
                                      id="description"></textarea>
                        </div>

                        <div class="row">
                            <label id="description-error" class="error col-xl-4" for="description"></label>
                        </div>

                        <div class=" footer-modal row ">
                            <div class="col-xl-2 close-modal" data-dismiss="modal">Close</div>
                            <div id="submitForm" class="col-xl-2 offset-xl-8">Add Task</div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{asset("js/home.js")}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('css/home.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    var _token = '{{csrf_token()}}'
</script>
</body>
</html>
