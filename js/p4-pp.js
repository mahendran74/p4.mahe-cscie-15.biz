function changeDateFormat(date_string) {
  var dateVar = new Date(date_string);
  var dayVar = dateVar.getDate();
  var monthVar = dateVar.getMonth();
  monthVar++;
  var yearVar = dateVar.getFullYear();
  return (monthVar + "/" + dayVar + "/" + yearVar);
}

//About click
$('#about').on('click', function(e) {
  e.preventDefault();
  $('#aboutWindow').modal('show');
});

//Contact click
$('#contact').on('click', function(e) {
  e.preventDefault();
  $('#contactWindow').modal('show');
});

/**
 * Process the Edit task button click
 * 
 * @param vTaskID
 */
function editTaskItem(task_id) {
  $.ajax({
    type : 'post',
    url : '/pm/get_task/' + task_id,
    success : function(data) {
      var task = jQuery.parseJSON(data);
      $('#addNewTaskWindow #task_id').val(task.task_id);
      $('#addNewTaskWindow #task_task_desc').val(task.task_desc);
      $('#addNewTaskWindow #task_start_date').val(
          changeDateFormat(task.start_date));
      $('#addNewTaskWindow #task_end_date')
          .val(changeDateFormat(task.end_date));
      if (task.status == "red") {
        $('#addNewTaskWindow #task_status').simplecolorpicker('selectColor',
            '#dc2127');
      } else if (task.status == "yellow") {
        $('#addNewTaskWindow #task_status').simplecolorpicker('selectColor',
            '#ffb878');
      } else {
        $('#addNewTaskWindow #task_status').simplecolorpicker('selectColor',
            '#7bd148');
      }
      $('#addNewTaskWindow #task_color').simplecolorpicker('selectColor',
          task.color);
      $('#addNewTaskWindow #per_complete_slide').slider('setValue',
          task.per_complete);
      $('#addNewTaskWindow #task_per_complete').val(task.per_complete);
      $('#addNewTaskWindow #task_assigned_to_id').select2('val',
          task.assigned_to_id);
      $('#addNewTaskWindow #task_depends_on').select2('val', task.depends_on);
      $('#addNewTaskWindow #task_groups_group_id').select2('val',
          task.groups_group_id);
      $('#alertAddNewTask').hide();
      $('#addTaskAction').hide();
      $('#editTaskAction').show();
      $('#addNewTaskModalLabel').text("Edit Task");
      $('#addNewTaskWindow').modal('show');
    }
  });
}

$("#addNewTaskWindow #per_complete_slide").on('slide', function(slideEvt) {
  $("#task_per_complete").val(slideEvt.value);
});

/**
 * Process the Edit group button click
 * 
 * @param vTaskID
 */
function editGroupItem(group_id) {
  $.ajax({
    type : 'post',
    url : '/pm/get_group/' + group_id,
    success : function(data) {
      var group = jQuery.parseJSON(data);
      $('#addNewGroupWindow #group_id').val(group.group_id);
      $('#addNewGroupWindow #group_group_desc').val(group.group_desc);
      $('#addNewGroupWindow #group_start_date').val(
          changeDateFormat(group.start_date));
      $('#addNewGroupWindow #group_end_date').val(
          changeDateFormat(group.end_date));
      $('#addNewGroupWindow #group_parent_group_id').select2('val',
          group.parent_group_id);
      $('#alertAddNewGroup').hide();
      $('#addGroupAction').hide();
      $('#editGroupAction').show();
      $('#addNewGroupModalLabel').text("Edit Group");
      $('#addNewGroupWindow').modal('show');
    }
  });
}
/**
 * Process the Edit milestone button click
 * 
 * @param vTaskID
 */
function editMilestone(milestone_id) {
  $.ajax({
    type : 'post',
    url : '/pm/get_milestone/' + milestone_id,
    success : function(data) {
      var milestone = jQuery.parseJSON(data);
      $('#addNewMilestoneWindow #milestone_id').val(milestone.milestone_id);
      $('#addNewMilestoneWindow #milestone_milestone_desc').val(
          milestone.milestone_desc);
      $('#addNewMilestoneWindow #milestone_milestone_date').val(
          changeDateFormat(milestone.milestone_date));
      $('#addNewMilestoneWindow #milestone_groups_group_id').select2('val',
          milestone.groups_group_id);
      $('#addNewMilestoneWindow #milestone_assigned_to_id').select2('val',
          milestone.assigned_to_id);
      $('#alertAddNewMilestone').hide();
      $('#addMilestoneAction').hide();
      $('#editMilestoneAction').show();
      $('#addNewGroupModalLabel').text("Edit Milestone");
      $('#addNewMilestoneWindow').modal('show');
    }
  });
}

