$('body').on('click', '#chek', function (e) {
    var check = $('.refund_table').find('input[type="checkbox"]'),
        value = $(this).data('value');

    if (value == 'all') {
        for (var i = 0; i < check.length; i++) {
            check.eq(i).prop('checked', true);
        }
        $(this).data('value', 'not_all');
        document.getElementById('chek').innerText = 'Cancel All';
    } else if (value == 'not_all') {
        for (var i = 0; i < check.length; i++) {
            check.eq(i).prop('checked', false);
            chech_false(check.eq(i).data('id'))
        }
        $(this).data('value', 'all');
        document.getElementById('chek').innerText = 'Check All';
    }

    return_calculation();
});

$('body').on('click', '[type="checkbox"]', function (e) {
    var check = $(this)[0].checked,
        tip = parseFloat($('#all_tip').text().substring(1)),
        id = $(this).data('id'),
        refund_total = parseFloat($('#refund_total').text());
    refund_total = tip_minus(refund_total, tip);

    if (check) {
        refund_total += chech_true(id);
        refund_total = tip_plus(refund_total, tip);
        total_refund(refund_total);
    } else {
        refund_total -= chech_false(id);
        refund_total = tip_plus(refund_total, tip);
        total_refund(refund_total);
    }
});

$('body').on('change', '#refund_persent', function (e) {
    var per = $(this).val(),
        id = $(this).data('id'),
        dollar = $('.refund_table').find('#refund_dollar[data-id="' + id + '"]').val(),
        min = parseInt($(this).attr('min')),
        max = parseInt($(this).attr('max'));

    setValidatorThis($(this), /^[0-9.]*$/);
    $(this).val(setValidatorCol(per));

    if (max < per) {
        per = max;
        $(this).val(max);
    }
    if (min > per) {
        per = min;
        $(this).val(min);
    }

    if (!per && !dollar) {
        per = max;
        $(this).val(max);
    }

    chech_true_per(id, per);
});

$('body').on('change', '#refund_dollar', function (e) {
    var dollar = parseFloat($(this).val()),
        id = $(this).data('id'),
        per = $('.refund_table').find('#refund_persent[data-id="' + id + '"]').val(),
        min = parseInt($(this).attr('min')),
        max = parseFloat($(this).attr('max'));

    setValidatorThis($(this), /^[0-9.]*$/);
    $(this).val(setValidatorCol(per));

    if (max < dollar) {
        dollar = max;
        $(this).val(max);
    }
    if (min > dollar) {
        dollar = min;
        $(this).val(min);
    }

    if (!per && !dollar) {
        dollar = max;
        $(this).val(max);
    }

    chech_true_dol(id, dollar);
});

$('body').on('click', 'button', function (e) {
    var textarea = $('.refund_textarea').val(),
        id = document.getElementById('id_order').value,
        refund_total = parseFloat($('#refund_total').text()) * 100,
        check = $('.refund_table').find("input:checked"),
        arr = [];

    for (var i = 0; i < check.length; i++) {
        arr[i] = {};
        arr[i]['id'] = check.eq(i).data('id');
        if (parseFloat($('.refund_table').find('#refund_persent[data-id="' + check.eq(i).data('id') + '"]').val()))
            arr[i]['refund_per'] = parseFloat($('.refund_table').find('#refund_persent[data-id="' + check.eq(i).data('id') + '"]').val());
        else arr[i]['refund_per'] = 0;
        if (parseFloat($('.refund_table').find('#refund_dollar[data-id="' + check.eq(i).data('id') + '"]').val()))
            arr[i]['refund_dol'] = parseFloat($('.refund_table').find('#refund_dollar[data-id="' + check.eq(i).data('id') + '"]').val()) * 100;
        else arr[i]['refund_dol'] = 0;

        arr[i]['refund'] = parseFloat($('[data-id_return="' + check.eq(i).data('id') + '"]').text().substring(1)) * 100;
    }

    if (textarea) $('.refund_textarea').css({'border': 'unset'});
    else $('.refund_textarea').css({'border': '1px solid red'});

    if (arr.length > 0) $('.refund_table').css({'border': 'unset'});
    else $('.refund_table').css({'border': '1px solid red'});

    if (arr.length > 0 && textarea && refund_total && id) {
        $.ajax({
            type: "POST",
            url: "/admin/orders/refund_update",
            data: {arr: arr, textarea: textarea, refund_total: refund_total, id: id},
            dataType: 'html',
            success: function (response) {
                location.reload();
            }
        });
    }
});

