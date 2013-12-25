var $rows = $('#userList tbody tr');
$('#search').keyup(function() {
  var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

  $rows.show().filter(function() {
    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
    return !~text.indexOf(val);
  }).hide();
});
$('.left-button').tooltip({
  'placement' : 'left'
});
$('.right-button').tooltip({
  'placement' : 'right'
});
$('.admin-icon').tooltip({
  'placement' : 'top'
});
$('.pm-icon').tooltip({
  'placement' : 'top'
});
$('.tm-icon').tooltip({
  'placement' : 'top'
});

$(function() {
  $('#addNewUser').on('click', function(e) {
    e.preventDefault();
    $('#alertAddNewUser').hide();
    $('#addNewUserWindow').modal('show');
  });
});

// Deactivate user
$('.deactivate-user').on(
    'click',
    function(e) {
      e.preventDefault();
      var user_id = $(this).attr('id');
      bootbox.confirm("Are you sure you want to deactivate this user ?",
          function(result) {
            if (result) {
              $.ajax({
                type : 'post',
                url : '/users/deactivate/' + user_id,
                success : function(data) {
                  console.log(data);
                  bootbox.alert(data, function(result) {
                    window.location = "/admin/home";
                  });
                }
              });
            }
          });
    });

// Activate user
$('.activate-user').on('click', function(e) {
  e.preventDefault();
  var user_id = $(this).attr('id');
  bootbox.confirm("Are you sure you to activate this user ?", function(result) {
    if (result) {
      $.ajax({
        type : 'post',
        url : '/users/activate/' + user_id,
        success : function(data) {
          console.log(data);
          bootbox.alert(data, function(result) {
            window.location = "/admin/home";
          });
        }
      });
    }
  });
});

// Reset password
$('.reset-password').on(
    'click',
    function(e) {
      e.preventDefault();
      var user_id = $(this).attr('id').substring(1);
      bootbox.confirm("Are you sure you want to reset the password ?",
          function(result) {
            if (result) {
              $.ajax({
                type : 'post',
                url : '/users/set_temp_token/' + user_id,
                success : function(data) {
                  console.log(data);
                  bootbox.alert(data, function(result) {
                    window.location = "/admin/home";
                  });
                }
              });
            }
          });
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
        $("saveButton").disabled = false;
      } else {
        $("#message").html("Email already taken");
        $("#email").focus();
        $("saveButton").disabled = true;
      }
    }
  });
});

// New user submit
$("#addNewUserForm").validate(
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
        var formData = $(form).serialize();
        $.ajax({
          type : 'post',
          url : '/users/p_adduser',
          data : formData,
          success : function(data) {
            console.log(data);
            bootbox.alert(data, function(result) {
              window.location = "/admin/home";
            });
          }
        });
        return false;
      }
    });