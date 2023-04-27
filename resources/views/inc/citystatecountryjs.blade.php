
 <!-- Script -->
	<script type="text/javascript">
	$(document).ready(function(){

	$("#country_id").on("change", function () {
            var country_id = $(this).val();
			$("#state_id").prop("disabled",true);
			$("#city_id").prop("disabled",true);
            $.ajax({
                type: "POST",
                url: '{{ route("state.list") }}',
                data: {'country_id': country_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#state_id').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
					$("#state_id").prop("disabled",false);
					$('#city_id').html('<option value="">--select--</option>');
					$("#city_id").prop("disabled",false);
                }
            });
        });
		
		$("#state_id").on("change", function () {
            var state_id = $(this).val();
			$("#city_id").prop("disabled",true)
            $.ajax({
                type: "POST",
                url: '{{ route("city.list") }}',
                data: {'state_id': state_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#city_id').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#city_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
					$("#city_id").prop("disabled",false)
                }
            });
        });
	});
	</script>    

<script type="text/javascript">
    function randomPassword(length) {
        var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
        var pass = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pass += chars.charAt(i);
        }
       // myform.row_password.value = pass;
        $('#password').val(pass);
    }
	
	$(document).ready(function(){
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
  
    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
  });
   });    

   
  </script> 
