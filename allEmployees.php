<?php
include "Employee.php";
if($_GET['delFlag'] == 1){
    $employee_obj->deleteEmp($_GET['empID']);
}
if($_GET['saveFlag'] == 1){
    $employee_obj->updateEmp($_GET['id'], $_GET['newname'], $_GET['newdept'], $_GET['newsalary'], $_GET['newdesignation'], $_GET['newboss'],
    $_GET['newemail'], $_GET['newpasswd'], $_GET['newpf_img']);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Display Employees</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="mystyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>
<!--    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>-->

</head>
<body>
<?php
    if($_GET['modalFlag'] != "1" && $_GET['saveFlag'] != 1){
?>
  <div class="container" style="margin-top: 5%">
     <h1 style="text-align: center">Employees Family</h1>
    <table id="empTable" class="display">
      <thead>
      <tr>
          <td>Employee ID</td>
          <td>Name</td>
          <td>Department</td>
          <td>Designation</td>
          <td>Action</td>
      </tr>
      </thead>
      <tbody>
      <?php
      $employee_obj->showAllEmployees();
      ?>
      </tbody>
      <tfoot>
      <tr>
          <td>Employee ID</td>
          <td>Name</td>
          <td>Department</td>
          <td>Designation</td>
          <td>Action</td>
      </tr>
      </tfoot>
    </table>
      <button class="btn btn-warning" onclick="history.back()">Back to Home</button>

  </div>
<div class="empModal"></div>
<?php } else {
        if (isset($_GET["modalFlag"])) {
            $viewModel = $_GET["modalFlag"];
            if (strlen($viewModel) > 0) {
                $employee_obj->viewEmp($_GET['emp_id']);
            }
        }
    }
?>
</body>

</html>

<script>
    var empTbl;
    $(document).ready(function () {
        if(empTbl == undefined){
            empTbl = $('#empTable').DataTable();
        }

    });
    $('#file').change(function (){
        testImage(this);
    })
    function testImage(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e){
                $('#empProfile').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#empTable').on('click', '.emp_del', function (e) {
        // e.preventDefault();
        var del_confirmation = confirm("Are you sure? Do you really want to delete the Employee?");
        if(del_confirmation){
            var empID = empTbl.cell($(this).parents('tr'),0).data();
            var delFlag = 1;
            empTbl.row($(this).parents('tr')).remove().draw();
            $.ajax({
                url:'allEmployees.php?delFlag='+delFlag+'&empID='+empID,
                method:'get',
                success:function () {
                    delFlag = 0;
                    alert("Employee has been deleted successfully");
                }
            });
        }

    });
    $("#empTable").on('click', '.emp_edit', function (e){
        var empID = empTbl.cell($(this).parents('tr'),0).data();
        var viewModal = "1";
        if(viewModal != ""){
            $.ajax({
                url:"allEmployees.php?modalFlag="+viewModal+"&emp_id="+empID,
                method: "get",
                success: function (data) {
                    $(".empModal").html(data);
                    viewModal = "0";
                }
            });
        }
    });
    function closefunc() {
        document.getElementById("myModal").style.display = "none";
    }
    function saveFunc(){
        var empid = $('.id').text();
        var name = $('.empName').val();
        var department = $('.department').val();
        var salary = $('.salary').val();
        var designation = $('#designation').val();
        var boss = $('#boss').val();
        var email = $('.email').val();
        var passwd = $('.passwd').val();
        var saveFlag = 1;

        try {
            var property = document.getElementById("file").files[0];
            var image_name = property.name;
            var form_data = new FormData();
            form_data.append('pf_pic', property);
            $.ajax({
                url: 'allEmployees.php',
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    //$(".xyz").html(data);
                    // $("#bookCover").attr('src', 'images/'+image_name);
                    if(name != '' && department != '' && salary != 0 && designation != '' && email != "" && passwd != ""){
                        $.ajax({
                            url: "allEmployees.php?saveFlag="+saveFlag+"&id=" + empid + "&newname=" + name + "&newdept=" + department + "&newsalary=" + salary+
                                "&newpf_img="+image_name+"&newdesignation="+designation+"&newboss="+boss+"&newemail="+email+
                                "&newpasswd="+passwd,
                            method: "get",
                            success: function () {
                                // alert(this.url);
                                $('.modal').hide();
                                window.location.reload();
                            }
                        });

                    }
                }
            });

        }catch (e) {
            alert(e + "\nPlease select a file");
        }
    }

    function cancelFunc(){
        $('.modal').hide();
    }




</script>