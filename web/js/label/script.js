compilations_label_f($('#label_form-compilations_label').val())

$('body').on('change', '[name="Label_form[logo]"]', function(e) {
    var val = $(this).val();
    if (val){
        val = val.replace('fakepath','');
        val = val.replace("C:",'');
    }
    $('.file-return').html(val.slice(2));
});

$('body').on('change', '#label_form-compilations_label', function(e) {
    compilations_label_f($(this).val())
});

function compilations_label_f(val) {
    if (val=='yes') $('.field-label_form-parent_label').css({'display':'block'})
    else $('.field-label_form-parent_label').css({'display':'none'})
}

$('#w0').submit(function (e) {
    var genre = $('#label_form-genre').val();

    if (genre) document.getElementById('genre_error').style.display = 'none';
    else document.getElementById('genre_error').style.display = 'block';
});

$('body').on('click', '#del_img', function (e) {
    var id = $(this).data('id');

    $.ajax({
        type: "POST",
        url: "/label/deleteimage",
        data: {id:id},
        dataType: 'html',
        success: function(response) {
            $('#image').html('');
        }
    });
});

$('body').on('click', '#add_genre', function(e) {
    var add = $('#genre').val(),
        id = document.getElementById('genre').dataset.id,
        genre = $('#label_form-genre').val();

    if (genre) var mas_genre = JSON.parse(genre);
    else var mas_genre = [];

    if (add) {
        if (id != '' && id >= 0) {
            mas_genre[id] = add;
            document.getElementById('genre').dataset.id = '';
        } else {
            if (mas_genre) {
                if (mas_genre.length <= 2) mas_genre.push(add);
                else document.getElementById('mass_genre_error').style.display = 'block';
            } else {
                mas_genre[0] = add;
            }
        }

        document.getElementById('genre_error').style.display = 'none';
        $('#genre').val('');
        $('#genre_table').html(message(mas_genre));
        $('#label_form-genre').val(JSON.stringify(mas_genre));
    }
});

$('body').on('click', '#remove', function (e) {
    var mas = JSON.parse($('#label_form-genre').val()) || [],
        arr = [],
        y = 0,
        id = $(this).data('id');

    if (mas.length>0){
        for (var i=0;i<mas.length;i++){
            if (i!=id){
                arr[y] = mas[i];
                y++;
            }
        }
    }

    if (arr.length>0){
        $('#label_form-genre').val(JSON.stringify(arr));
    }else{
        $('#label_form-genre').val('');
    }
    $('#genre_table').html(message(arr));

});

$('body').on('click', '#edit', function (e) {
    var id = $(this).data('id'),
        mas = JSON.parse($('#label_form-genre').val()) || [];

    $('#edit_mass').val(JSON.stringify(mas[id]));
    document.getElementById('genre').dataset.id = id;

    $('#genre').val(mas[id]);

    mas.splice(id, 1);
    $('#genre').focus();
    $('#genre_table').html(message(mas));
});

function message(mas) {
    var mess = '';
    for (var i=0;i<mas.length;i++){
        mess += '<tr>';
        mess += '  <td>'+mas[i]+'</td>';
        mess += "  <td><button type='button' class='btn' id='edit' data-id='"+i+"'>Edit</button>" +
            "<button type='button' class='btn' id='remove' data-id='"+i+"'>Remove</button></td>";
        mess += '</tr>';
    }
    return mess;
}

var mas = $('#label_form-genre').val();

if (mas){
    mas = JSON.parse(mas);
}else{
    mas = [];
}

if (mas.length>0){
    $('#genre_table').html(message(mas));
}