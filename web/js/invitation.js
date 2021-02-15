$('body').on('click', '#add', function (e) {
    var mas = $('[name="variations"]').val(),
        id = document.getElementById('tr_add').dataset.id,
        email = $('[name="email"]').val(),
        role = $('[name="role"]').val(),
        language = $('[name="language"]').val(),
        lang_default = document.getElementById('lang').value;

    if (mas){
        mas = JSON.parse(mas);
    }else{
        mas = [];
    }

    if (validateEmail(email)==false){email='';}

    if (email){
        if (JSON.stringify(mas).indexOf(email)>0){
            email = '';
            $('[name="email"]').css({'border':'1px solid red'});
        }else {
            $('[name="email"]').css({'border': 'unset'});
        }
    }else{
        $('[name="email"]').css({'border':'1px solid red'});
    }
    if (role){
        $('[name="role"]').css({'border':'unset'});
    }else{
        $('[name="role"]').css({'border':'1px solid red'});
    }

    if (id!=''&&id>=0&&email && role){
        mas[id] = {};
        mas[id].email = email;
        mas[id].role = role;
        mas[id].language = language;

        $('[name="email"]').val('');
        $('[name="role"]').val('');
        $('[name="language"]').val(lang_default);
        document.getElementById('tr_add').dataset.id = '';
    }else {
        if (email && role) {
            var arr = {};
            arr['email'] = email;
            arr['role'] = role;
            arr['language'] = language;

            mas.push(arr);
            $('[name="email"]').val('');
            $('[name="role"]').val('');
            $('[name="language"]').val(lang_default);
        }
    }

    $('[name="variations"]').val(JSON.stringify(mas));
    $('#variations').html(message(mas));
});

$('body').on('click', '#remove', function (e) {
    var mas = JSON.parse($('[name="variations"]').val()) || [],
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
        $('[name="variations"]').val(JSON.stringify(arr));
    }else{
        $('[name="variations"]').val('');
    }
    $('#variations').html(message(arr));

});

$('body').on('click', '#edit', function (e) {
    var id = $(this).data('id'),
        mas = JSON.parse($('[name="variations"]').val()) || [];

    $('#edit_mass').val(JSON.stringify(mas[id]));
    document.getElementById('tr_add').dataset.id = id;

    $('[name="email"]').val(mas[id].email);
    $('[name="role"]').val(mas[id].role);
    $('[name="language"]').val(mas[id].language);

    mas.splice(id, 1);
    $('[name="variations"]').val(JSON.stringify(mas));
    $('#variations').html(message(mas));
});

function message(mas) {
    var mess = '',
        edit = document.getElementById('edit').value,
        remove = document.getElementById('remove').value;
    for (var i=0;i<mas.length;i++){
        mess += '<tr>';
        mess += '  <td>'+mas[i].email+'</td>';
        mess += '  <td>'+mas[i].role+'</td>';
        mess += '  <td>'+mas[i].language+'</td>';
        mess += "  <td><button type='button' class=\"btn btn-primary\" style='padding: 5px 10px; margin-top: 10px;margin-right: 10px;' id='edit' data-id='"+i+"'>"+edit+"</button>" +
            "<button type='button' class=\"btn btn-primary\" style='padding: 5px 10px; margin-top: 10px;' id='remove' data-id='"+i+"'>"+remove+"</button></td>";
        mess += '</tr>';
    }
    return mess;
}

function validateEmail(email) {
    var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    return re.test(String(email).toLowerCase());
}