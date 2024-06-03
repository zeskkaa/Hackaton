const form = document.querySelector('.task_add'); // Получили форму добавления со страницы
const btn = document.querySelector('.open_form'); // Получили кнопку добавить задание
let hidden = true; // Переменная для проверки, скрыта ли форма

btn.addEventListener('click', () => { // При нажатии на кнопку
    hidden = !hidden; // Переворачиваем значение с true на false, или если изначально она false, то на true
    form.style.display = hidden ? "none" : "flex"; // Тоже самое что if (hidden == true), тогда display: none, иначе display: flex;
    btn.innerHTML = hidden ? "Добавить задание" : "Закрыть форму"; // Тоже самое что if (hidden == true), тогда текст кнопки будет "Добавить задание", иначе "Закрыть форму"

    // Сбросить все поля формы, если скрываем форму
    if (hidden) {
        form.reset();
    }
});