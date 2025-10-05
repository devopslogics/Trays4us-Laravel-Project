/*
create a chainable method for the script to
*/
$.fn.tagsValues = function (method /*, args*/) {
    // loop through all tags getting the attribute value
    var data = [];
    $(this).find(".data .tag .text").each(function (key, value) {
        let v = $(value).attr('_value');
        //console.log(v);
        data.push(v);
    });

    return data;
};

/*
Handle click of the input area
*/
$(document).on("click", ".tags-input", function () {
    $(this).find('input').focus();
});

/*
handle the click of close button on the tags
*/
$(document).on("click", ".tags-input .data .tag .close", function () {
    // whatever you do to delete this row
    _this = $(this);
    $(this).parent().remove();
   // $('.tag-ids').val($('.myTags').tagsValues());

   // console.log('tag values before');
    //console.log(data);
   // console.log('tag values after');

    var data2 = [];

    _this.closest('.tag_wrapper').find("span.text").each(function (key, value) {
        var v3 = $(value).attr('_value');
        data2.push(v3);
    });
    $(this).closest('.tag_wrapper').find('.tag-ids').val(data2);

});

/*
Handle the click of one suggestion
*/

$(document).on("click", ".tags-input .autocomplete-items div", function () {
    let index = $(this).index();
    let data = _tag_input_suggestions_data[index];
    let data_holder = $(this).parents().eq(4).find('.data');
    _add_input_tag(data_holder, data.id, data.name);
    //$('.tags-input .autocomplete-items').html('');
    //$('.tag-ids').val($('.myTags').tagsValues());
    //alert();

   // console.log('ccccccccccccc');
   // console.log($(this).closest('.tags-input').find('.myTags').tagsValues());
    //$(this).closest('.tag_wrapper').find('.tag-ids').val($(this).closest('.tags-input').find('.myTags').tagsValues());
    var data1 = [];
    _this = $(this);
    _this.closest('.tag_wrapper').find("span.text").each(function (key, value) {
        var v2 = $(value).attr('_value');
        console.log(v2);
        data1.push(v2);
    });
    $(this).closest('.tag_wrapper').find('.tag-ids').val(data1);
    $(this).closest('.tag_wrapper').find('.autocomplete-items').html('');
});

/*
detect enter on the input
*/
$(document).on("keydown", ".tags-input input", function (event) {
//$(".tags-input input").on("keydown", function (event) {
    if (event.which == 13) {
        let data = $(this).val();
        if (data != "") _add_input_tag(this, data, data);
        //$('.tag-ids').val($('.myTags').tagsValues());
       // console.log('keydown');
      //  console.log($(this).closest('.tags-input').find('.myTags').tagsValues());

        var data1 = [];
        _this = $(this);
        _this.closest('.tag_wrapper').find("span.text").each(function (key, value) {
            var v2 = $(value).attr('_value');
            console.log(v2);
            data1.push(v2);
        });
        $(this).closest('.tag_wrapper').find('.tag-ids').val(data1);

        event.preventDefault();
        return false;
    }
});

$(document).on("focusout", ".tags-input input", function (event) {
    $(this).val("");
    var that = this;
    setTimeout(function () {
        $(that).parents().eq(2).find('.autocomplete .autocomplete-items').html("");
    }, 500);
   // $('.tag-ids').val($('.myTags').tagsValues());
   // console.log('focusout');
    //console.log($(this).closest('.tags-input').find('.myTags').tagsValues());
    var data1 = [];
    _this = $(this);
    _this.closest('.tag_wrapper').find("span.text").each(function (key, value) {
        var v2 = $(value).attr('_value');
        data1.push(v2);
    });
    $(this).closest('.tag_wrapper').find('.tag-ids').val(data1);

});

function _add_input_tag(el, data, text) {
    let template = "<span class=\"tag\"><span class=\"text\" _value='" + data + "'>" + text + "</span><span class=\"close\">&times;</span></span>\n";
    $(el).parents().eq(2).find('.data').append(template);
    $(el).val('');
    //$('.tag-ids').val($('.myTags').tagsValues());
    $(this).closest('.tag_wrapper').find('.tag-ids').val($(this).closest('.tags-input').find('.myTags').tagsValues());
    //console.log($(this).closest('.tags-input').find('.myTags').tagsValues());
}

$(document).on("keyup", ".tags-input input", function (event) {
//$(".tags-input input").on("keyup", function (event) {
    var query = $(this).val();

    if (event.which == 8) {
        if (query == "") {
          //  console.log("Clearing suggestions");
            $('.tags-input .autocomplete-items').html('');
            return;
        }
    }

    $(this).closest('.tag_wrapper').find('.autocomplete-items').html('');
    if (query.length > 2) {
        runSuggestions($(this), query);
    }
});
