// Добавляем свой текст сообщения об ошибке
var commentArea = document.querySelector('#comment');
commentArea.addEventListener('invalid', function (e) {
    e.target.setCustomValidity('');
    if (!e.target.validity.valid) {
        e.target.setCustomValidity('Пожалуйста, введите отзыв.');
    }
});
var nameInput = document.querySelector('#name');
nameInput.addEventListener('invalid', function (e) {
    e.target.setCustomValidity('');
    if (!e.target.validity.valid) {
        e.target.setCustomValidity('Пожалуйста, введите Ваше имя.');
    }
});

// auto-expand the textarea
var textareaInput = document.querySelector("textarea");
textareaInput.addEventListener("keydown", autosize);

function autosize() {
    var el = this;
    setTimeout(function () {
        el.style.cssText = "height:auto; padding:0";
        el.style.cssText = "height:' + el.scrollHeight + 'px";
    }, 0);
};

var error = document.querySelector("#feedback");

function ValidInput(Input) {
    var re = /^[а-яА-ЯёЁ\.\,]+$/i;
    var valid = re.test(Input);
    if (valid) output = '';
    else output = 'Пишите русским языком.';
    error.textContent = output;
    return valid;
}
nameInput.addEventListener('input', function() {
    var InputName = document.getElementById('name').value;
    ValidInput(InputName)
});
commentArea.addEventListener('input', function() {
    var InputComment = document.getElementById("comment").value;
    ValidInput(InputComment)
});

var button = document.getElementById("button");
button.addEventListener("click", function (e) {
    error.style.color = "";
    button.style.borderColor = "";
    var name = document.getElementById("name").value.replace(/<[^>]+>/g, ""),
        comment = document.getElementById("comment").value.replace(/<[^>]+>/g, "");

    if (name === "" || comment === "") {
        error.textContent = "Не все поля заполнены. Попробуйте ещё раз.";
        return false;
    }

    if (name.search(/^[а-яА-ЯёЁ\.\,]+$/i) === -1 || comment.search(/^[а-яА-ЯёЁ\.\,]+$/i) === -1) {
        error.textContent = "Пишите пожалуйста русским языком.";
        e.preventDefault();
        return false;
   }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "src/add_comment.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.onerror = function () {
        error.textContent = "There was an error posting the comment. Please try again.";
    };
    xmlhttp.upload.onprogress = function (e) {
        error.textContent = "Uploading: " + e.loaded / e.total * 100;
    };
    xmlhttp.send("&name=" + encodeURIComponent(name) + "&comment=" + encodeURIComponent(comment));
    xmlhttp.upload.onloadend = function () {
        error.style.color = "#02a01d";
        error.textContent = "Ваш отзыв принят.";
        button.style.borderColor = "#02a01d";
    };
    e.preventDefault();
});
