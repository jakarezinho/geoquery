jQuery(document).ready(function($) {
$('#commentform').validate({
 
rules: {
  author: {
    required: false,
    minlength: 2
  },
 
  email: {
    required: false,
    email: true
  },
 
  comment: {
    required: true,
    //minlength: 20
  }
},
 
messages: {
  author: "Please enter in your name.",
  email: "Please enter a valid email address.",
  comment: "Deve dizer alguma coisa..."
},
 
errorElement: "div",
errorPlacement: function(error, element) {
  element.before(error);
}
 
});

});