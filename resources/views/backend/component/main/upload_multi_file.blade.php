@php
    $limit=$limit-count($value);
    $count=1;
@endphp

<input id="multi_upload" type="file" name="{{ $name }}[]"
@if(isset($readonly) && $readonly==true)
    style="display: none !important;"
@endif
 limitImage={{ $limit }}
 maxSize={{ $maxSize }}
 LimitedUploade=8
 maxExtensions="pdf|csv|png|jpg|jpeg"
 dragText="{{ appendToLanguage(getDashboardCurrantLanguage(),'content',"Drag and Drop your files here") }}"
 btnText="{{ appendToLanguage(getDashboardCurrantLanguage(),'content',"Browse files") }}"
 sizeError="{{ appendToLanguage(getDashboardCurrantLanguage(),'content',"Size of the file is greather than allowed") }}"
 errorOnResponse="{{ appendToLanguage(getDashboardCurrantLanguage(),'content',"There has been an error uploading your file") }}"
 limitError="{{ appendToLanguage(getDashboardCurrantLanguage(),'content',"You have reached the limit of files that you can upload") }}"
 delfiletext="{{ appendToLanguage(getDashboardCurrantLanguage(),'content',"IRemove") }}"
 invalidExtError="{{ appendToLanguage(getDashboardCurrantLanguage(),'content',"Invalid File Type") }}"
  multiple  />

  <input type="hidden" id="multi_upload_removed" name="{{ $name }}_removed" value="">
  @foreach ($value as $val)
  @php
      $arr=explode('/uploads/',$val);
      $fileName=$arr[1];
  @endphp
    <div class="pekerow pkrw" rel="0">
        <div class="pekeitem_preview">
            <img class="thumbnail" src="{{ $val }}" height="64">
        </div>
        <div class="file">
            <div class="filename">File {{ $count++ }}</div>
        </div>
        <div class="pkdelfile">
            <a href="javascript:void(0);" class="delbutton pkdel" fileName="{{ $fileName }}">Remove from queue</a>
            <a href="{{ $val }}" target="_blank">| show</a>
        </div>
    </div>

  @endforeach
