$(".pwstrength").pwstrength();
$(document).ready(()=> {
        var ciso = "";
        var siso = "";
        $('#country-dd').on('change', function () {
          ciso = this.value;
          $("#state-dd").html('');
          $.ajax({
            url: "/api/get-states",
            type: "POST",
            data: {
              ciso: ciso,
              _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (result) {
              $('#state-dd').html('<option value="">Select State</option>');
              $.each(result, function (key, value) {
                $('#state-dd').append('<option value="'+ value.iso2 +'">'+ value.name +'</option>');
              });
              $('#city-dd').html('<option value="">Select City</option>');
            }
        });
    });
    $('#state-dd').on('change', function () {
        siso = this.value;
        $("#city-dd").html('');
        $.ajax({
            url: "/api/get-cities",
            type: "POST",
            data: {
            ciso: ciso,
            siso: siso,
            _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (response) {
            $('#city-dd').html('<option value="">Select City</option>');
            $.each(response, function (key, value) {
                $("#city-dd").append('<option value="' + value.iso2 + '">' + value.name + '</option>');
            });
            }
        });
    });    
});