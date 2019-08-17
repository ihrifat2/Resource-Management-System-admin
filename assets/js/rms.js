function deletestudent(sId) {
    jQuery.ajax({
        url: "deletestudent.php",
        data:'sId='+sId,
        type: "POST",
        success:function(data){
            if (data == 1) {
                swal("Success", "Student has been Blocked.", "success");
            } else {
                swal("Error!", "Student has been Unblocked.", "error");
            }
        },
        error:function (){}
    });
}
function deletefaculty(fId) {
    jQuery.ajax({
        url: "deletefaculty.php",
        data:'fId='+fId,
        type: "POST",
        success:function(data){
            if (data == 1) {
                swal("Success", "Faculty has been Blocked.", "success");
            } else {
                swal("Error!", "Faculty has been Unblocked.", "error");
            }
        },
        error:function (){}
    });
}