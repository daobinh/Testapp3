app.directive('fileModel', ['$parse',function ($parse) {
	return {
		restrict: 'A',
		link: function (scope, iElement, iAttrs) {
			var model = $parse(iAttrs.fileModel);
			var modelSetter = model.assign;

			iElement.bind('change', function() {

				scope.$apply(function(){
					modelSetter(scope,iElement[0].files[0])
				});
			});


		}
	};
}]);


app.controller('MemberController',function ($scope,$http,API_URL) {

	$scope.regex = /^[a-zA-Z]+$/;
	$scope.regexImage = "image/png,image/jpg,image/gif,image/jpeg";
	

	$http.get(API_URL + 'members').success(function(response){
		$scope.members = response;
	});

	
	$scope.create = function(){
		$('#modal-create').modal({

        	backdrop: 'static',
        });
        document.getElementById("frmcreate").reset();
        $scope.files = null;
		$scope.frmcreatemember.$setPristine();

		console.log(API_URL);
	}

	$scope.saveNewMember = function(){
		var url = API_URL + 'member';
		
		if ($scope.myFile == undefined) {
				$scope.myFile = '';
			}
		console.log($scope.myFile);
		if ($scope.frmcreatemember.$valid) {

			data_value = {
				"name" : $scope.member.name,
				"address" : $scope.member.address,
				"age" : $scope.member.age,
			};
			if ($scope.myFile) {
				data_value.photo = $scope.myFile;
			}
			$http({
				method: 'post',
				url: url,
				headers: {'Content-Type': undefined},
				data: data_value,
				transformRequest: function (data, headersGetter) {
	                var fd = new FormData();
	                angular.forEach(data, function (value, key) {
	                    fd.append(key, value);
	                });
	                var headers = headersGetter();
	                delete headers['Content-Type'];
	                return fd;
	            }
			})
			.success(function(response){
				$http.get(API_URL + 'members').success(function(response){
					$scope.members = response;
				});

				$('#modal-create').modal('hide');
			})
		}
	}

	$scope.update = function(id){
		$scope.id = id;

		$http.get(API_URL + 'member/' + id).success(function(response){
			$scope.member = response;	
		});
		$('#modal-edit').modal({
        	backdrop: 'static',
        });

	}

	$scope.saveEditMember = function(id){
		var url = API_URL + 'member/' + id ;
		if ($scope.myFile == undefined) {
			if ($scope.frmeditmember.$valid) {
				$http({
					method: 'post',
					url: url,
					headers: {'Content-Type': undefined},
					data: {
						name : $scope.member.name,
						address : $scope.member.address,
						age : $scope.member.age,
					},
					transformRequest: function (data, headersGetter) {
		                var fd = new FormData();
		                angular.forEach(data, function (value, key) {
		                    fd.append(key, value);
		                });
		                var headers = headersGetter();
		                delete headers['Content-Type'];
		                return fd;
		            }
				})
				.success(function(response){
					$http.get(API_URL + 'members').success(function(response){
						$scope.members = response;
					});

					$('#modal-edit').modal('hide');
				})
			}
		}
		else{
			if ($scope.frmeditmember.$valid) {
				$http({
					method: 'post',
					url: url,
					headers: {'Content-Type': undefined},
					data: {
						name : $scope.member.name,
						address : $scope.member.address,
						age : $scope.member.age,
						photo : $scope.myFile
					},
					transformRequest: function (data, headersGetter) {
		                var fd = new FormData();
		                angular.forEach(data, function (value, key) {
		                    fd.append(key, value);
		                });
		                var headers = headersGetter();
		                delete headers['Content-Type'];
		                return fd;
		            }
				})
				.success(function(response){
					$http.get(API_URL + 'members').success(function(response){
						$scope.members = response;
					});

					$('#modal-edit').modal('hide');
				})
			}
		}
		
	}


	$scope.delete = function(id){
		var isDelete = confirm('are you sure delete record ?');

		if (isDelete) 
		{
			$http.get(API_URL + 'delete/' + id).success(function(response){
				$http.get(API_URL + 'members').success(function(response){
					$scope.members = response;
				});
			})
		}
		else
		{
			return false;
		}
	}
	
	$scope.sortBy = function(propertyName) {
	    $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
	    $scope.propertyName = propertyName;
	  };


});

app.filter('offset', function() {
  return function(input, start) {
  	if (!input || !input.length) { return; }
    start = parseInt(start, 10);
    return input.slice(start);
  };
});