strawberry.create('app',function(){
  setTimeout(function(){
    $(".loading").fadeOut();
    $("#loader").html("");
    $("#main").fadeIn();
  },2000);
});

app.factory('presets',function(){
  return {
    icons: {
      emptyProfilePhoto:'/images/empty-profile.png',
      stars:{
        full:'<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill:#009b84; transform: ;msFilter:;"><path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"></path></svg>',
        half:'<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill:#009b84; transform: ;msFilter:;"><path d="M5.025 20.775A.998.998 0 0 0 6 22a1 1 0 0 0 .555-.168L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082a1 1 0 0 0-.59-1.74l-5.701-.454-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.214 4.107-1.491 6.452zM12 5.429l2.042 4.521.588.047h.001l3.972.315-3.271 2.944-.001.002-.463.416.171.597v.003l1.253 4.385L12 15.798V5.429z"></path></svg>',
        empty:'<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill:#dfdfdf; transform: ;msFilter:;"><path d="M21.947 9.179a1.001 1.001 0 0 0-.868-.676l-5.701-.453-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4 4.536-4.082c.297-.268.406-.686.278-1.065z"></path></svg>'
      },
      review:'<svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="2 2 20 20" style="fill:#009b84; transform: ;msFilter:;"><path d="M20 2H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h3v3.766L13.277 18H20c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zm0 14h-7.277L9 18.234V16H4V4h16v12z"></path><circle cx="15" cy="10" r="2"></circle><circle cx="9" cy="10" r="2"></circle></svg>'
    },
    routes:{
      unAuth: {
        landingPage: '/login.html'
      }
    }
  }
});

app.factory('Requester',function(presets){
  class RequesterModel {
    constructor(){
      this.refresh();
    }
    set(requester){
      void 0!==requester.status&&localStorage.setItem("ractive",requester.status);
      void 0!==requester.name&&localStorage.setItem("rname",requester.name);
      void 0!==requester.token&&localStorage.setItem("rtoken",requester.token);
      void 0!==requester.username&&localStorage.setItem("rusername",requester.username);
      void 0!==requester.photo&&localStorage.setItem("rphoto",requester.photo);
      this.refresh();
    }
    refresh(){
      this.status = null==localStorage.getItem('ractive')?'offline':localStorage.getItem('ractive');
      this.name = null==localStorage.getItem('rname')?'':localStorage.getItem('rname');
      this.token = null==localStorage.getItem('rtoken')?'public':localStorage.getItem('rtoken');
      this.username = null==localStorage.getItem('rusername')?'':localStorage.getItem('rusername');
      this.profilePhoto = null;
      if (localStorage.getItem('rphoto')!=='null') {
          this.profilePhoto = localStorage.getItem('rphoto');
      }

    }
    signOut(){
      this.set({
        status: 'offline',
        name:'',
        token:'public',
        username:'',
        photo:presets.emptyProfilePhoto
      });
    }
    checkStatus(){
      if (this.status=='offline') {
        location.href=presets.routes.unAuth.landingPage;
      }
    }
  }
  return new RequesterModel;
});

app.factory('modules',function(){
  return {
    'page-error':'/modules/error-page.htm'
  }
});

app.service('UserSvc',function($scope,$patch){
  class UserModel {
    constructor(user){
      this.id = user.id;
      this.firstName = user.firstName;
      this.username = user.username;
      this.lastName = user.lastName;
      this.location = user.location;
      this.about = user.about;
      this.primaryPhotos = {
        profile: user.primaryPhotos.profile,
        cover: user.primaryPhotos.cover
      }
      this.patch();
    }
    setSettings(settings){
      this.Settings = new UserSettings(settings);
    }
    getSettings()
    {
      return this.Settings;
    }
    patch(){
      $patch('UserModelPatch');
    }
  }

  class UserSettings {
    constructor(settings){
      this.allowTest = settings.allowTest;
    }
    apply(){
      $patch('UserModelPatch');
    }
  }

  class UserSvc {
    constructor(user){
      $scope.UserModel = new UserModel(user);
    }
    settings(settings){
      $scope.UserModel.setSettings(settings);
      return $scope.UserModel.getSettings();
    }
    createInitials(){
      let fName = $scope.UserModel.firstName.charAt(0);
      let lName = $scope.UserModel.lastName.charAt(0);
      return fName+''+lName;
    }
  }

  return UserSvc;
});


app.service('ProjectSvc',function($scope,$patch,$show,$hide){
  class ProjectModel {
    constructor(project){
      this.id = project.id;
      this.handle = project.handle;
      this.title = project.title;
      this.photo = project.photo;
      this.location = project.location;
      this.metrics = project.metrics;
      this.about = project.about;
      this.type = project.type;
      this.cost = project.cost;
      this.status = project.status;
      this.requester = project.requester;
    }
  }

  class ProjectActions{
    constructor(){

    }
    follow(){
      if ($scope.ProjectModel.requester.isAllowed.toFollow) {
        if (!$scope.ProjectModel.requester.metrics.hasFollowed) {
          $scope.ProjectModel.requester.metrics.hasFollowed = true;
          $scope.ProjectModel.metrics.follows++;
        } else {
          $scope.ProjectModel.requester.metrics.hasFollowed = false;
          $scope.ProjectModel.metrics.follows--;
        }
        this.updateMetrics();
      }
    }
    like(){
      if ($scope.ProjectModel.requester.isAllowed.toLike) {
        if (!$scope.ProjectModel.requester.metrics.hasLiked) {
          $scope.ProjectModel.requester.metrics.hasLiked = true;
          $scope.ProjectModel.metrics.hearts++;
        } else {
          $scope.ProjectModel.requester.metrics.hasLiked = false;
          $scope.ProjectModel.metrics.hearts--;
        }
        this.updateMetrics();
      }
    }
    updateMetrics(){
      $patch('ProjectMetricsUpdater');
    }
  }

  class ProjectSvc{
    constructor(project){
      $scope.ProjectModel = new ProjectModel(project);
      this.patch();
      this.actions = new ProjectActions;
      this.viewDetailsState = false;
    }
    patch(){
      $patch('ProjectModelPatch');
    }
    toCount(num){
      return numeral(num).format('0,0');
    }
    viewDetails(){
      $show('ProjectDetailsList');
      this.viewDetailsState = true;
      $patch('ProjectViewDetails');
    }
    hideDetails(){
      $hide('ProjectDetailsList');
      this.viewDetailsState = false;
      $patch('ProjectViewDetails');
    }
  }
  return ProjectSvc;
});

app.service('AjaxSvc',function($scope){
  const svc = {

  }
  return {
    get:function(argv){
      $.ajax({
        type:'GET',
        url:argv.url,
        contentType:'application/json',
        success:function(response){
          argv.success(response);
        },
        error:function(error){
          argv.error(error);
        }
      });
    }
  }
});
