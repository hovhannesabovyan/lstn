$('body').on('change', '[name="product_id"]', function (e) {
    var id = $(this).val();

    getAmount(id);
});

$('body').on('change', '#all_tip_per', function (e) {
    calculate();
});

$('body').on('click', '#add', function (e) {
    var mas = $('[name="variations"]').val(),
        items = JSON.parse(document.getElementById('items').value),
        variations = JSON.parse(document.getElementById('variations_').value),
        y = 0,
        tax = JSON.parse(document.getElementById('tax').value),
        id = document.getElementById('tr_add').dataset.id,
        product_id = $('[name="product_id"]').val(),
        variation_id = $('[name="variation_id"]').val(),
        qty = $('[name="qty"]').val();

    if (mas) {
        mas = JSON.parse(mas);
    } else {
        mas = [];
    }

    if (product_id) {
        $('[name="product_id"]').css({'border': 'unset'});
    } else {
        $('[name="product_id"]').css({'border': '1px solid red'});
    }
    if (qty) {
        $('[name="qty"]').css({'border': 'unset'});
    } else {
        $('[name="qty"]').css({'border': '1px solid red'});
    }
    if (variation_id) {
        $('[name="variation_id"]').css({'border': 'unset'});
    } else {
        $('[name="variation_id"]').css({'border': '1px solid red'});
    }
    if (product_id && variation_id && qty) {
        $.each(variations, function (key, value) {
            if (value.item_id == product_id) y++;
        });
        if (id != '' && id >= 0) {
            mas[id].name = items[product_id].name;
            mas[id].tax_id = items[product_id].tax_ids;
            mas[id].percentage = tax[items[product_id].tax_ids].percentage;
            mas[id].qty = qty;
            mas[id].amount = variations[variation_id].amount;
            mas[id].variation_id = variation_id;
            if (y > 1) mas[id].variation_name = variations[variation_id].name;
            else mas[id].variation_name = '';

            document.getElementById('tr_add').dataset.id = '';
            $('[name="product_id"]').val('');
            $('[name="variation_id"]').val('');
            $('[name="qty"]').val('');
        } else {
            var arr = {};
            arr['order_id'] = document.getElementById('id_order').value;
            arr['product_id'] = product_id;
            arr['name'] = items[product_id].name;
            arr['tax_id'] = items[product_id].tax_ids;
            arr['percentage'] = tax[items[product_id].tax_ids].percentage;
            arr['qty'] = qty;
            arr['amount'] = variations[variation_id].amount;
            arr['variation_id'] = variation_id;
            if (y > 1) arr['variation_name'] = variations[variation_id].name;
            else arr['variation_name'] = '';

            mas.push(arr);
            $('[name="product_id"]').val('');
            $('[name="variation_id"]').val('');
            $('[name="qty"]').val('');
        }

        $('button[class="btn btn-success"]').prop('disabled', false);
        $('[name="variations"]').val(JSON.stringify(mas));
        $('#variations').html(message(mas));
        calculate();
    }
});

$('body').on('click', '#remove', function (e) {
    var mas = JSON.parse($('[name="variations"]').val()) || [],
        arr = [],
        y = 0,
        id = $(this).data('id');

    if (mas.length > 0) {
        for (var i = 0; i < mas.length; i++) {
            if (i != id) {
                arr[y] = mas[i];
                y++;
            }
        }
    }

    if (arr.length > 0) {
        $('[name="variations"]').val(JSON.stringify(arr));
    } else {
        $('[name="variations"]').val('');
        $('button[class="btn btn-success"]').prop('disabled', true);
    }
    $('#variations').html(message(arr));
    calculate();
});

$('body').on('click', 'button', function (e) {
    var order = {},
        order_variations = {},
        mas = $('[name="variations"]').val();

    if (mas) {
        mas = JSON.parse(mas);
    } else {
        mas = [];
    }

    order['id'] = document.getElementById('id_order').value;
    order['phone'] = document.getElementById('phone').value;
    order['status'] = $('[name="status"]').val();
    order['tip_per'] = parseFloat(document.getElementById('all_tip_per').innerText);
    order['tip_summ'] = parseFloat(document.getElementById('all_tip').innerText) * 100;
    order['count'] = parseFloat(document.getElementById('all_count').innerText);
    order['subtotal'] = parseFloat(document.getElementById('all_subtotal').innerText) * 100;
    order['tax'] = parseFloat(document.getElementById('all_tax').innerText) * 100;
    order['fees'] = parseFloat(document.getElementById('all_fees').innerText) * 100;
    order['total'] = parseFloat(document.getElementById('all_total').innerText) * 100;

    order_variations = mas;
    if (mas.length > 0) {
        $.ajax({
            type: "POST",
            url: "/admin/orders/update_order",
            data: {order: order, order_variations: order_variations},
            dataType: 'html',
            success: function (response) {
            }
        });
    }
});

