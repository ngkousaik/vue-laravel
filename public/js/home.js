//set the id and edit mode as variables so that they dont get lost during edit/submit calls
var id;
var editMode;

//helper functions
jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
    },
    "Please enter letters only");

$.validator.addMethod("europeanDate", function (value, element) {
        console.log(value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/));
        console.log(value);
        return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
    },
    "Please enter a date in the format dd/mm/yyyy.");

function getCurrentDate() {
    var d = new Date();

    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = (('' + month).length < 2 ? '0' : '') + month + '-'
        + (('' + day).length < 2 ? '0' : '') + day + '-' + d.getFullYear();
    return output;
}


//main function add/delete/edit/refresh
function refreshTasks() {
    $.ajax({
        type: 'GET',
        url: "/gettasks",
        data: {
            _token: _token
        },
        success: function (data) {
            $('#list-task li:not(:last)').remove();
            let template = $('#list-task li:first');
            $.each(data, function (index, value) {
                let cloned = template.clone();
                cloned.find('.task-name').text(value.name);
                cloned.find('.task-person').text(value.person);

                let from = (value.due_date).split("-");

                let temp = from[2] + "-" + from[1] + "-" + from[0];
                cloned.find('.task-due-date').text(temp);
                console.log(temp);
                cloned.find('.task-description').text(value.description);
                if (value.status === false)
                    cloned.find('.task-status').text();
                else
                    cloned.find('.task-status').text('done  ');

                cloned.find('.task-edit').prop('id', value.id);

                cloned.find('.task-delete').prop('id', value.id);
                cloned.insertBefore('#list-task li:last');
            });

            $('#list-task li:last').remove();
        }
    });
}

function deleteTask(id) {
    let temp = id;
    swal({
        title: "Are you sure?",
        text: "Task will be permanently deleted",
        icon: "warning",
        buttons: true,
        dangerMode: true
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: '/deletetask',
                    data: {
                        id: temp,
                        _token: _token
                    },
                    success: function (data) {
                        swal({
                            title: "Success",
                            text: "Task Deleted",
                            icon: "success",
                        });
                        refreshTasks();
                    },
                    error: function (err) {
                        swal({

                            text: err.statusText,
                            icon: "warning",
                            dangerMode: true
                        })
                    }
                })
            }
        });
}

function addEditTask(id, editMode) {

    if (editMode) {
        prepareModal();
        loadData(id);
    }

    if (editMode === undefined) {
        editMode = false;
        id = null;
    }
    $('#add-edit-modal').modal('show');
    var validator = $('#add-edit-form').validate({


        rules: {
            name: {
                required: true,
                lettersonly: true
            },
            dueDate: {
                required: true,
                europeanDate: true

            },
            person: {
                required: true,
                lettersonly: true
            },
            description: {
                required: true,
                maxlength: 400
            }
        },
        submitHandler: function () {
            $.ajax({
                type: 'POST',
                url: editMode ? '/edittask' : "/addtask",
                data: {
                    name: $('#name').val(),
                    dueDate: $('#due-date').val(),
                    person: $('#person').val(),
                    description: $('#description').val(),
                    status: $('#status').prop('checked'),
                    id: id,
                    _token: _token
                },
                success: function (data) {

                    $('#add-edit-modal').modal('hide');
                    refreshTasks();

                },
                error: function (data) {
                    var errors = data.responseJSON.message;

                    swal({

                        text: errors,
                        icon: "warning",
                        dangerMode: true
                    })
                }
            })
        }
    });

    // validator.destroy();
}

//assistant function to edit mode
function prepareModal() {
    $('#add-edit-modal-title').html('Edit Task');
    $('#submitForm').html('Update');
    $('.set-as-done').css({'display': 'block'});
}

function loadData(id) {
    $.ajax({
        type: 'POST',
        url: '/loadtask',
        data: {
            id: id,
            _token: _token
        },
        success: function (data) {
            fillModalFields(data);
        },
        error: function (err) {
            swal({

                text: err.statusText,
                icon: "warning",
                dangerMode: true
            })
        }
    })
}

function fillModalFields(data) {
    $('#name').val(data.name);
    $('#person').val(data.person);
    var from = (data.due_date).split("-");

    let temp = from[2] + "-" + from[1] + "-" + from[0];
    $('#due-date').val(temp);
    $('#description').val(data.description);

    if (data.status)
        $('#status').prop('checked', true);
}

$(function () {

    $("#due-date").datepicker({dateFormat: 'dd-mm-yy'});

    refreshTasks();

    $(document).on('click', '.task-edit', function () {
        id = $(this).attr('id');
        editMode = true;
        addEditTask(id, editMode);
    });

    $(document).on('click', '.task-add', function () {
        addEditTask(null, false)
    });

    $(document).on('click', '.task-delete', function () {
        deleteTask($(this).attr('id'));
    });

    $('#submitForm').click(function () {
        $('#add-edit-form').submit();
    });

    //reset the modal when closing it
    $('#add-edit-modal').on('hidden.bs.modal', function () {
        $(this).find("input,textarea,select").val('');
        $('#status').prop('checked', false);
        $('#add-edit-modal-title').html('Add Task');
        $('#submitForm').html('Add');
        $('.set-as-done').css('display', 'none');
        location.reload();
    });
});