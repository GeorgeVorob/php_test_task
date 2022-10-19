export class APIService {
    static GetUser(login) {
        return fetch("backend/EndPoints/GetUserInfo.php?login=" + login)
            .then((res) => {
                if (res.ok) {
                    return res.json();
                }
                else {
                    throw new Error("Invalid user fetch request!");
                }
            })
    }
    static GetProducts() {
        return fetch("backend/EndPoints/GetProductsInfo.php")
            .then((res) => {
                if (res.ok) {
                    return res.json();
                }
                else {
                    throw new Error();
                }
            })
    }
}