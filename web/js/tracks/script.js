function limitInput(obj) {
    obj.value = obj.value.replace(/[^a-zA-Z0-9 -]/ig,'');
}

$('body').on('change', '[name="Track_release[track]"]', function(e) {
    var val = $(this).val();
    if (val){
        val = val.replace('fakepath','');
        val = val.replace("C:",'');
    }
    $('.file-return').html(val.slice(2));
});

/*
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
}*/