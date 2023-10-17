function list_div()
{

  $('#list_div').html("");
  var sendInfo={"action":"retrieve","user_rights_edit_1":user_rights_edit_1,"user_rights_delete_1":user_rights_delete_1};
  $.ajax({
    type: "GET",
    url: $("#CUR_ACTION").val(),
    data: sendInfo,
    success: function(data){
      $('#list_div').html(data);
      $(function () {
        $('#tableExport').DataTable({
            "dom": 'lBfrtip',
            "buttons": [
                {
                    extend: 'excel',
                    text: 'Excel',
                    exportOptions: {
                        columns: [0, 1, 2 ]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    //text: '<i class="far fa-file-pdf"></i>',
                    exportOptions: {
                        columns: [0, 1, 2 ]
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: [0, 1, 2 ]
                    }
                }
            ]
        });
    });
    },
    error: function() {
      alert('error handing here');
    }
  });
}
$(function () {
  list_div();
});
function open_model(title,id)
{

  $('#bd-example-modal-lg1 #model_main_content').html("...");
  var sendInfo={};
  if(id==""){sendInfo={"action":"create_form"};}
  else{sendInfo={"action":"update_form","id":id};}
  $.ajax({
    type: "GET",
    url: $("#CUR_ACTION").val(),
    data: sendInfo,
    success: function(data){
      $('#bd-example-modal-lg1').modal('show');
      $('#bd-example-modal-lg1 #myLargeModalLabel').html(title);
      $('#bd-example-modal-lg1 #model_main_content').html(data);
    },
    error: function() {
      alert('error handing here');
    }
  });
}
function insert_update_row(id,designation_name,description)
{
    // alert();

  if(id=="")
  {
    if(designation_name){
    var sendInfo={"action":"insert","designation_name":designation_name,"description":description};
    $.ajax({
      type: "GET",
      url: $("#CUR_ACTION").val(),
      data: sendInfo,
      success: function(data){
        if(data ==''){
        $('#bd-example-modal-lg1').modal('hide');
        swal('Inserted Successfully', {icon: 'success',});
        list_div();
        }else{
          swal('Already Exit', { icon: 'error', });
        }
      },
      error: function() {
        alert('error handing here');
      }
    });
  }else{
    validate_inputs(designation_name);
  }
  }
  else
  {
    if(designation_name){
    var sendInfo={"action":"update","id":id,"designation_name":designation_name,"description":description};
    $.ajax({
      type: "GET",
      url: $("#CUR_ACTION").val(),
      data: sendInfo,
      success: function(data){
        if(data == ''){
        $('#bd-example-modal-lg1').modal('hide');
        swal('Updated Successfully', {icon: 'success',});
        list_div();
        }else{
          swal('Already Exit', { icon: 'error', });
        }
      },
      error: function() {
        alert('error handing here');
      }
    });
  }
  else{
    validate_inputs(designation_name);
  }
  }
}

function validate_inputs(designation_name){
  if (designation_name == '') { $("#designation_name").addClass('is-invalid'); $("#designation_name_validate_div").html("Enter Designation Name"); return false; } else { $("#designation_name").removeClass('is-invalid'); $("#designation_name_validate_div").html(""); }
}

function delete_row(id)
{
  swal({
    title: 'Are you sure?',
    text: 'To delete User Type',
    icon: 'warning',
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {

      var sendInfo={"action":"delete","id":id};
      $.ajax({
        type: "GET",
        url: $("#CUR_ACTION").val(),
        data: sendInfo,
        success: function(data){
          swal('Deleted Successfully', {icon: 'success',});
          list_div();
        },
        error: function() {
          alert('error handing here');
        }
      });
    }
  });
}
