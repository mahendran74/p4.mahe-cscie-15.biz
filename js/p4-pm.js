// New Project
$('#addNewProject').on('click', function(e) {
  e.preventDefault();
  $('#alertNewProject').hide();
  $('#newProjectWindow').modal('show');
});


$('.left-button').tooltip({
  'placement' : 'bottom'
});
$('.right-button').tooltip({
  'placement' : 'bottom'
});
$('#status').simplecolorpicker({
  picker : true,
  theme : 'glyphicons'
});

// Edit Project
$('.edit-project-details').on(
    'click',
    function(e) {
      e.preventDefault();
      var project_id = $(this).attr('id');

      $.ajax({
        type : 'post',
        url : '/pm/get_project/' + project_id,
        success : function(data) {
          var project = jQuery.parseJSON(data);
          $('#editProjectWindow #project_id').val(project.project_id);
          $('#editProjectWindow #project_name').val(project.project_name);
          $('#editProjectWindow #project_desc').val(project.project_desc);
          $('#editProjectWindow #start_date').val(
              changeDateFormat(project.start_date));
          $('#editProjectWindow #end_date').val(
              changeDateFormat(project.end_date));
          $('#editProjectWindow #actual_start_date').text(
              changeDateFormat(project.actual_start_date));
          $('#editProjectWindow #actual_end_date').text(
              changeDateFormat(project.actual_end_date));
          if (project.status == "red") {
            $('#editProjectWindow #status').simplecolorpicker('selectColor',
                '#dc2127');
          } else if (project.status == "yellow") {
            $('#editProjectWindow #status').simplecolorpicker('selectColor',
                '#ffb878');
          } else {
            $('#editProjectWindow #status').simplecolorpicker('selectColor',
                '#7bd148');
          }
          $('#alertEditProject').hide();
          $('#editProjectWindow').modal('show');
        }
      });
    });
$('#editProjectWindow #start_date').datepicker();
$('#editProjectWindow #end_date').datepicker();
$('#start_date').datepicker();
$('#end_date').datepicker();

var nowTemp = new Date();
function changeDateFormat(date_string) {
  var dateVar = new Date(date_string);
  var dayVar = dateVar.getDate();
  var monthVar = dateVar.getMonth();
  monthVar++;
  var yearVar = dateVar.getFullYear();
  return (monthVar + "/" + dayVar + "/" + yearVar);
}
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(),
    nowTemp.getDate(), 0, 0, 0, 0);

var startDate = $('#start_date').datepicker({
  onRender : function(date) {
    return date.valueOf() < now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() > endDate.date.valueOf()) {
    var newDate = new Date(ev.date);
    newDate.setDate(newDate.getDate() + 1);
    endDate.setValue(newDate);
  }
  startDate.hide();
  $('#end_date')[0].focus();
}).data('datepicker');

var endDate = $('#end_date').datepicker({
  onRender : function(date) {
    return date.valueOf() <= startDate.date.valueOf() ? 'disabled' : '';
  }
}).on(
    'changeDate',
    function(ev) {
      if (ev.date.valueOf() < startDate.date.valueOf()) {
        $('#alertNewProject').show().find('strong').text(
            'The end date can not be less then the start date');
        $('#end_date')[0].focus();
        $('#alertNewProject').delay(2000).fadeOut("slow");
      } else {
        $('#alertNewProject').hide();
        vEndDate = new Date(ev.date);
        endDate.hide();
      }
    }).data('datepicker');

$('#signUpWindow').on('hidden', function() {
  $(this).data('modal', null);
});

$("#email").change(function() {
  $("#message").html("checking...");
  var email = $("#email").val();

  $.ajax({
    type : "post",
    url : "/users/check_email/" + email,
    success : function(data) {
      // alert(data);
      if (data == 1) {
        $("#message").html("Email available");
      } else {
        $("#message").html("Email already taken");
        $("#email").focus();
      }
    }
  });

});
// New project submit
$("#newProjectForm").validate(
    {
      showErrors : function(errorMap, errorList) {

        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function(index, element) {
          var $element = $(element);
          $element.data("title", "").removeClass("has-error")
              .tooltip("destroy");
        });

        // Create new tooltips for invalid elements
        $.each(errorList, function(index, error) {
          var $element = $(error.element);
          $element.tooltip("destroy").data("title", error.message).addClass(
              "has-error").tooltip({
            'placement' : 'bottom'
          });
        });
      },

      submitHandler : function(form) {
        form.submit();
        return false;
      }
    });

// Edit project submit
$("#editProjectForm").validate(
    {
      showErrors : function(errorMap, errorList) {

        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function(index, element) {
          var $element = $(element);
          $element.data("title", "").removeClass("has-error")
              .tooltip("destroy");
        });

        // Create new tooltips for invalid elements
        $.each(errorList, function(index, error) {
          var $element = $(error.element);
          $element.tooltip("destroy").data("title", error.message).addClass(
              "has-error").tooltip({
            'placement' : 'bottom'
          });
        });
      },

      submitHandler : function(form) {
        form.submit();
        return false;
      }
    });