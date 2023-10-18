if($('.animals_count').length > 0){
    $(document).on('keyup', ".animals_count", function(data) {
        var total_animals=0;
        $('.animals_count').each(function(index,element){
            total_animals =total_animals + parseInt($(this).val());
        });
        $('#animals_total_count').val(total_animals);

    });

    $(document).on('click', ".delete_element", function(data) {
        setTimeout(function(){
            var total_animals=0;
            $('.animals_count').each(function(index,element){
                total_animals =total_animals + parseInt($(this).val());
            });
            $('#animals_total_count').val(total_animals);
        },500);

    });
}

