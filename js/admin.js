// change the type of teacher
changeTeacherType = (id, e) => {


    $.ajax({
        url: 'changeTeacherType.php',
        type: 'POST',
        data: {
            id: id,
            type: e.value
        },
        dataType: 'json', // Ensures the response is parsed as JSON
        success: function (res) {

            // Check if the response is a JavaScript object
            //console.log(res);
            if (res.center == 0) res.center = '';

            // Assuming the 10th child element is the one you want to update
            e.parentNode.parentNode.childNodes[21].innerHTML = res.center;
        },
        error: function (xhr, status, error) {
            console.error('Error:', status, error);
        }
    });
}


// cecking the phone no is already exist or not
$(document).ready(function () {
    $('#phone').on('input', function () {
        var phone = $(this).val();
        if (phone.length === 10) { // Assuming phone number length is 10
            $.ajax({
                type: 'POST',
                url: 'check_phone.php',
                data: { phone: phone },
                dataType: 'json',
                success: function (response) {
                    if (response.exists) {
                        $('#phone-error').text('Phone number already exists.');
                        $('button[type="submit"]').attr('disabled', 'disabled');
                    } else {
                        $('#phone-error').text('');
                        $('button[type="submit"]').removeAttr('disabled');
                    }
                }
            });
        } else {
            $('#phone-error').text('');
            $('button[type="submit"]').removeAttr('disabled');
        }
    });
});