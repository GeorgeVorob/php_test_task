import { CookieService } from "../Services/CookieService.js"
import { APIService } from "../Services/APIService.js";

// Хранит логику обновления "шапки" сайта. Возможно, в рамказ ТЗ стоило вынести в index.js.
export function UpdateHeaderLoginHelper() {
    let login = CookieService.getCookie('login')
    if (login != "") {
        return APIService.GetUser(login)
            .then((json) => {
                document.getElementById("login-error-label").innerHTML = "";
                document
                    .getElementById("login-form")
                    .setAttribute("style", "display:none");
                document
                    .getElementById("logged-in-pane")
                    .setAttribute("style", "display:block");
                document
                    .getElementById("you-logged-as-label")
                    .innerHTML = "Вы вошли как " + json.user.login;

                CookieService.setCookie("login", json.user.login, 5);

                return json;
            })
            .catch((err) => {
                CookieService.setCookie("login", "");
                document.getElementById("login-error-label").innerHTML = "Неверный логин!";
            });
    }
    else {
        document
            .getElementById("logged-in-pane")
            .setAttribute("style", "display:none");

        document
            .getElementById("login-form")
            .setAttribute("style", "display:block");

        return null;
    }
}