function return_calculation() {
    var check = $('.refund_table').find("input:checked"),
        all_total = parseFloat($('#all_total').text().substring(1)),
        summ = 0;

    for (var i = 0; i < check.length; i++) {
        summ += chech_true(check.eq(i).data('id'));
    }

    if (summ > 0) {
        summ = all_total;
    }

    total_refund(summ);
}

function chech_true(id) {
    var refund_persent = $('.refund_table').find('#refund_persent[data-id="' + id + '"]'),
        refund_dollar = $('.refund_table').find('#refund_dollar[data-id="' + id + '"]'),
        total = refund_persent.data('total');

    refund_persent.prop('disabled', false);
    refund_persent.val('100');
    $('[data-id_return="' + id + '"]').html('$' + total.toFixed(2));
    refund_dollar.prop('disabled', false);

    return total;
}

function chech_true_per(id, per) {
    var refund_persent = $('.refund_table').find('#refund_persent[data-id="' + id + '"]'),
        refund_dollar = $('.refund_table').find('#refund_dollar[data-id="' + id + '"]'),
        refund_total = parseFloat($('#refund_total').text()),
        tip = parseFloat($('#all_tip').text().substring(1)),
        total = refund_persent.data('total'),
        back_total = parseFloat($('[data-id_return="' + id + '"]').text().substring(1)),
        per_total = parseFloat((total * per / 100).toFixed(2));

    refund_total = tip_minus(refund_total, tip);

    refund_total -= back_total;
    refund_total += per_total;

    refund_total = tip_plus(refund_total, tip);

    $('[data-id_return="' + id + '"]').html('$' + per_total.toFixed(2));
    refund_persent.data('per_total');
    refund_dollar.val('');

    total_refund(refund_total);
}

function chech_true_dol(id, dol) {
    var refund_persent = $('.refund_table').find('#refund_persent[data-id="' + id + '"]'),
        refund_dollar = $('.refund_table').find('#refund_dollar[data-id="' + id + '"]'),
        tip = parseFloat($('#all_tip').text().substring(1)),
        refund_total = parseFloat($('#refund_total').text()),
        back_total = parseFloat($('[data-id_return="' + id + '"]').text().substring(1));

    refund_total = tip_minus(refund_total, tip);

    refund_total -= back_total;
    refund_total += dol;

    refund_total = tip_plus(refund_total, tip);

    $('[data-id_return="' + id + '"]').html('$' + dol.toFixed(2));
    refund_persent.val('');
    refund_dollar.val(dol);

    total_refund(refund_total);
}

function chech_false(id) {
    var refund_persent = $('.refund_table').find('#refund_persent[data-id="' + id + '"]'),
        refund_dollar = $('.refund_table').find('#refund_dollar[data-id="' + id + '"]'),
        total = parseFloat($('[data-id_return="' + id + '"]').text().substring(1));

    refund_persent.prop('disabled', true);
    refund_persent.val('');
    $('[data-id_return="' + id + '"]').html(' ');

    refund_dollar.prop('disabled', true);
    refund_dollar.val('');

    return total;
}

function tip_minus(refund_total, tip) {
    var total = parseFloat(refund_total),
        tips = parseFloat(tip);

    if (total - tips >= tips) {
        total -= tips;
    } else if (total - tips < tips) {
        total = total / 2;
    }

    return total;
}

function tip_plus(refund_total, tip) {
    if (refund_total >= tip) {
        refund_total += tip;
    } else {
        refund_total = refund_total * 2;
    }

    return refund_total;
}

function total_refund(refund_tot) {
    var all_total = parseFloat($('#all_total').text().substring(1)),
        refund_total_ = parseFloat(refund_tot);

    if (all_total < refund_total_) $('#refund_total').text(all_total.toFixed(2));
    else $('#refund_total').text(refund_total_.toFixed(2));
}

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
                } else {
                    element.val(lastValue);
                }
            }
        }, 10);
    }
}

function setValidatorCol(element) {
    var mass = element.split('.'),
        count = mass.length - 1;

    if (count > 1) {
        return element.substring(0, element.length - 1);
    } else {
        if (count == 1) {
            if (mass[1].length > 2) {
                return element.substring(0, element.length - 1);
            } else {
                return element;
            }
        } else {
            return element;
        }
    }
}
