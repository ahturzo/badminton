@extends('layouts.master')

@section('top-css')
  	<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
  	<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
	<section class="content-header">
      	<div class="container-fluid">
        	<div class="row mb-2">
          		<div class="col-sm-6">
            		<h1>Matches</h1>
          		</div>
          		<div class="col-sm-6">
            		<div class="float-right">
            			<a onclick="addTeam()" class="btn btn-xs btn-primary">Add Match</a>
            		</div>
          		</div>
        	</div>

        	<div class="row">
        		<div class="col-12 table-responsive">
          			<table id="example1" class="table dt-responsive table-bordered table-striped" style="width: 100%;">
            			<thead>
		                	<tr>
			                  	<th>#</th>
			                  	<th>Team 1</th>
			                  	<th>Team 1 Score</th>
			                  	<th>Team 2 Score</th>
			                  	<th>Team 2</th>
			                  	<th>Result</th>
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
	<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

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
				        
				        <div class="row">
				        	<div class="col-6">
				        		<div class="form-group">
				                  	<label for="team1">Team 1</label>
				                  	<div class="select2-purple">
				                    	<select id="team1" name="team_1_id" class="select2" multiple="multiple" data-placeholder="Team 1" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
				                    		<option value=""></option>
				                    	</select>
				                  	</div>
				                </div>
				        	</div>

				        	<div class="col-6">
				        		<div class="form-group">
				                  	<label for="team1_point">Team 1 Point</label>
				                  	<input type="number" id="team1_point" name="team_1_point" class="form-control" min="0" max="15" required>
				                </div>
				        	</div>
				        </div>

		                <div class="row">
				        	<div class="col-6">
				        		<div class="form-group">
				                  	<label for="team2">Team 2</label>
				                  	<div class="select2-purple">
				                    	<select id="team2" name="team_2_id" class="select2" multiple="multiple" data-placeholder="Team 2" data-dropdown-css-class="select2-purple" style="width: 100%;" required>
				                    		<option value=""></option>
				                    	</select>
				                  	</div>
				                </div>
				        	</div>

				        	<div class="col-6">
				        		<div class="form-group">
				                  	<label for="team2_point">Team 2 Point</label>
				                  	<input type="number" id="team2_point" name="team_2_point" class="form-control" min="0" max="15" required>
				                </div>
				        	</div>
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
	<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

	<script>
		$('.select2').select2({
	        maximumSelectionLength: 1
	    });
	    var table1 = $("#example1").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('all.match') }}",
            columns: [
              	{data:'id', name:'id'},
              	{data:'team_1', name:'team_1'},
              	{data:'team_1_point', name:'team_1_point'},
              	{data:'team_2_point', name:'team_2_point'},
              	{data:'team_2', name:'team_2'},
              	{data:'result', name:'result'},
              	{data:'action', name:'action', orderable: false, searchable:false}
            ]
        });

        function addTeam()
        {
        	save_method = "add";
        	$('input[name=_method]').val('POST');
			$('#createModal form')[0].reset();
			$("#team1").val('').select2();
			$("#team2").val('').select2();
			$.ajax({
	            url: "{{ route('get.teams') }}",
	            type: "GET",
	            dataType: "JSON",
	            success: function(data) 
	            {
	                $('#team1').empty();
	                $('#team1').append('<option value=""></option>');
	                $.each(data, function (index1, item1)
            		{
            			$('#team1').append('<option value="' +item1.id+ '" data-tokens="' +item1.team_name+ '">'+item1.team_name+'</option>');
            		});

            		$('#team2').empty();
	                $('#team2').append('<option value=""></option>');
	                $.each(data, function (index2, item2)
            		{
            			$('#team2').append('<option value="' +item2.id+ '" data-tokens="' +item2.team_name+ '">'+item2.team_name+'</option>');
            		});
	            },
	            error : function() {
	                alert("Data Not Found");
	            }
	        });
        	$('#createModal').modal('show');
        	$('#submitButton').text('Add');
        	$('.modal-title').text('Create New Team');
        }

        $(function()
        {
	        $('#createModal form').on('submit', function (e) {
	            if (!e.isDefaultPrevented()){
	                if (save_method == 'add')
	                {
	                    url = "{{ url('match') }}";
	                    $.ajax({
	                        url : url,
	                        type : "POST",
	                        data: new FormData($("#createModal form")[0]),
	                        contentType: false,
	                        processData: false,
	                        success : function(data) 
	                        {
	                        	if(data == "same_team")
	                        	{
	                        		$('#createModal').modal('hide');
	                        		swal.fire({
		                                type: 'error',
		                                title: 'Oops...',
		                                text: "Team1 and Team2 cannot be same",
		                            });
	                        	}
	                        	else if(data == "same_point")
	                        	{
	                        		$('#createModal').modal('hide');
	                        		swal.fire({
		                                type: 'error',
		                                title: 'Oops...',
		                                text: "Team1 and Team2 point cannot be same",
		                            });
	                        	}
	                        	else if(data == "invalid_score")
	                        	{
	                        		$('#createModal').modal('hide');
	                        		swal.fire({
		                                type: 'error',
		                                title: 'Oops...',
		                                text: "Invalid Score",
		                            });
	                        	}
	                        	else if(data == "match_done")
	                        	{
	                        		$('#createModal').modal('hide');
	                        		swal.fire({
		                                type: 'error',
		                                title: 'Oops...',
		                                text: "This 2 teams already played a match.",
		                            });
	                        	}
	                        	else
	                        	{
	                        		table1.ajax.reload();
		                            $('#createModal').modal('hide');
		                            swal.fire({
		                              type: "success",
		                              title: "Done!",
		                              text: "Match Added",
		                            });
	                        	}
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
	            text: "Want to delete this team??",
	            showCancelButton: true,
	            confirmButtonColor: '#3085d6',
	            cancelButtonColor: '#d33',
	            confirmButtonText: 'Yes, delete it!'
          })
          .then((willDelete) => {
            if (willDelete.value) {
              $.ajax({
                  	url : "{{ url('team') }}" + '/' + id,
                  	type : "POST",
                  	data : {'_method' : 'DELETE', '_token' : csrf_token},
                  	success : function(data) 
                  	{
                      if(data == "exist")
                  		{
                  			swal.fire({
	                        	type: "warning",
	                        	title: "Can not Delete Team.",
	                        	text: "This team already played matches.",
	                      	});
                  		}
                  		else
                  		{
                  			table1.ajax.reload();
	                      	swal.fire({
	                        	type: "success",
	                        	title: "Done!",
	                        	text: "Team Deleted.",
	                      	});
                  		}
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
                    text: "Team Not Deleted!",
              });
            }
          });
        }
	</script>
@endsection