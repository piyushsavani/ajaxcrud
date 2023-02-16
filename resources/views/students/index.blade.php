@extends('layouts.app')

@section('content')

<!-- addStudentModal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">        
          <h5 class="modal-title" id="exampleModalLabel">Add Student Details</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <ul class="err_values"></ul>
          <form action="" method="POST">

            <div class="form-group">
                <lable>Name</lable>
                <input type="text" name="name" class="name form-control">
            </div>
            <div class="form-group">
                <lable>Email</lable>
                <input type="text" name="email" class="email form-control">
            </div>
            <div class="form-group">
                <lable>Phone</lable>
                <input type="text" name="phone" class="phone form-control">
            </div>
            <div class="form-group">
                <lable>Coures</lable>
                <input type="text" name="course" class="course form-control">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="addStudentBtn btn btn-primary"> Save </button>
        </div>
    </form>

      </div>
    </div>
  </div>
  <!-- End- addStudentModal -->

  <!-- deleteStudentModal -->
  <div class="modal fade" id="deleteStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="stud_id_delete">
        <h5>Are you sure ? want to delete data ?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="delete_btn btn btn-danger"> Yes. Delete </button>
      </div>
    </div>
  </div>
</div>
  <!-- End- deleteStudentModal -->

  <!-- editStudentModal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">        
          <h5 class="modal-title" id="exampleModalLabel">Edit Student Details</h5>
          
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <ul class="err_values"></ul>

            <input type="hidden" id="stud_id_edit">
            <div class="form-group">
                <lable>Name</lable>
                <input type="text" name="name" class="edit_name form-control">
            </div>
            <div class="form-group">
                <lable>Email</lable>
                <input type="text" name="email" class="edit_email form-control">
            </div>
            <div class="form-group">
                <lable>Phone</lable>
                <input type="text" name="phone" class="edit_phone form-control">
            </div>
            <div class="form-group">
                <lable>Coures</lable>
                <input type="text" name="course" class="edit_course form-control">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="update_btn btn btn-primary"> Update </button>
        </div>

      </div>
    </div>
  </div>
  <!-- End- editStudentModal -->


<div class="container">
    <div class="col-md-12">
        <div class="card">
        <div class="success_message"></div>
            <div class="card-header">
                <h4> Student Data
                    <button type="button" data-toggle="modal" data-target="#addStudentModal" class="btn btn-primary btn-sm float-end">Add Student</button>
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone </th>
                            <th> Course </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>                                               
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        fetchStudent();

        function fetchStudent(){

            $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
            });

         $.ajax({
            type: "GET",
            url: "/fetch-students",
            dataType : "json",
            success: function (response) {

                if(response.status == 200){
                    $('tbody').html("");
                    $.each(response.students, function(key, value){  
                        $('tbody').append('<tr>\
                            <td> ' + value.name + ' </td>\
                            <td> ' + value.email + ' </td>\
                            <td> ' + value.phone + ' </td>\
                            <td> ' + value.course + ' </td>\
                            <td>\
                        <button type="button" value="' + value.id + '" data-toggle="modal" data-target="#editStudentModal" class="btn edit_student btn-success btn-sm"> Edit </button>\
                        <button type="button" value="' + value.id + '" data-toggle="modal" data-target="#deleteStudentModal" class="delete_student btn btn-danger btn-sm"> Delete </button>\
                            </td>\
                        </tr>');
                    });
                    
                } else {
                    
                }
            }
         });

        }

        $(document).on('click','.edit_student', function (e) {
            e.preventDefault();
            var stud_id = $(this).val();
            $(stud_id_edit).val(stud_id);

            $.ajax({
                type: "GET",
                url: "students/"+stud_id,
                data: "data",
                dataType: "json",
                success: function (response) {
                    if(response.status == 200)
                    {
                        $('.edit_name').val(response.student.name);
                        $('.edit_email').val(response.student.email);
                        $('.edit_phone').val(response.student.phone);
                        $('.edit_course').val(response.student.course);

                    }
                }
            });
        });

        $(document).on('click','.update_btn', function (e) {
            e.preventDefault();
            var stud_id = $(stud_id_edit).val();

            var data = {
                'name' : $('.edit_name').val(),
                'email' : $('.edit_email').val(),
                'phone' : $('.edit_phone').val(),
                'course' : $('.edit_course').val(),
            }

            $.ajax({
                type: "PUT",
                url: "/update-student/"+stud_id,
                data : data,
                dataType : "json",
                success: function (response) {
                    console.log(response);
                    $('.success_message').html("");
                    $('.success_message').addClass('alert alert-success');
                    $('.success_message').text(response.message);
                    $('#editStudentModal').modal('hide');
                    fetchStudent();
                }
            });
        });


        $(document).on('click','.delete_student', function (e) {
            e.preventDefault();
            var stud_id = $(this).val();
            $(stud_id_delete).val(stud_id);
        });

        $(document).on('click','.delete_btn', function (e) {
            e.preventDefault();
            var stud_id = $(stud_id_delete).val();

            $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
            });
            
            $.ajax({
                type: "DELETE",
                url: "/student/"+stud_id,
                success: function (response) {
                    $('.success_message').html("");
                    $('.success_message').addClass('alert alert-success');
                    $('.success_message').text(response.message);
                    $('#deleteStudentModal').modal('hide');
                    fetchStudent();
                }
            });
        });

        $(document).on('click', '.addStudentBtn', function (e) {
            e.preventDefault();            

            var data = {
                'name' : $('.name').val(),
                'email' : $('.email').val(),
                'phone' : $('.phone').val(),
                'course' : $('.course').val(),
            };
        
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
         });

        $.ajax({
            type: "POST",
            url: "/students",
            data: data,
            dataType: "json",
            success: function (response) {
                $('.err_values').html("");
                $('.err_values').addClass('alert alert-danger');
                if(response.status == 404){
                    $.each(response.errors, function(key, value){               
                        $('.err_values').append('<li>' + value + '</li>');
                    });
                    
                } else {
                    $('.success_message').html("");
                    $('.success_message').addClass('alert alert-success');
                    $('.success_message').text(response.message);
                    $('#addStudentModal').modal('hide'); 
                    $('#addStudentModal').find('input').val("");
                    fetchStudent();
                }
            }
        });

        });
    });
</script>

@endsection