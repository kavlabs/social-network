 $("#login-button").click(function(event){
		 event.preventDefault();
	 
	 $('form').fadeOut(500);
	 $('.wrapper').addClass('form-success');
});

var btn = document.getElementById('login-button');
btn.addEventListener('click', function() {
  document.location.href = 'index.php';
});

var btn = document.getElementById('signup-button');
btn.addEventListener('click', function() {
  document.location.href = 'signup.php';
});