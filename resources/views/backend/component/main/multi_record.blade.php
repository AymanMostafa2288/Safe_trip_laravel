<div class="panel panel-default">
    <div class="panel-heading" >
        <div class="row">
            <div class="col-md-6">
                <h4>{{ appendToLanguage(getDashboardCurrantLanguage(),'globals',$title) }}</h4>
            </div>
            <div class="col-md-6" style="text-align: end;">
                @if(!isset($button_show))
                    {!! viewComponents('button',[
                        'type'=>'button',
                        'icon'=>'fa fa-plus',
                        'title'=>'Add New',
                        'class'=>'blue list_item_added_plugin',
                        'attributes'=>[
                            'name_element'=>@$name,
                            'records_count'=>(count($values)>0)?count($values):1,
                            ]
                        ])
                    !!}
                @endif
            </div>
        </div>

    </div>
    <div class="panel-body">
        @if (isset($folder))
        @include('backend.component.main.custom.'.$folder.'.multi_record_'.$type,['name'=>$name,'values'=>$values])
        @else
        @include('backend.component.main.custom.multi_record_'.$type,['name'=>$name,'values'=>$values])
        @endif

    </div>
</div>