$('#addNewUser').on('click', function(e) {
  e.preventDefault();
  $('#alertAddNewUser').hide();
  $('#addNewUserWindow').modal('show');
});

$('#addNewTask').on('click', function(e) {
  e.preventDefault();
  $('#addNewTaskWindow #task_id').val('');
  $('#addNewTaskWindow #task_task_desc').val('');
  $('#addNewTaskWindow #task_start_date').val('');
  $('#addNewTaskWindow #task_end_date').val('');
  $('#addNewTaskWindow #task_status').simplecolorpicker('selectColor', '');
  $('#addNewTaskWindow #task_color').simplecolorpicker('selectColor', '');
  $('#addNewTaskWindow #per_complete_slide').slider('setValue', '');
  $('#addNewTaskWindow #task_per_complete').val('');
  $('#addNewTaskWindow #task_assigned_to_id').select2('val', '');
  $('#addNewTaskWindow #task_depends_on').select2('val', '');
  $('#addNewTaskWindow #task_groups_group_id').select2('val', '');
  $('#alertAddNewTask').hide();
  $('#addTaskAction').show();
  $('#editTaskAction').hide();
  $('#addNewTaskModalLabel').text("Add New Task");
  $('#addNewTaskWindow').modal('show');
});

$('#addNewGroup').on('click', function(e) {
  e.preventDefault();
  $('#addNewGroupWindow #group_id').val('');
  $('#addNewGroupWindow #group_group_desc').val('');
  $('#addNewGroupWindow #group_start_date').val('');
  $('#addNewGroupWindow #group_end_date').val('');
  $('#addNewGroupWindow #task_parent_group_id').select2('val', '');
  $('#alertAddNewGroup').hide();
  $('#addGroupAction').show();
  $('#editGroupAction').hide();
  $('#addNewGroupModalLabel').text("Add New Group");
  $('#addNewGroupWindow').modal('show');
});

$('#addNewMilestone').on('click', function(e) {
  e.preventDefault();
  $('#addNewMilestoneWindow #milestone_id').val('');
  $('#addNewMilestoneWindow #milestone_milestone_desc').val('');
  $('#addNewMilestoneWindow #milestone_milestone_date').val('');
  $('#addNewMilestoneWindow #milestone_groups_group_id').select2('val', '');
  $('#addNewMilestoneWindow #milestone_assigned_to_id').select2('val', '');
  $('#alertAddNewMilestone').hide();
  $('#addMilestoneAction').show();
  $('#editMilestoneAction').hide();
  $('#addNewMilestoneModalLabel').text("Add New Milestone");
  $('#alertAddNewMilestone').hide();
  $('#addNewMilestoneWindow').modal('show');
});

function format(item) {
  return item.text;
};

// Sliders
$('#per_complete_slide').slider({
  formater : function(value) {
    return 'Percentage complete : ' + value + ' %';
  }
});
$('#milestone_per_complete_slide').slider({
  formater : function(value) {
    return 'Percentage complete : ' + value + ' %';
  }
});

// Select
$("#task_assigned_to_id").select2({
  data : {
    results : resList
  },
  formatSelection : format,
  formatResult : format
});
$("#task_groups_group_id").select2({
  data : {
    results : groupList
  },
  formatSelection : format,
  formatResult : format
});
$("#task_depends_on").select2({
  data : {
    results : dependList
  },
  formatSelection : format,
  formatResult : format
});
$("#group_parent_group_id").select2({
  data : {
    results : groupList
  },
  formatSelection : format,
  formatResult : format
});
$("#milestone_groups_group_id").select2({
  data : {
    results : groupList
  },
  formatSelection : format,
  formatResult : format
});
$("#milestone_assigned_to_id").select2({
  data : {
    results : resList
  },
  formatSelection : format,
  formatResult : format
});

// Date picker
$('#task_start_date').datepicker();

$('#task_end_date').datepicker();

$('#group_start_date').datepicker({
  autoclose : true
});
$('#group_end_date').datepicker();
$('#milestone_milestone_date').datepicker();

