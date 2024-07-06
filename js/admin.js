// change the type of teacher
changeTeacherType = (id, e) => {
    $.ajax({
        url: 'changeTeacherType.php',
        type: 'POST',
        data: {
            id: id,
            type: e.value
        },
        success: function (res) {
            console.log(res);
        }
    })
}