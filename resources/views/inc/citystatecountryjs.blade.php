@section('scripts')
 <!-- Script -->
	<script type="text/javascript">
	$(document).ready(function(){

	$("#country_id").on("change", function () {
            var country_id = $(this).val();
			$("#state_id").prop("disabled",true)
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
					$("#state_id").prop("disabled",false)
                }
            });
        });
	});
	</script>        
@endsection