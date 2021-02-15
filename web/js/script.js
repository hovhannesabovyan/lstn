$(function() {

    $('body').on('change', '#login_reset', function (e) {
        if ($(this).val()){
            $('#email_reset').prop("disabled", true);
        }else{
            $('#email_reset').prop('disabled', false);
            $(this).parent().parent().find('.col-lg-8').css({'display':'none'});
        }
    });

    $('body').on('change', '#email_reset', function (e) {
        if ($(this).val()){
            $('#login_reset').prop('disabled', true);
        }else{
            $('#login_reset').prop('disabled', false);
            $(this).parent().parent().find('.col-lg-8').css({'display':'none'});
        }
    });

    //$("#modal_quantity, #quantity").keydown(function(event) {
    $('body').on('keydown','#modal_quantity, #quantity', function (event) {
        // Разрешаем: backspace, delete, tab и escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
            // Разрешаем: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            // Разрешаем: home, end, влево, вправо
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // Ничего не делаем
            return;
        } else {
            // Запрещаем все, кроме цифр на основной клавиатуре, а так же Num-клавиатуре
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });

    $('body').on('keydown','#phone', function (event) {
        // Разрешаем: backspace, delete, tab и escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
            // Разрешаем: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
            //Разрешаем: +, пробел
            event.keyCode == 107 || event.keyCode == 187 || event.keyCode == 32 ||
            // Разрешаем: home, end, влево, вправо
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // Ничего не делаем
            return;
        } else {
            // Запрещаем все, кроме цифр на основной клавиатуре, а так же Num-клавиатуре
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });

});