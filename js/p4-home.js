// Sign Up click
$('#signUp').on('click', function(e) {
  e.preventDefault();
  $('#alertSignUp').hide();
  $('#signUpWindow').modal('show');
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

// Log In submit
$("#loginForm").validate(
    {
      showErrors : function(errorMap, errorList) {
        $.each(this.validElements(), function(index, element) {
          var $element = $(element);
          $element.data("title", "").removeClass("has-error")
              .tooltip("destroy");
        });
        $.each(errorList, function(index, error) {
          var $element = $(error.element);
          $element.addClass("has-error");
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
// Sign Up submit
$("#signUpForm").validate(
    {
      showErrors : function(errorMap, errorList) {
        $.each(this.validElements(), function(index, element) {
          var $element = $(element);
          $element.data("title", "").removeClass("has-error")
              .tooltip("destroy");
        });
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

