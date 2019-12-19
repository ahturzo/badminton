@extends('layouts.master')

@section('top-css')
  	<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
@endsection
@section('content')
	<section class="content-header">
      	<div class="container-fluid">
        	<div class="row mb-2">
          		<div class="col-sm-6">
            		<h1>Players</h1>
          		</div>
          		<div class="col-sm-6">
            		<div class="float-right">
            			<a onclick="addPlayer()" class="btn btn-xs btn-primary">Add Player</a>
            		</div>
          		</div>
        	</div>

        	<div class="row">
        		<div class="col-12 table-responsive">
          			<table id="example1" class="table dt-responsive table-bordered table-striped" style="width: 100%;">
            			<thead>
		                	<tr>
			                  	<th>#</th>
			                  	<th>Player Name</th>
			                  	<th>Status</th>
			                  	<th>Action</th>
			                </tr>
            			</thead>
            			<tbody></tbody>
		            </table>
        		</div>
        	</div>
      	</div><!-- /.container-fluid -->
    </section>

    <!-- Modal -->
	<div class="modal fade" id="playerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

	  	<div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
			    <div class="modal-header">
			        <h5 class="modal-title" id="playerTitle"></h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			    </div>
			    <form>
                @csrf {{ method_field('POST') }}
            		<div class="modal-body">
            			<input type="hidden" name="id" id="id">
				        <div class="form-group">
	                        <label for="player" class="text-danger"><b style="color:#00008B;">Player Name</b> *</label>
	                        <input type="text" class="form-control @error('player_name') is-invalid @enderror" id="player" name="player_name" value="{{ old('player_name') }}" autocomplete="off" required>
	                    </div>
				    </div>
				    <div class="modal-footer justify-content-center">
		              	<button class="btn btn-warning" data-dismiss="modal">Close</button>
		              	<button type="submit" id="submitButton" class="btn btn-success"></button>
		            </div>
	            </form>
		    </div>
	  	</div>
	</div>
@endsection

@section('bottom-js')
  	<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
	<script>
	    var table1 = $("#example1").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('all.player') }}",
            columns: [
              	{data:'id', name:'id'},
              	{data:'player_name', name:'player_name'},
              	{data:'status', name:'status'},
              	{data:'action', name:'action', orderable: false, searchable:false}
            ]
        });

        function addPlayer()
        {
        	save_method = "add";
        	$('input[name=_method]').val('POST');
			$('#playerModal form')[0].reset();
        	$('#playerModal').modal('show');
        	$('#submitButton').text('Add');
        	$('.modal-title').text('Create New Player');
        }

        function editData(id) 
        {
	        save_method = 'edit';
	        $('input[name=_method]').val('PATCH');
	        $('#playerModal').modal('show');
	        $('#playerModal form')[0].reset();
	        $('.modal-title').text('Edit Player Name');
	        $('#submitButton').text('Update');

	        $.ajax({
	            url: "{{ url('player') }}" + '/' + id + "/edit",
	            type: "GET",
	            dataType: "JSON",
	            success: function(data) 
	            {
	                $('#id').val(data.id);
	                $('#player').val(data.player_name);
	            },
	            error : function() {
	                alert("Data Not Found");
	            }
	        });
	    }

        $(function()
        {
	        $('#playerModal form').on('submit', function (e) {
	            if (!e.isDefaultPrevented()){
	                if (save_method == 'add')
	                {
	                    url = "{{ url('player') }}";
	                    $.ajax({
	                        url : url,
	                        type : "POST",
	                        data: new FormData($("#playerModal form")[0]),
	                        contentType: false,
	                        processData: false,
	                        success : function(data) 
	                        {
	                        	table1.ajax.reload();
	                            $('#playerModal').modal('hide');
	                            swal.fire({
	                              type: "success",
	                              title: "Done!",
	                              text: "player Added",
	                            });
	                        },
	                        error : function(data){        
	                            swal.fire({
	                                type: 'error',
	                                title: 'Oops...',
	                                text: data.responseJSON.message,
	                            });
	                        }
	                    });
	                    return false;
	                }
	                else{
	                    var id = $('#id').val();
	                    url = "{{ url('player') }}" + '/' + id;
	                    $.ajax({
	                        url : url,
	                        type : "POST",
	                        data: new FormData($("#playerModal form")[0]),
	                        contentType: false,
	                        processData: false,
	                        success : function(data) {
	                            $('#playerModal').modal('hide');
	                            table1.ajax.reload();
	                            swal.fire({
	                              type: "success",
	                              title: "Done!",
	                              text: "Player Name Edited",
	                            });
	                        },
	                        error : function(data){        
	                            swal.fire({
	                                type: 'error',
	                                title: 'Oops...',
	                                text: data.responseJSON.message,
	                            });
	                        }
	                    });
	                    return false;
	                }
	            }
	        });
	    });

        function deleteData(id)
        {
          	var csrf_token = "{{ csrf_token() }}";
	          	swal.fire({
	            type: "warning",
	            title: "Are you sure?",
	            text: "Want to delete this player??",
	            showCancelButton: true,
	            confirmButtonColor: '#3085d6',
	            cancelButtonColor: '#d33',
	            confirmButtonText: 'Yes, delete it!'
          })
          .then((willDelete) => {
            if (willDelete.value) {
              $.ajax({
                  url : "{{ url('player') }}" + '/' + id,
                  type : "POST",
                  data : {'_method' : 'DELETE', '_token' : csrf_token},
                  success : function(data) {
                      table1.ajax.reload();
                      swal.fire({
                        type: "success",
                        title: "Done!",
                        text: "Player Deleted.",
                      });
                  },
                  error : function () {
                      swal.fire({
                          type: "error",
                          title: 'Oops...',
                          text: data.responseJSON.message,
                          timer: '1500'
                      })
                  }
              });
            } else {
              swal.fire({
                    type: "success",
              		  title: "Safe",
                    text: "Player Not Deleted!",
              });
            }
          });
        }
	</script>
@endsection