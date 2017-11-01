<!DOCTYPE html>
<html lang="en" ng-app="memberRecords">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<style type="text/css">	
		.modal-title{
			text-align: center;
		}
		.modal-body{
			width: 90%;
			margin: 0 auto;
		}
		.col-sm-6{
			padding: 0;
		}
		img{
			min-width: 150px;
		}
		textarea{
			resize: none;
		}
		
	</style>
</head>
<body>
	<div class="container" ng-controller="MemberController">
		<h2>MEMBER</h2>
		<button type="button" class="btn btn-primary" ng-click="create()"><i class="fa fa-plus" aria-hidden="true"></i></button>
			<div class="" style="margin-top: 1%">
				<table class="table table-hover table-responsive table-bordered">
					<thead>
						<tr>
							<th ng-click="propertyName ='id';sortBy('id')" >ID</th>
							<th ng-click="propertyName ='name';sortBy('name')">NAME</th>
							<th ng-click="propertyName ='address';sortBy('address')">ADDRESS</th>
							<th ng-click="propertyName ='age';sortBy('age')">AGE</th>
							<th>PHOTO</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat=" member in members |orderBy:propertyName:reverse">
							<td>@{{member.id}}</td>
							<td style="width: 10%;">
								<p style="word-wrap: break-word;" class="name">@{{member.name}}</p>					
							</td>
							<td style="width: 40%;" class="address">
								<p style="word-wrap: break-word;" class="address">@{{member.address}}</p>		
							</td>
							<td>@{{member.age}}</td>
							<td style="width: 15%">
								<img style="width: 120px; height: 120px; margin: 0 auto" class="img-responsive"  ng-src="@{{member.photo}}">
							</td>
							<td style="width: 5%;">
								<div style="margin-top: 45%; margin-left: 15%">
									<button type="button" style="margin-bottom: 5%;" class="btn btn-warning" ng-click="update(member.id)"><i class="fa fa-pencil" aria-hidden="true"></i></button>
									<button type="button" class="btn btn-danger" ng-click="delete(member.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
								</div>
								
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<div class="modal fade" id="modal-create">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button"  class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">ADD NEW MEMBER</h4>
					</div>
					<div class="modal-body">
						<form name="frmcreatemember" id="frmcreate" class="form-horizontal" enctype="multipart/form-data">
							
							<div class="form-group">
								<label for="">NAME</label>
								<input type="text" class="form-control" id="name" placeholder="Input name" name="name"  ng-pattern="regex"  ng-maxlength="100" ng-model="member.name"  ng-required="true">
								<div ng-show="frmcreatemember.name.$dirty && frmcreatemember.name.$invalid" >
									<span style="color: red" ng-show="frmcreatemember.name.$error.required">The Name is required and cannot be empty</span>
									<span style="color: red" ng-show="frmcreatemember.name.$error.maxlength">The Name must be less than 100 characters</span><br>
									<span style="color: red" ng-show="frmcreatemember.name.$error.pattern">The name must be alphabetic characters, with no special characters </span>
								</div>
								

							</div>

							<div class="form-group">
								<label for="">ADDRESS</label>
								<textarea type="text" class="form-control" id="address" rows="5" placeholder="Input address" name="address" ng-maxlength="300" ng-model="member.address"  ng-required="true"></textarea>
								<div ng-show="frmcreatemember.address.$dirty && frmcreatemember.address.$invalid" >
									<span style="color: red" ng-show="frmcreatemember.address.$error.required">The address is required and cannot be empty</span>
									<span style="color: red" ng-show="frmcreatemember.address.$error.maxlength">The address must be less than 300 characters</span><br>
								</div>
							</div>

							<div class="form-group">
								<label for="">AGE</label>
								<input type="text" class="form-control" id="age" placeholder="Input age" name="age"  ng-pattern="/^[0-9]*$/" ng-maxlength="2" ng-model="member.age"  ng-required="true">

								<div ng-show="frmcreatemember.age.$dirty && frmcreatemember.age.$invalid" >
									<span style="color: red" ng-show="frmcreatemember.age.$error.required">The age is required and cannot be empty</span>
									<span style="color: red" ng-show="frmcreatemember.age.$error.maxlength">The age must be less than 2 characters</span><br>
									<span style="color: red" ng-show="frmcreatemember.age.$error.pattern">The age must be a number</span>
								</div>
							</div>

							
							<div class="form-group">
                                <label for="psw"> PHOTO </label>
                                <div class="col-md-12">
                                <div class="row heightImage">
                                    <div class="col-sm-6">
                                       <input type="file" ngf-select ng-model="files" name="photo"  ngf-max-size="10MB" ngf-model-invalid="errorFile" ngf-pattern="regexImage" class="form-control upload" file-model="myFile" id="upload">
                                            
                                    </div>
                                    <div class="col-sm-5">
                                       <img ng-show="frmcreatemember.myFile.$valid" ngf-thumbnail="files"
                                          class="img-thumbnail" id="imgThumbnail" width="100em" id="photo">
                                       <button ng-click="picFile = null" ng-show="picFile" class="btn btn-danger btn-sm">
                                           <span style="font-size: 10px">
                                           		<i class="fa fa-close"></i>
                                           </span>
                                       </button>
                                    </div>
                                    
                                </div>
	                            	<span style="color: red" ng-show="frmcreatemember.photo.$error.pattern">Image only support: png; jpg; jpeg; gif.</span>
	                                <span style="color: red"  ng-show="frmcreatemember.photo.$error.maxSize">File too large: max 10MB</span>
                            	</div>
                            </div>
							
						</form>
					</div>
					<div class="modal-footer">
						<div id="error" style="text-align: left; color: red">
							
						</div>
						{{-- @if ($errors->any())
						    <div class="alert alert-danger">

						        <ul>
						            @foreach ($errors->first() as $error)
						                <li>{{ $error }}</li>
						            @endforeach
						        </ul>
						    </div>
						@endif --}}
						<button type="submit" class="btn btn-primary" id="btn-save" ng-click="saveNewMember()" ng-disabled="frmcreatemember.$invalid">SAVE</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-edit">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">EDIT MEMBER</h4>
					</div>
					<div class="modal-body">
						<form name="frmeditmember" class="form-horizontal" enctype="multipart/form-data">
						
							<div class="form-group">
								<label for="">NAME</label>
								<input type="text" class="form-control" id="name" placeholder="Input name" name="name" ng-model="member.name" ng-pattern="regex" ng-maxlength="100" ng-required="true">

								<div ng-show="frmeditmember.name.$dirty && frmeditmember.name.$invalid" >
									<span style="color: red" ng-show="frmeditmember.name.$error.required">The Name is required and cannot be empty</span>
									<span style="color: red" ng-show="frmeditmember.name.$error.maxlength">The Name must be less than 100 characters</span><br>
									<span style="color: red" ng-show="frmeditmember.name.$error.pattern">The name must be alphabetic characters, with no special characters </span>
								</div>

							</div>

							<div class="form-group">
								<label for="">ADDRESS</label>
								<textarea type="text" class="form-control" id="address" rows="5"  placeholder="Input address" name="address" value="@{{address}}" ng-model="member.address" ng-maxlength="300"  ng-required="true"></textarea>
								<div ng-show="frmeditmember.address.$dirty && frmeditmember.address.$invalid" >
									<span style="color: red" ng-show="frmeditmember.address.$error.required">The address is required and cannot be empty</span>
									<span style="color: red" ng-show="frmeditmember.address.$error.maxlength">The address must be less than 300 characters</span><br>
								</div>

							</div>

							<div class="form-group">
								<label for="">AGE</label>
								<input type="text" class="form-control" id="age" placeholder="Input age" name="age" value="@{{age}}" ng-model="member.age" ng-maxlength="2" ng-pattern="/^[0-9]*$/" ng-required="true">

								<div ng-show="frmeditmember.age.$dirty && frmeditmember.age.$invalid" >
									<span style="color: red" ng-show="frmeditmember.age.$error.required">The age is required and cannot be empty</span>
									<span style="color: red" ng-show="frmeditmember.age.$error.maxlength">The age must be less than 2 characters</span><br>
									<span style="color: red" ng-show="frmeditmember.age.$error.pattern">The age must be a number</span>
								</div>
							</div>

							
							<div class="form-group">
                                <label for="psw"> PHOTO </label>
                                <div class="col-md-12">
                                <div class="row heightImage">
                                    <div class="col-sm-6">
                                       <input type="file" ngf-select ng-model="files" name="photo"  ngf-max-size="10MB" ngf-model-invalid="errorFile" ng-image-editor="@{{member.photo}}" ngf-pattern="regexImage" class="form-control upload" file-model="myFile" id="upload">
                                            
                                    </div>
                                    <div class="col-sm-5">
                                       <img ng-show="frmeditmember.myFile.$valid" ngf-thumbnail="files"
                                          class="img-thumbnail" id="imgThumbnail" width="100em" id="image">
                                       <button ng-click="picFile = null" ng-show="picFile" class="btn btn-danger btn-sm">
                                           <span style="font-size: 10px">
                                           		<i class="fa fa-close"></i>
                                           </span>
                                       </button>
                                    </div>
                                    
                                </div>
                            	<span style="color: red" id="helpBlock2" class="help-block colorMessages" ng-show="frmeditmember.photo.$error.pattern">Image only support: png; jpg; jpeg; gif.</span>
                                <span style="color: red" id="helpBlock2" class="help-block colorMessages" ng-show="frmeditmember.photo.$error.maxSize">File too large: max 10MB</span>
                            </div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<div id="error-edit" style="text-align: left; color: red">
							
						</div>
						<button type="submit" class="btn btn-primary" id="btn-save" ng-click="saveEditMember(id)" ng-disabled="frmmember.$invalid">SAVE</button>
					</div>
				</div>
			</div>
		</div>	
	</div>
	{{-- <script type="text/javascript" src="{{ asset('app/lib/angular.min.js') }}"></script> --}}
	<script src="{{asset('app/app.js')}}"></script>
	<script src="{{asset('app/controller/member.js')}}"></script>
	<script src="{{ asset('app/lib/ng-file-upload-all.min.js') }}"></script>
	<script src="{{ asset('app/lib/ng-file-upload-shim.min.js') }}"></script>
	<script src="{{ asset('app/lib/ng-file-upload.min.js') }}"></script>
</body>
</html>