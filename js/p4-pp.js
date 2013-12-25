function changeDateFormat(date_string) {
  var dateVar = new Date(date_string);
  var dayVar = dateVar.getDate();
  var monthVar = dateVar.getMonth();
  monthVar++;
  var yearVar = dateVar.getFullYear();
  return (monthVar + "/" + dayVar + "/" + yearVar);
}

/**
 * Process the Edit task button click
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
      $('#addNewTaskWindow #task_end_date').val(
          changeDateFormat(task.end_date));
      if (task.status == "red") {
        $('#addNewTaskWindow #task_status').simplecolorpicker('selectColor', '#dc2127');
      } else if (task.status == "yellow") {
        $('#addNewTaskWindow #task_status').simplecolorpicker('selectColor', '#ffb878');
      } else {
        $('#addNewTaskWindow #task_status').simplecolorpicker('selectColor', '#7bd148');
      }
      $('#addNewTaskWindow #task_color').simplecolorpicker('selectColor', task.color);
      $('#addNewTaskWindow #task_per_complete').slider('setValue', task.per_complete);
      $('#addNewTaskWindow #task_assigned_to_id').select2('val', task.assigned_to_id);
      $('#addNewTaskWindow #task_depends_on').select2('val', task.depends_on);
      $('#addNewTaskWindow #task_groups_group_id').select2('val', task.groups_group_id);
      $('#alertAddNewTask').hide();
      $('#addTaskAction').hide();
      $('#editTaskAction').show();
      $('#addNewTaskModalLabel').text("Edit Task");
      $('#addNewTaskWindow').modal('show');
    }
  });
}
/**
 * Process the Edit group button click
 * @param vTaskID
 */
function editGroupItem(vTaskID) {
  var tempTaskItem = JSGantt.LookUpTask(vGanttChart, vTaskID);
  if (tempTaskItem) {
    $('#alertGroup').hide();
    $('#groupName').val(tempTaskItem.getName);
    $('#groupResource').val(tempTaskItem.getResource);
    $('#groupParent').val(tempTaskItem.getParent);
    $('#groupOpenClose').val(tempTaskItem.getOpen);
    $('#groupID').val(tempTaskItem.getID);
    $('#addGroupAction').hide();
    $('#editGroupAction').show();
    $('#groupModalLabel').text("Edit Group");
    $('#newGroupWindow').modal('show');
  }
}
/**
 * Process the Edit milestone button click
 * @param vTaskID
 */
function editMilestone(vTaskID) {
  var tempTaskItem = JSGantt.LookUpTask(vGanttChart, vTaskID);
  $('#alertMilestone').hide();
  $('#milestoneName').val(tempTaskItem.getName);
  $('#milestoneDate').val(
      (tempTaskItem.getStart().getMonth() + 1) + '/'
          + tempTaskItem.getStart().getDate() + '/'
          + tempTaskItem.getStart().getFullYear());
  $('#milestoneResource').val(tempTaskItem.getResource);
  $('#milestoneParent').val(tempTaskItem.getParent);
  $('#msID').val(tempTaskItem.getID);
  $('#addMsAction').hide();
  $('#editMsAction').show();
  $('#milestoneModalLabel').text("Edit Milestone");
  $('#newMilestoneWindow').modal('show');
}



$('#addNewUser').on('click', function(e) {
  e.preventDefault();
  $('#alertAddNewUser').hide();
  $('#addNewUserWindow').modal('show');
});

$('#addNewTask').on('click', function(e) {
  e.preventDefault();
  $('#alertAddNewTask').hide();
  $('#addTaskAction').show();
  $('#editTaskAction').hide();
  $('#addNewTaskWindow').modal('show');
});

$('#addNewGroup').on('click', function(e) {
  e.preventDefault();
  $('#alertAddNewGroup').hide();
  $('#addNewGroupWindow').modal('show');
});

$('#addNewMilestone').on('click', function(e) {
  e.preventDefault();
  $('#alertAddNewMilestone').hide();
  $('#addNewMilestoneWindow').modal('show');
});

function format(item) {
  return item.text;
};

// Sliders
$('#task_per_complete').slider({
  formater : function(value) {
    return 'Percentage complete : ' + value + ' %';
  }
});
$('#milestone_per_complete').slider({
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
$('#group_start_date').datepicker();
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

//New user submit
$("#addNewUserForm").validate(
    {
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
              window.location = "/pm/project_details/"+project_id;
            });
          }
        });
        return false;
      }
    });