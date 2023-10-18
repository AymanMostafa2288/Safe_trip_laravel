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
    let client_id=dragged.getAttribute('data-id');
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
    var status_id=parent.getAttribute('data-id');
    console.log(status_id);

    parent.appendChild(dragged);
    dropelement(status_id,client_id);
}
function dropelement(status,client){
    var url=dashboardUrl+'/change_status_clients?status='+status+'&client='+client;
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