// Color picker
$('#task_status').simplecolorpicker({
  picker : true,
  theme : 'glyphicons'
});
$('#task_color').simplecolorpicker({
  picker : true,
  theme : 'glyphicons'
});

// New user submit
$("#addNewUserForm").validate({
  showErrors : function(errorMap, errorList) {

    // Clean up any tooltips for valid elements
    $.each(this.validElements(), function(index, element) {
      var $element = $(element);
      $element.removeClass("has-error").addClass("has-success");
      $element.data("title", "").tooltip("destroy");
    });

    // Create new tooltips for invalid elements
    $.each(errorList, function(index, error) {
      var $element = $(error.element);
      $element.removeClass("has-success").addClass("has-error");
      $element.tooltip("destroy").data("title", error.message).tooltip({
        'placement' : 'bottom'
      });
    });
  },

  submitHandler : function(form) {
    var formData = $(form).serialize();
    var project_id = $("#project_id").val();
    $.ajax({
      type : 'post',
      url : '/users/p_adduser',
      data : formData,
      success : function(data) {
        console.log(data);
        bootbox.alert(data, function(result) {
          window.location = "/pm/project_details/" + project_id;
        });
      }
    });
    return false;
  }
});

var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(),
    nowTemp.getDate(), 0, 0, 0, 0);

var taskStartDate = $('#task_start_date').datepicker({
  onRender : function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > taskEndDate.date.valueOf()) {
    var newDate = new Date(ev.date);
    newDate.setDate(newDate.getDate() + 1);
    taskEndDate.setValue(newDate);
  }
  taskStartDate.hide();
  $('#task_end_date')[0].focus();
}).data('datepicker');

var taskEndDate = $('#task_end_date').datepicker({
  onRender : function(date) {
    return date.valueOf() <= taskStartDate.date.valueOf() ? 'disabled' : '';
  }
}).on(
    'changeDate',
    function(ev) {
      if (ev.date.valueOf() < taskStartDate.date.valueOf()) {
        $('#alertNewProject').show().find('strong').text(
            'The end date must fall after the start date.');
        $('#end_date')[0].focus();
        $('#alertAddNewTask').delay(2000).fadeOut("slow");
      } else {
        $('#alertAddNewTask').hide();
        vEndDate = new Date(ev.date);
        taskEndDate.hide();
      }
    }).data('datepicker');

jQuery.validator.addMethod("greaterThan", function(value, element, params) {

  if (!/Invalid|NaN/.test(new Date(value))) {
    return new Date(value) > new Date($(params).val());
  }

  return isNaN(value) && isNaN($(params).val())
      || (Number(value) > Number($(params).val()));
}, 'Must be greater than {0}.');

// New task submit
$("#addNewTaskForm").validate({
  showErrors : function(errorMap, errorList) {

    // Clean up any tooltips for valid elements
    $.each(this.validElements(), function(index, element) {
      var $element = $(element);
      $element.removeClass("has-error").addClass("has-success");
      $element.data("title", "").tooltip("destroy");
    });

    // Create new tooltips for invalid elements
    $.each(errorList, function(index, error) {
      var $element = $(error.element);
      $element.removeClass("has-success").addClass("has-error");
      $element.tooltip("destroy").data("title", error.message).tooltip({
        'placement' : 'top'
      });
    });
  },

  submitHandler : function(form) {

    var formData = $(form).serialize();
    var project_id = $('#project_id').val();
    var submit_url = '/pm/p_add_task';
    if ($('#task_id').val() != "") {
      submit_url = '/pm/p_update_task';
    }
    $.ajax({
      type : 'post',
      url : submit_url,
      data : formData,
      success : function(data) {
        console.log(data);
        bootbox.alert(data, function(result) {
          window.location = "/pm/project_details/" + project_id;
        });
      }
    });
    return false;
  }
});

var groupStartDate = $('#group_start_date').datepicker({
  onRender : function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > taskEndDate.date.valueOf()) {
    var newDate = new Date(ev.date);
    newDate.setDate(newDate.getDate() + 1);
    taskEndDate.setValue(newDate);
  }
  groupStartDate.hide();
  $('#group_end_date')[0].focus();
}).data('datepicker');

