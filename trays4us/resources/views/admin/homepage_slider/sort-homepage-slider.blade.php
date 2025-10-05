<style type="text/css">
  #sortable { list-style-type: none; margin: 0; padding: 0;width: 100% }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 45px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
</style>
<div class="col-md-12 mt-2">

    <ul id="sortable">
        @foreach($homepage_sliders as $key=>$homepage_slider)
            <li class="ui-state-default selector" id="{{$homepage_slider->id}}"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span> {{$homepage_slider->slider_title}}</li>
      @endforeach
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="modal-footer pt-3 pr-0 pl-0">
                <a href="javascript:void(0)" id="submitSort" class="btn btn-success octf-btn">Save</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var pass_array = [];

    $( "#sortable" ).sortable({
        update: function () {
            pass_array = $(this).sortable('toArray');
            console.log(pass_array)
        }
    });
    pass_array = $("#sortable").sortable('toArray');
    $( "#sortable" ).disableSelection();

    $("#submitSort").click(function (argument) {
    $.ajax({
            method: "POST",
            url:"{{route('sort-homepage-slider-submitted')}}",
            data:{
                "_token": "{{csrf_token()}}",
                "pass_array": pass_array
                }
                }).done(function(data) {
                    if(data.status && data.status == 'success') {
                        window.location.reload();
                    }
                });
  });

});
</script>
