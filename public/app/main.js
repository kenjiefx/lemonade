strawberry.create('app',function(){
  setTimeout(function(){
    $(".loading").fadeOut();
    $("#loader").html("");
    $("#main").fadeIn();
  },2000);
});

app.factory('presets',function(){
  return {}
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
  }

  return UserSvc;
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