var groupEndDate = $('#group_end_date').datepicker({
  onRender : function(date) {
    return date.valueOf() <= groupStartDate.date.valueOf() ? 'disabled' : '';
  }
}).on(
    'changeDate',
    function(ev) {
      if (ev.date.valueOf() < groupStartDate.date.valueOf()) {
        $('#alertNewProject').show().find('strong').text(
            'The end date must fall after the start date.');
        $('#end_date')[0].focus();
        $('#alertAddNewTask').delay(2000).fadeOut("slow");
      } else {
        $('#alertAddNewTask').hide();
        vEndDate = new Date(ev.date);
        groupEndDate.hide();
      }
    }).data('datepicker');

// New group submit
$("#addNewGroupForm").validate({
  showErrors : function(errorMap, errorList) {

    // Clean up any tooltips for valid elements
    $.each(this.validElements(), function(index, element) {
      var $element = $(element);
      $element.removeClass("has-error").addClass("has-success");
      $element.data("title", "").tooltip("destroy");
    });

    // Create new tooltips for invalid elements
    $.each(errorList, function(index, error) {
      var $element = $(error.element);
      $element.removeClass("has-success").addClass("has-error");
      $element.tooltip("destroy").data("title", error.message).tooltip({
        'placement' : 'top'
      });
    });
  },

  submitHandler : function(form) {
    var formData = $(form).serialize();
    var project_id = $('#project_id').val();
    var submit_url = '/pm/p_add_group';
    if ($('#group_id').val() != "") {
      submit_url = '/pm/p_update_group';
    }
    $.ajax({
      type : 'post',
      url : submit_url,
      data : formData,
      success : function(data) {
        console.log(data);
        bootbox.alert(data, function(result) {
          window.location = "/pm/project_details/" + project_id;
        });
      }
    });
    return false;
  }
});

// New milestone submit
$("#addNewMilestoneForm").validate({
  showErrors : function(errorMap, errorList) {

    // Clean up any tooltips for valid elements
    $.each(this.validElements(), function(index, element) {
      var $element = $(element);
      $element.removeClass("has-error").addClass("has-success");
      $element.data("title", "").tooltip("destroy");
    });

    // Create new tooltips for invalid elements
    $.each(errorList, function(index, error) {
      var $element = $(error.element);
      $element.removeClass("has-success").addClass("has-error");
      $element.tooltip("destroy").data("title", error.message).tooltip({
        'placement' : 'top'
      });
    });
  },

  submitHandler : function(form) {
    var formData = $(form).serialize();
    var project_id = $('#project_id').val();
    var submit_url = '/pm/p_add_milestone';
    if ($('#milestone_id').val() != "") {
      submit_url = '/pm/p_update_milestone';
    }
    $.ajax({
      type : 'post',
      url : submit_url,
      data : formData,
      success : function(data) {
        console.log(data);
        bootbox.alert(data, function(result) {
          window.location = "/pm/project_details/" + project_id;
        });
      }
    });
    return false;
  }
});

// Delete task
$('#taskDelButton').on(
    'click',
    function(e) {
      e.preventDefault();
      var task_id = $('#task_id').val();
      var project_id = $('#project_id').val();
      bootbox.confirm("Are you sure you want to delete this task ?", function(
          result) {
        if (result) {
          $.ajax({
            type : 'post',
            url : '/pm/delete_task/' + task_id,
            success : function(data) {
              console.log(data);
              bootbox.alert(data, function(result) {
                window.location = "/pm/project_details/" + project_id;
              });
            }
          });
        }
      });
    });

// Delete group
$('#groupDelButton').on(
    'click',
    function(e) {
      e.preventDefault();
      var group_id = $('#group_id').val();
      var project_id = $('#project_id').val();
      bootbox.confirm("Are you sure you want to delete this group ?", function(
          result) {
        if (result) {
          $.ajax({
            type : 'post',
            url : '/pm/delete_group/' + group_id,
            success : function(data) {
              console.log(data);
              bootbox.alert(data, function(result) {
                window.location = "/pm/project_details/" + project_id;
              });
            }
          });
        }
      });
    });

// Delete milestone
$('#milestoneDelButton').on(
    'click',
    function(e) {
      e.preventDefault();
      var milestone_id = $('#milestone_id').val();
      var project_id = $('#project_id').val();
      bootbox.confirm("Are you sure you want to delete this milestone ?",
          function(result) {
            if (result) {
              $.ajax({
                type : 'post',
                url : '/pm/delete_milestone/' + milestone_id,
                success : function(data) {
                  console.log(data);
                  bootbox.alert(data, function(result) {
                    window.location = "/pm/project_details/" + project_id;
                  });
                }
              });
            }
          });
    });