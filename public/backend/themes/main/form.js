let successMessage=function(message){
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    })
};
let errorMessage=function(message){
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Oops...',
        text: message,

    })
};
// <i class="fa fa-exclamation-triangle"></i></span> asdasdas

let validateMessage = function(messages){
    $.each( messages, function( index, value ){
        if(index.includes(".")){
            var split_string = index.split(".");
            index = split_string.join('_');
        }
        $('#'+index+'_validation').html('<i class="fa fa-exclamation-triangle"></i></span> '+value[0]);

    });
    swal.close();
};

let waitMessage=function (){
    Swal.fire({
        title: 'Please Wait....',
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {

            }, 100)
        },
    })
}


let submitted_form=function(form,submitted_button=''){
    waitMessage();
    let formData  = new FormData( form );
    form          = $(form);
    if(submitted_button!=''){
        formData.append(submitted_button, " ");
    }
    $.ajax({
        method:form.attr('method'),
        url:form.attr('action'),
        data:formData,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        processData:false,
        contentType: false,
        cache: false,
        enctype: 'multipart/form-data',
        success:function (response ,textStatus, xhr) {

            // removeValidationMessages();

            // if(xhr.status === 202){
            //     warningAlert('Check Your Email','Check Your Email Please To Verify Your Account').then( () => window.location.replace( form.data('redirection-url') ) );
            // }else{
            //     successAlert( form.data('success-message') ).then( () => window.location.replace( form.data('redirection-url') ) );

            //     form.trigger('reset');

            //     if (form.data("success-callback-function") !== undefined)
            //         window[form.data("success-callback-function")](200, response);
            // }
            successMessage(response.message);
            if(response.redirect=='#'){
                window.location.reload();
            }else{
                window.location.assign(response.redirect);
            }




        },
        error:function (response) {

            // removeValidationMessages();

            // if (response.status === 422)
            //     displayValidationMessages(response.responseJSON.errors , form);
            // else if (response.status === 403)
            //     unauthorizedAlert();
            // else if (response.status === 419)
            //     warningAlert( translate('session is expired, retry again') , '' , 2000 ).then( () => window.location.reload() );
            // else
            //     errorAlert(response.responseJSON.message , 5000 )

            // showHiddenTransInputs( response )

            // if ( form.data('error-callback-function') !== undefined )
            //     window[ form.data('error-callback-function') ]( response )
            if(response.status === 422)
                validateMessage(response.responseJSON.errors);
            else
                errorMessage(response.responseJSON.message);
        },
    });

}

$(document).ready(function () {
    $('#submitted-form,.submitted-form').submit(function (event) {
        event.preventDefault();
        var submitted_button = event.originalEvent.submitter;
        submitted_button=$(submitted_button).attr('name');
        if(submitted_button=='save'){
            submitted_form( this );
        }else{
            submitted_form( this ,submitted_button);
        }
    })
});
