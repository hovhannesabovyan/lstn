$('body').on('click', '#del_img', function (e) {
    var id = $(this).data('id');

    $.ajax({
        type: "POST",
        url: "/admin/items/deleteimage",
        data: {id: id},
        dataType: 'html',
        success: function (response) {
            $('#image').html('');
        }
    });
});

$('body').on('click', '#add', function (e) {
    var mas = $('[name="variations"]').val(),
        id = document.getElementById('tr_add').dataset.id,
        name = $('[name="name"]').val(),
        amount = $('[name="amount"]').val(),
        square_id = $('#square_id').val();

    if (mas) {
        mas = JSON.parse(mas);
    } else {
        mas = [];
    }

    if (name) {
        $('[name="name"]').css({'border': 'unset'});
    } else {
        $('[name="name"]').css({'border': '1px solid red'});
    }
    if (amount) {
        $('[name="amount"]').css({'border': 'unset'});
    } else {
        $('[name="amount"]').css({'border': '1px solid red'});
    }

    if (id != '' && id >= 0) {
        mas[id].square_id = square_id;
        mas[id].name = name;
        mas[id].amount = amount * 100;
        mas[id].is_deleted = $('[name="is_deleted"]').val();

        document.getElementById('tr_add').dataset.id = '';
        $('[name="name"]').val('');
        $('[name="amount"]').val('');
        $('[name="square_id"]').val('');
        $('[name="is_deleted"]').val('0');
    } else {
        if (name && amount) {
            var arr = {};
            arr['square_id'] = square_id;
            arr['name'] = name;
            arr['amount'] = amount * 100;
            arr['is_deleted'] = $('[name="is_deleted"]').val();

            mas.push(arr);
            $('[name="name"]').val('');
            $('[name="amount"]').val('');
            $('[name="square_id"]').val('');
            $('[name="is_deleted"]').val('0');
        }
    }

    if (JSON.stringify(mas).indexOf('"is_deleted":"0"') > 0) {
        $('button[class="btn btn-success"]').prop('disabled', false);
    }
    $('[name="variations"]').val(JSON.stringify(mas));
    $('#variations').html(message(mas));
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
        if (JSON.stringify(arr).indexOf('"is_deleted":"0"') < 0) {
            $('button[class="btn btn-success"]').prop('disabled', true);
        }
    } else {
        $('[name="variations"]').val('');
        $('button[class="btn btn-success"]').prop('disabled', true);
    }
    $('#variations').html(message(arr));

});

$('body').on('click', '#edit', function (e) {
    var id = $(this).data('id'),
        mas = JSON.parse($('[name="variations"]').val()) || [];

    $('#edit_mass').val(JSON.stringify(mas[id]));
    document.getElementById('tr_add').dataset.id = id;

    $('[name="name"]').val(mas[id].name);
    $('[name="amount"]').val(mas[id].amount / 100);
    $('[name="square_id"]').val(mas[id].square_id);
    $('[name="is_deleted"]').val(mas[id].is_deleted);

    mas.splice(id, 1);
    if (mas.length == 0 || JSON.stringify(mas).indexOf('"is_deleted":"0"') < 0) {
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
    var mess = '', is_deleted = '';
    for (var i = 0; i < mas.length; i++) {
        if (mas[i].is_deleted == 1) is_deleted = 'No'; else is_deleted = 'Yes';
        mess += '<tr>';
        mess += '  <td>' + mas[i].square_id + '</td>';
        mess += '  <td>' + mas[i].name + '</td>';
        mess += '  <td>' + mas[i].amount / 100 + '</td>';
        mess += '  <td>' + is_deleted + '</td>';
        mess += "  <td><button type='button' style='padding: 5px 10px; margin-top: 10px;margin-right: 10px;' id='edit' data-id='" + i + "'>Edit</button>" +
            "<button type='button' style='padding: 5px 10px; margin-top: 10px;' id='remove' data-id='" + i + "'>Remove</button></td>";
        mess += '</tr>';
    }
    return mess;
}
