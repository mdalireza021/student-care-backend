// $.fn.selectpicker.Constructor.BootstrapVersion = '4';

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#first_name, #last_name").on("input", function (e) {
        const firstName = $("#first_name").val();
        const lastName = $("#last_name").val();
        let loginid = firstName+lastName;
        loginid = loginid.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '_').toLowerCase();

        $("#login_id").val(loginid);
    });

    $(".edit-selectpicker").selectpicker({
        style: "select-picker"
    });

    $(".selectpicker").selectpicker('val', '', {
        style: "select-picker"
    });

    /*$('.selectpicker').on('change', function() {
        $(this).selectpicker('refresh');
    });

    $('.edit-selectpicker').on('change', function() {
        $(this).selectpicker('refresh');
    });

    $('.selectpicker').change();*/

    $('.datetime-picker').datetimepicker({
        format: "dd M yyyy HH:ii:s P",
        autoclose: true,
        todayHighlight: true,
        todayBtn: true
    });


    $('.date-picker').datetimepicker({
        format: "dd M yyyy",
        autoclose: true,
        todayHighlight: true,
        todayBtn: true,
        minView:'month'
    });

    $("form#class-attendance button#get-students").on("click", function (e) {
        e.preventDefault();

        const classId = $("#student_class_id").val();
        const attendanceDate = $("#attendance_date").val();

        if (classId && attendanceDate) {
            $.ajax({
                url: rootPath + "/get-student-attendance",
                type: "POST",
                data: {class_id: classId, attendance_date: attendanceDate},
                beforeSend: function() {
                    //
                },
                success: function (response) {
                    if (response.status) {
                        $("#check-box-container").empty();
                        $.each(response.students, function (i,student) {
                            let attendanceType;
                            let checked = "";

                            if (student.attendances.length > 0) {
                                attendanceType = student.attendances[0]["attendance_type"];
                                checked = attendanceType == 1 ? "checked" : "";
                            }

                            $("#check-box-container").append(`<div class="form-check">
                                <input class="form-check-input" type="checkbox" name="students[]" ${checked} id="student_${student.id}" value="${student.id}">
                                <label class="form-check-label" for="student_${student.id}">
                                    ${student.fullname} (Roll: ${student.roll_number})
                                </label>
                                </div>`);
                        });

                        $("#check-box-wrapper").removeClass("d-none");
                    }
                },
                complete: function () {
                    //
                }
            });
        }
    });

    $('#data-table').DataTable();

    $("#download-storage-file").on("click", function (e) {
        let button = $(this);
        let fileurl = button.data('fileurl');

        $.ajax({
            url: rootPath + "/get-storage-file",
            type: 'POST',
            data: {fileurl: fileurl},
            beforeSend: function(){
                // let loadingHtml = '<div class="lds-ring"><div></div><div></div><div></div><div></div></div>';
                // modal.find(".modal-body").append(loadingHtml);
            },
            success: function(response){
                modal.find(".modal-body").empty();
                // var url = 'https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/examples/learning/helloworld.pdf';
                // PDFObject.embed(url, "body");
            }
        });
    });
});
