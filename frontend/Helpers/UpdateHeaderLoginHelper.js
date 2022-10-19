import { CookieService } from "../Services/CookieService.js"

export function UpdateHeaderLoginHelper() {
    let login = CookieService.getCookie('login')
    if (login != "") {
        fetch("backend/EndPoints/GetUserInfo.php?login=" + login)
            .then((res) => {
                if (res.ok) {
                    document.getElementById("login-error-label").innerHTML = "";
                    return res.json();
                }
                else {
                    CookieService.setCookie("login", "");
                    document.getElementById("login-error-label").innerHTML = "Неверный логин!";
                    throw new Error("Invalid user fetch request!");
                }
            })
            .then((json) => {
                console.log(json)

                document
                    .getElementById("login-form")
                    .setAttribute("style", "display:none");
                document
                    .getElementById("logged-in-pane")
                    .setAttribute("style", "display:block");

                document
                    .getElementById("you-logged-as-label")
                    .innerHTML = "Вы вошли как " + json.login;
                CookieService.setCookie("login", json.login, 5);
            });
    }
    else {
        document
            .getElementById("logged-in-pane")
            .setAttribute("style", "display:none");

        document
            .getElementById("login-form")
            .setAttribute("style", "display:block");
    }
}