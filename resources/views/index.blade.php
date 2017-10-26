<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<button type="button" class="btn btn-primary" ng-click="create()"><i class="fa fa-plus" aria-hidden="true"></i></button>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><a href="">ID</a></th>
						<th><a href="">NAME</a></th>
						<th><a href="">ADDRESS</a></th>
						<th><a href="">AGE</a></th>
						<th><a href="">PHOTO</a></th>
						<th><a href="">ACTION</a></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>
							<button type="button" class="btn btn-warning" ng-click="update(member.id)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
							<button type="button" class="btn btn-danger" ng-click="delete(member.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="modal fade" id="modal-create">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Modal title</h4>
					</div>
					<div class="modal-body">
						<form name="frmcreatemember" action="{{ route('member.store') }}" method="post"  class="form-horizontal" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label for="">NAME</label>
								<input type="text" class="form-control" id="name" placeholder="Input field" name="name" >

							</div>

							<div class="form-group">
								<label for="">ADDRESS</label>
								<input type="text" class="form-control" id="address" placeholder="Input field" name="address">
							</div>

							<div class="form-group">
								<label for="">AGE</label>
								<input type="text" class="form-control" id="age" placeholder="Input field" name="age"  >

							</div>

							
							<div class="form-group">
                                <label for="psw"> PHOTO </label>
                                <div class="col-md-12">
                                <div class="row heightImage">
                                    <div class="col-sm-6">
                                       <input type="file" name="photo">        
                                    </div>
                            </div>
							
						</form>
					</div>
					<div class="modal-footer">
						@if ($errors->any())
						    <div class="alert alert-danger">
						        <ul>
						            @foreach ($errors->all() as $error)
						                <li>{{ $error }}</li>
						            @endforeach
						        </ul>
						    </div>
						@endif
						<button type="submit" class="btn btn-primary" id="btn-save">SAVE</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$('.btn-primary').click(function() {

			$('#modal-create').modal('show');
		});
	</script>
	<script src="{{asset('app/app.js')}}"></script>
	<script src="{{asset('app/controller/member.js')}}"></script>
	<script src="{{ asset('app/lib/ng-file-upload-all.min.js') }}"></script>
	<script src="{{ asset('app/lib/ng-file-upload-shim.min.js') }}"></script>
	<script src="{{ asset('app/lib/ng-file-upload.min.js') }}"></script>
</body>
</html>