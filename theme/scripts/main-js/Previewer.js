app.scope('Previewer',function($scope,PageSvc,ProjectModel,ProjectSvc){

    /** Importing Services **/
    $scope.ProjectSvc = ProjectSvc;
    $scope.ProjectModel = ProjectModel;
    $scope.PageSvc = PageSvc;

    /** Setting page state depending whether the previewed template or module
    is existing or not **/
    PageSvc.setState(Previewer.status);

});
