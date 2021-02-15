function limitInput(obj) {
    obj.value = obj.value.replace(/[^a-zA-Z0-9 -]/ig,'');
}

$('body').on('change', '[name="Releases_form[release_logo]"]', function(e) {
    var val = $(this).val();
    if (val){
        val = val.replace('fakepath','');
        val = val.replace("C:",'');
    }
    $('.file-return').html(val.slice(2));
});

$('body').on('change', '[name="Releases_form[cover_image]"]', function(e) {
    var val = $(this).val();
    if (val){
        val = val.replace('fakepath','');
        val = val.replace("C:",'');
    }
    $('.file-return1').html(val.slice(2));
});

$('body').on('change', '#releases_form-exclusive', function (e) {
    if ($(this).val()=='Yes'){
        $('#exlusive_true').css({'display':'flex'});
        $('#releases_form-exclusive_date').prop('required', true);
        $('#releases_form-exclusive_store').prop('required', true);
        $('#releases_form-exclusive_period').prop('required', true);
    }else {
        $('#exlusive_true').css({'display':'none'});
        $('#releases_form-exclusive_date').val('');
        $('#releases_form-exclusive_store').val('');
        $('#releases_form-exclusive_period').val('');
        $('#releases_form-exclusive_date').prop('required', false);
        $('#releases_form-exclusive_store').prop('required', false);
        $('#releases_form-exclusive_period').prop('required', false);
    }
});

$('body').on('change', '#releases_form-territories', function (e) {
    if ($(this).val()=='Only Selected Territories'||$(this).val()=='Worldwide except selected territories') {
        $('#territory_selection_').css({'display':'block'});
        $('#releases_form-territory_selection').prop('required', true);
        $('#releases_form-territory_selection').css({'visibility': 'unset'});
    }else{
        $('#territory_selection_').css({'display':'none'});
        $('#releases_form-territory_selection').prop('required', false);
        $('#releases_form-territory_selection').val('');
        $('#releases_form-territory_selection').select2('');
        $('.select2-container--default').css({'width':'100%'});
        $('#releases_form-territory_selection').css({'visibility': 'hidden'});
    }
});

$('#w0').submit(function (event) {
    if (document.getElementById('releases_form-exclusive_date').value==''&&document.getElementById('releases_form-exclusive_date').hasAttribute('required')){
        event.preventDefault();
        $('#releases_form-exclusive_date').parent('').find('label').css({'color':'red'});
    }else{
        $('#releases_form-exclusive_date').parent('').find('label').css({'background-image':'greenlinear-gradient(to top, #4caf50 2px, rgba(76, 175, 80, 0) 2px), linear-gradient(to top, #d2d2d2 1px, rgba(210, 210, 210, 0) 1px);'});
    }
});

$('body').on('input', '#releases_form-bundle_price, #releases_form-track_price', function (e) {
    var max = $(this).attr('max');

    setValidatorThis($(this),/^[0-9.]*$/);
    $(this).val(setValidatorCol($(this).val()));

    if (max>0){
        if (parseFloat($(this).val())>parseFloat(max)){
            $(this).val(max);
        }
    }
});

$('body').on('click', '#del_logo', function (e) {
    var id = $(this).data('id');

    $.ajax({
        type: "POST",
        url: "/releases/deletelogo",
        data: {id:id},
        dataType: 'html',
        success: function(response) {
            $('#logo').html('');
        }
    });
});

$('body').on('click', '#del_image', function (e) {
    var id = $(this).data('id');

    $.ajax({
        type: "POST",
        url: "/releases/deleteimage",
        data: {id:id},
        dataType: 'html',
        success: function(response) {
            $('#image').html('');
        }
    });
});


function setValidatorThis(element, regex) {
    if (element) {
        var lastValue = element.val();
        if (!regex.test(lastValue))
            lastValue = '';
        setInterval(function () {
            var value = element.val();
            if (value != lastValue) {
                if (regex.test(value)) {
                    lastValue = value;
                }
                else {
                    element.val(lastValue);
                }
            }
        }, 10);
    }
}

function setValidatorCol(element){
    var mass = element.split('.'),
        count = mass.length-1;

    if (count>1){
        return element.substring(0, element.length - 1);
    }else{
        if (count==1){
            if (mass[1].length>2){
                return element.substring(0, element.length - 1);
            }else{
                return element;
            }
        }else{
            return element;
        }
    }
}