import { CookieService } from "../Services/CookieService.js"
import { UpdateHeaderLoginHelper } from "../Helpers/UpdateHeaderLoginHelper.js"
import { APIService } from "../Services/APIService.js";


window.onload = function onLoad() {
    UpdatePage();
}
window.OnLogin = OnLogin;
function OnLogin(args) {
    args.preventDefault();
    let login = args.target.elements.login.value;
    CookieService.setCookie('login', login, 5);
    UpdatePage();
}

window.OnLogout = OnLogout;
function OnLogout() {
    CookieService.setCookie('login', "", 5);
    UpdatePage();
}

window.OnPurchase = OnPurchase;
function OnPurchase(productId) {
    APIService.Purchase(CookieService.getCookie('login'), productId)
        .finally((res) => {
            UpdatePage();
        });
}

function RenderProduct(product, isPurchased) {
    let productsContainer = document.getElementById("products-container");
    let discountString = product.description.substr(0, product.description.indexOf('%') + 1);
    let desc = product.description.substr(product.description.indexOf('%') + 1, product.description.length);
    let price = product.price;
    let button;

    if (!isPurchased) {
        button = `
    <button onClick="OnPurchase(${product.id})" class="purchase-button" style="width: 135px;
        height: 49px;">Использовать скидку</button>
        `
    }
    else {
        button = `
    <button disabled class="already-purchased-button" style="width: 135px;
        height: 49px;">Уже использовано</button>
        `
    }

    productsContainer.innerHTML += `
        <div class="product-card">
            <div>
                <img class="product-price-coin" src="frontend/Assets/images/coin.png">
                <span class="product-price-font">${price}</span>
                <img class="product-price-currency-glyph" src="frontend/Assets/images/Tugriki.svg">
            </div>
            <img class="product-icon" src="frontend/Assets/images/call_x2.svg">
            <div>
                <div class="discount">${discountString}</div>
                <span class="product-name-font">${desc}</span>
            </div>
            ${button}
        </div>
        `;

}

function UpdatePage() {
    let userInfoPromise = UpdateHeaderLoginHelper();

    if (userInfoPromise) {
        userInfoPromise.then((userInfo) => {
            document.getElementById("balance-container").innerHTML = userInfo.user.balance;
        })
    }
    else {
        document.getElementById("balance-container").innerHTML = "0"
    }

    let productsContainer = document.getElementById("products-container");
    productsContainer.innerHTML = "";
    APIService.GetProducts()
        .then((products) => {
            if (userInfoPromise) {
                userInfoPromise.then((userInfo) => {
                    products.forEach(product => {
                        RenderProduct(product, userInfo.user.purchasedProducts.includes(product.id));
                    });
                })
            }
            else {
                products.forEach(product => {
                    RenderProduct(product, false);
                });
            }
        })
}