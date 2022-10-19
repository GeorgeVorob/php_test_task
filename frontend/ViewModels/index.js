import { CookieService } from "../Services/CookieService.js"
import { UpdateHeaderLoginHelper } from "../Helpers/UpdateHeaderLoginHelper.js"

window.onload = function onLoad() {
    UpdateHeaderLoginHelper();
}
window.OnLogin = OnLogin;
function OnLogin(args) {
    args.preventDefault();
    let login = args.target.elements.login.value;
    CookieService.setCookie('login', login, 5);
    UpdateHeaderLoginHelper();
}

window.OnLogout = OnLogout;
function OnLogout() {
    CookieService.setCookie('login', "", 5);
    UpdateHeaderLoginHelper();
}