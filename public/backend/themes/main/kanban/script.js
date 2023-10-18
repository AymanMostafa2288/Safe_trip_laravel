var dragged;
function drag(e) {
    dragged = e.target;
}
function allowDrop(e) {
    e.preventDefault();

}
function drop(e) {
    e.preventDefault();


    let parent;
    let task_id=dragged.getAttribute('data-id');
    if(e.currentTarget){
        // In Safari no path
        parent = e.currentTarget
    }else{
        // In chrome path
        parent = e.path.filter((i)=>{
            if(i.classList){
                return i.classList.contains('kanban-list');
            }
        })[0];
    }
    var stage_id=parent.getAttribute('data-id');
    console.log(stage_id);

    parent.appendChild(dragged);
    dropelement(stage_id,task_id);
}
function dropelement(stage,task){
    var url=dashboardUrl+'/change_stage_tasks?stage='+stage+'&task='+task;
    const request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // this.responseText
        }
    };
    request.open("GET", url);
    request.send();
    return true;
}
