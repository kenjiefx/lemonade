/**
 * Page Services
 * @requires xpatch="PageState" 
 */
app.service('PageSvc',function($scope,$patch){
    class PageSvc {
        constructor(){
            this.state = 'error';
        }
        setState(state){
            this.state = state;
            $patch('PageState');
        }
    }
    return new PageSvc;
});
