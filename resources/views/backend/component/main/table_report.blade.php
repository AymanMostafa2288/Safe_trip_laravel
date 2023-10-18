<div class="portlet box red">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-bar-chart"></i> {{ $name }}
        </div>

    </div>
    <div class="portlet-body">
        <div class="table-scrollable">
            <table class="table table-hover">
            <thead>
            <tr>
                @foreach ($heads as $head)
                    <th style="text-align: center;">{{ $head }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
                @if(count($rows) < 1)
                    @php
                        $count_head=count($heads)+1;
                    @endphp
                    <tr class="odd gradeX">
                        <th colspan="{{ $count_head }}">{{ appendToLanguage(getDashboardCurrantLanguage(),'globals','No Data Found') }}</th>
                    </tr>
                @endif

                @foreach($rows as $body)
                    <tr>
                        @foreach($heads as $head)
                            <td style="text-align: center;">{{ $body->$head }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