$('body').on('click', '#edit', function (e) {
    var id = $(this).data('id'),
        product_id = $(this).data('id_prod'),
        variation_id = $(this).data('id_var'),
        mas = JSON.parse($('[name="variations"]').val()) || [];

    $('#edit_mass').val(JSON.stringify(mas[id]));
    document.getElementById('tr_add').dataset.id = id;
    getAmount(product_id);
    $('[name="product_id"]').val(product_id);
    $('[name="variation_id"]').val(variation_id);
    $('[name="qty"]').val(mas[id].qty);

    mas.splice(id, 1);
    if (mas.length == 0) {
        $('button[class="btn btn-success"]').prop('disabled', true);
    }
    $('#variations').html(message(mas));
});

var mas = $('[name="variations"]').val();

if (mas) {
    mas = JSON.parse(mas);
} else {
    mas = [];
}

if (mas.length > 0) {
    $('#variations').html(message(mas));
} else {
    $('button[class="btn btn-success"]').prop('disabled', true);
}

function message(mas) {
    var mess = '';
    for (var i = 0; i < mas.length; i++) {
        mess += '<tr>';
        mess += '  <td>' + mas[i].name + '</td>';
        mess += '  <td>' + mas[i].qty + '</td>';
        mess += '  <td>' + mas[i].amount / 100 + '</td>';
        mess += "  <td><button type='button' style='padding: 5px 10px; margin-top: 10px;margin-right: 10px;' " +
            "id='edit' data-id_prod='" + mas[i].product_id + "' data-id_var='" + mas[i].variation_id + "' data-id='" + i + "'>Edit</button>" +
            "<button type='button' style='padding: 5px 10px; margin-top: 10px;' id='remove' data-id='" + i + "'>Remove</button></td>";
        mess += '</tr>';
    }
    return mess;
}

function getAmount(id) {
    if (id) {
        $.ajax({
            type: "POST",
            url: "/admin/orders/amount",
            data: {id: id},
            dataType: 'html',
            success: function (response) {
                if (response) {
                    var arr = JSON.parse(response),
                        mess = '';
                    for (var i = 0; i < arr.length; i++) {
                        mess += '<option value="' + arr[i].id + '">' + arr[i].amount / 100 + '</option>';
                    }

                    $('[name="variation_id"]').html(mess);
                }
            }
        });
    } else {
        $('[name="variation_id"]').html('');
    }
}

function calculate() {
    var mas = $('[name="variations"]').val(),
        tip_per = document.getElementById('all_tip_per').value,
        all_tip = 0,
        subtotal = 0,
        count = 0,
        tax = 0,
        fees = 0,
        total = 0,
        arr = {};

    if (mas) {
        mas = JSON.parse(mas);
    } else {
        mas = [];
    }

    if (mas.length > 0) {
        for (var i = 0; i < mas.length; i++) {
            if (typeof (arr[mas[i].percentage]) === 'undefined') arr[mas[i].percentage] = mas[i].amount * mas[i].qty;
            else arr[mas[i].percentage] += mas[i].amount * mas[i].qty;
            subtotal += parseInt(mas[i].amount) * parseInt(mas[i].qty);
            count += parseInt(mas[i].qty);
        }

        $.each(arr, function (key, value) {
            tax += parseInt(value) * parseFloat(key) / 100;
        });

        tax = parseFloat(tax.toFixed(0));

        all_tip = subtotal * tip_per / 100;
        fees = subtotal * 5 / 100;

        total = subtotal + all_tip + fees + tax;

        document.getElementById('all_count').innerText = count;
        document.getElementById('all_subtotal').innerText = subtotal / 100;
        document.getElementById('all_tip').innerText = all_tip / 100;
        document.getElementById('all_tax').innerText = tax / 100;
        document.getElementById('all_fees').innerText = fees / 100;
        document.getElementById('all_total').innerText = total / 100;
    } else {
        document.getElementById('all_count').innerText = 0;
        document.getElementById('all_subtotal').innerText = 0;
        document.getElementById('all_tip').innerText = 0;
        document.getElementById('all_tax').innerText = 0;
        document.getElementById('all_fees').innerText = 0;
        document.getElementById('all_total').innerText = 0;
    }
}
