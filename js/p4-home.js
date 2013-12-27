// Sign Up click
$('#signUp').on('click', function(e) {
  e.preventDefault();
  $('#alertSignUp').hide();
  $('#signUpWindow').modal('show');
});

//About click
$('#about').on('click', function(e) {
  e.preventDefault();
  $('#aboutWindow').modal('show');
});

jQuery.validator.addMethod("notUsed", 
    function(value, element, params) {
   var response;
   $.ajax({
     type : "post",
     url : "/users/check_email/" + value,
     async: false,
     success : function(data) {
       response = data;
     }
   });
   if (response == "Email is available")
     return true;
   else
     return false;
 },'Email already used. Please provide another email.');

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
//Password reset
$("#passwordResetForm").validate(
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
