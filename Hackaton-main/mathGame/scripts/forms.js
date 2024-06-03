// Функция проверки полей
function checkCorrect() {
    // Объединяем все поля в массив [поле1, поле2, поле3 и т.д.]
    const fields = document.querySelectorAll('.field');

    // Проходимся по массиву (как в питоне for i in array)
    fields.forEach((elem) => {
        // Если в поле что-то написано
        if (elem.value.length > 0) {
            // Если поле почты
            if (elem.getAttribute('type') == 'email') {
                // Если там есть символ '@'
                if (elem.value.includes('@')) {
                    // Если после собаки есть символы и символ '.'
                    if (elem.value.split('@')[1].length > 0 && elem.value.split('@')[1].includes('.')) {
                        // Если после точки есть символы и количество символов больше 0
                        if (elem.value.split('@')[1].split('.').length >= 2 && elem.value.split('@')[1].split('.')[1].length > 0) {
                            // Делаем зеленую обводку полю
                            elem.style.borderBottom = "2px solid #47db9b";
                        } else {
                            // Делаем красную обводку полю
                            elem.style.borderBottom = "2px solid #db4747";
                        }
                    } else { // Иначе, если если после собаки нет символов и символа '.'
                        // Делаем красную обводку полю
                        elem.style.borderBottom = "2px solid #db4747";
                    }
                } else { // Иначе, если собаки нет
                    // Делаем красную обводку полю
                    elem.style.borderBottom = "2px solid #db4747";
                }
            } else if (elem.getAttribute('type') != 'password') { // Если любой другой тип, кроме пароля и почты
                if (elem.value.length > 0) { // Если что-то написано
                    // Делаем зеленую обводку полю
                    elem.style.borderBottom = "2px solid #47db9b";
                } else { // Иначе, если ничего не написано
                    // Делаем красную обводку полю
                    elem.style.borderBottom = "2px solid #db4747";
                }
            }
        } else if (elem.value.length <= 0) { // Если ничего не написано
            elem.style.borderBottom = "2px solid #4768DB";
        }
    });
}

// Функция отключения кнопки, если не все заполнено
function changeDisabled() {
    const submitBtn = document.getElementById('register_btn'); // кнопка отправки формы

    const nameInput = document.getElementById('name_input').value; // Значение поля имени
    const loginInput = document.getElementById('login_input').value; // Значение поля логина
    const mailInput = document.getElementById('mail_input').value; // Значение поля почты
    const passwordInput = document.getElementById('password_input').value; // Значение поля пароля 
    const confirmPasswordInput = document.getElementById('confirm_password_input').value; // Значение поля подтверждения пароля

    // Проверка на то, что все заполнено
    if (nameInput.length > 0 && loginInput.length > 0 && mailInput.length > 0 && passwordInput.length > 0 && confirmPasswordInput.length > 0) {
        // Проверка на совпадение паролей
        if (passwordInput == confirmPasswordInput) {
            // Включение кнопки и изменение обводок полей паролей
            submitBtn.disabled = false;
            document.getElementById('confirm_password_input').style.borderBottom = "2px solid #47db9b";
            submitBtn.style.backgroundColor = "#4767dbe2";
        } else {
            // Отключение кнопки и изменение обводок полей паролей
            submitBtn.disabled = true;
            document.getElementById('confirm_password_input').style.borderBottom = "2px solid #db4747";
            submitBtn.style.backgroundColor = "#8998cee2";
        }
    } else { // Если что-то не заполнено
        // Меняем цвет кнопки
        submitBtn.style.backgroundColor = "#8998cee2";
        // Проверка на совпадение паролей
        if (passwordInput == confirmPasswordInput) {
            if (passwordInput.length > 0 && confirmPasswordInput.length > 0) {
                // Меняем обводку поля пароля
                document.getElementById('confirm_password_input').style.borderBottom = "2px solid #47db9b";
            }
        } else {
            if (passwordInput.length > 0 && confirmPasswordInput.length > 0) {
                // Меняем обводку поля пароля
                document.getElementById('confirm_password_input').style.borderBottom = "2px solid #db4747";
            }
        }
    }
}

// При загрузке страницы вызов функции
document.addEventListener('DOMContentLoaded', function() {
    changeDisabled();
});