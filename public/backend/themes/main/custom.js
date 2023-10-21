/*
    - List Of Item Component
*/

    $('.list_item_added_plugin').click(function() {

        var element = $(this).attr('name_element');
        var records_count=$(this).attr('records_count');
        var record=$("div.element_fields_"+element+"[count='1']");
        var length= parseInt(records_count) + 1;

        $(this).attr('records_count',length);
        setTimeout(function() {
            var new_record = record.clone();
            new_record.addClass('show');
            new_record.css('display','block');
            new_record.attr('count', length);
            new_record.find('.delete_element').attr('count', length);
            new_record.find('.delete_element').css('display','initial');

            var append_or_pre=$('#new_fields_' + element);
            if(append_or_pre.attr('append')){
                if(append_or_pre.attr('append')=='first'){
                    new_record.prependTo('#new_fields_' + element);
                }else{
                    new_record.appendTo('#new_fields_' + element);
                }
            }else{
                new_record.appendTo('#new_fields_' + element);
            }

            if(length==2){
                record.find('.delete_element').css('display','none');
            }
            if(new_record.find('select').length > 0){
                new_record.find('select').each(function(){
                    $(this).select2();
                });
            }
            if(new_record.find('.validate_area').length > 0){
                new_record.find('.validate_area').each(function(){
                    var split_string = $(this).attr('id').split("_");
                    var code_key = Object.keys(split_string).find(key => split_string[key] === 'validation') -1;
                    var new_num = $('.delete_element').length - 1;
                    split_string[code_key] = new_num;
                    $(this).attr('id',split_string.join('_'));

                });
            }
        }, 500);
    });
    $(document).on('click', '.delete_element', function() {
        var element = $(this).attr('name_element');
        var record = $(this).attr('count');

        // $('#spinner_' + element).css('display', 'block');
        $('#add_' + element + '_record').css('display', 'none');
        setTimeout(function() {

            // $('#table_' + element + ' #tr_' + element + '_record_' + record).remove();
            $("div.element_fields_"+element+"[count='"+record+"']").remove();
            // $('#spinner_' + element).css('display', 'none');
            // var limit = $('#table_' + element);
            // if (limit.attr('limit') == '*') {
            //     $('#add_' + element + '_record').css('display', 'block');
            // } else {
            //     if ($('#table_' + element + ' #tr_' + element + '_record_' + record).length < limit.attr('limit')) {
            //         $('#add_' + element + '_record').css('display', 'block');
            //     }
            // }
        }, 500);

    });
    $(document).on('click', '.check_delete_multi', function() {
        if(this.checked){
            var html='<input type="hidden" name="ids[]" class="elements_deleted" id="element_'+$(this).val()+'" value="'+$(this).val()+'">';
            $('#ids_deleted').append(html);
        }else{
            $('#ids_deleted #element_'+$(this).val()+'').remove();
        }
        var length = $('.elements_deleted').length;
        if(length > 0){
            document.getElementById('delete_btn_all').removeAttribute('disabled');
        }else{
            document.getElementById('delete_btn_all').setAttribute('disabled', 'disabled');
        }
    });


    // Start Inputs Display True Or False

    $( document ).ready( function(){
        $("[main_attr='depends_by']").change(function(){
            var name=$(this).attr('name');
            var val=$(this).val();

            $("[depends_on='"+name+"']").each(function(){
                var child_val=$(this).attr('depends_on_value');
                var array_val = child_val.split(",").map(String);
                if(array_val.includes(val)){
                    $(this).css("display", "block");
                }else{
                    $(this).css("display", "none");
                }
            });
        });
        if( $("[show_div_by]").length > 0){

            var show_hide_div = function (element){
                var values=element.attr('show_div_by');
                var dives=element.attr('div_depends_show');
                var val=element.val();
                var val=element.val();
                var values=JSON.parse(values);
                var dives=JSON.parse(dives);
                var index = values.indexOf(val);
                var div_should_be_show=dives[index];
                $.each( dives, function( key, value ) {
                    if(key==index){
                        $('#'+value).css("display", "block");
                    }else{
                        if(value!=div_should_be_show){
                            $('#'+value).css("display", "none");
                        }
                    }
                });
            }

            $("[show_div_by]").each(function(){
                show_hide_div($(this));
            });
            $("[show_div_by]").change(function(){
                show_hide_div($(this));
            });



        }

    });
    // End Inputs Display True Or False

    $( document ).ready( function(){
        $("#location_country_id").change(function(){
            var country_id=$(this).val();
            var location_level=$(this).attr('location_level');
            if(location_level=='state'){
                $("#location_state_id").css("display", "block");
                $("#location_city_id").css("display", "none");
                $("#location_area_id").css("display", "none");
                $("#location_district_id").css("display", "none");
                var getFrom='install_states';
            }else if(location_level=='city'){
                $("#location_city_id").css("display", "block");
                $("#location_area_id").css("display", "none");
                $("#location_district_id").css("display", "none");
                var getFrom='install_cities';
            }else if(location_level=='area'){
                $("#location_area_id").css("display", "block");
                $("#location_district_id").css("display", "none");
                var getFrom='install_areas';
            }else{
                $("#location_district_id").css("display", "block");
                var getFrom='install_districts';
            }

            var url=dashboardUrl+'/get-locations/from/'+getFrom+'/id/'+country_id;
            const request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText!=''){
                        $('#divCodes'+parent).empty();
                        $('#divCodes'+parent).append(this.responseText);
                    }else{
                        if(level==1){
                            $('#divCodes'+parent).empty();
                        }

                    }

                }
            };
            request.open("GET", url);
            request.send();
        });
    });
    $( document ).ready( function(){
        $(".check_all").click(function(){
            var val = $(this).val();
            var inputs=$("input[name='"+val+"']");

            if(this.checked){
                var checked = true;
            }else{
                var checked = false;
            }
            inputs.each(function(){
                $(this).prop('checked',checked);
            });

        });
    });




    //==============================================================================


        $(document).on('keyup', 'input[max]', function (e) {
            let max = parseInt($(this).attr('max'));
            if (parseInt(this.value) > max) {
                this.value = max;
                console.log(max)
            }
        });


        $( document ).ready( function(){
            $("[get_from]").change(function(){
                var table = $(this).attr('get_from');
                var table_field = $(this).attr('get_from_field');
                var where = $(this).attr('name');
                var value = $(this).val();

                if(value=='' || value=="undefined"){
                    $("[append_select_from="+table+"]").each(function(){
                        var select=$(this);
                        select.empty();
                    });
                }else{

                    var url=dashboardUrl+'/get_data_db_table?table='+table+'&table_field='+table_field+'&where='+where+'&value='+value;
                    const request = new XMLHttpRequest();
                    request.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var options=JSON.parse(this.responseText);
                            $("[append_select_from="+table+"]").each(function(){
                                var select=$(this);
                                select.empty();
                                $.each( options, function( index, value ){
                                    var newOption = new Option(value, index, false, false);
                                    select.append(newOption);
                                });
                            });
                        }
                    };
                    request.open("GET", url);
                    request.send();
                }

            });
        });




