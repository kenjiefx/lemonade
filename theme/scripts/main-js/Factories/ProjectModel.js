app.factory('ProjectModel',function(){
    class ProjectModel {
        constructor(){
            this.id = ProjectData.id;
            this.handle = ProjectData.handle;
            this.title = ProjectData.title;
            this.photo = ProjectData.photo;
            this.location = ProjectData.location;
            this.metrics = {};
            this.about = ProjectData.about;
            this.type = ProjectData.type;
            this.cost = ProjectData.cost;
            this.status = ProjectData.status;
            this.posts = {};
            this.hasPostlist = false;
            this.requester = {};
        }
    }
    return new ProjectModel;
});