//=====================================================================================

if($('.numbers_need_to_sum').length > 0){
    $(document).on('keyup', ".numbers_need_to_sum", function(data) {
        var total=0;
        $('.numbers_need_to_sum').each(function(index,element){
            var price=$(this).val();
            if(!price || price=='NaN'){
                price=1;
            }
            if($(this).parent().parent().find('.numbers_need_to_sum_amount')){
                var amount=$(this).parent().parent().find('.numbers_need_to_sum_amount').val();
                if(!amount){
                    amount=1;
                }
                total =total + parseInt(price) * parseInt(amount);
            }else{
                total =total + parseInt(price);
            }

        });
        $('#sum_of_numbers').val(total);

    });

    $(document).on('keyup', ".numbers_need_to_sum_amount", function(data) {
        var total=0;
        $('.numbers_need_to_sum_amount').each(function(index,element){
            if($(this).parent().parent().find('.numbers_need_to_sum')){
                var price=$(this).parent().parent().find('.numbers_need_to_sum').val();
                if(!price){
                    price=1;
                }
                total =total + parseInt($(this).val()) * parseInt(price);
            }else{
                total =total + parseInt($(this).val());
            }

        });
        $('#sum_of_numbers').val(total);

    });

    $(document).on('click', ".delete_element", function(data) {
        setTimeout(function(){
            var total=0;
            $('.numbers_need_to_sum').each(function(index,element){
                var price=$(this).val();
                if(!price || price=='NaN'){
                    price=1;
                }
                if($(this).parent().parent().find('.numbers_need_to_sum_amount')){
                    var amount=$(this).parent().parent().find('.numbers_need_to_sum_amount').val();
                    if(!amount || amount=='NaN'){
                        amount=1;
                    }
                    total =total + parseInt(price) * parseInt(amount);
                }else{
                    total =total + parseInt(price);
                }
            });
            $('#sum_of_numbers').val(total);
        },500);

    });

    $(document).on('click', ".list_item_added_plugin", function(data) {


        setTimeout(function(){
            var total=0;
            $('.numbers_need_to_sum').each(function(index,element){
                var price=$(this).val();
                if(!price || price=='NaN'){
                    price=1;
                }
                if($(this).parent().parent().find('.numbers_need_to_sum_amount')){
                    var amount=$(this).parent().parent().find('.numbers_need_to_sum_amount').val();
                    var price=$(this).val();
                    if(!amount){
                        amount=1;
                    }
                    if(!price && price!='NaN'){
                        price=1;
                    }
                    total =total + parseInt(price) * parseInt(amount);
                }else{
                    total =total + parseInt(price);
                }

            });

            $('#sum_of_numbers').val(total);
        },500);

    });

}
