export function isLoggedIn() {
    return localStorage.getItem("isLoggedIn") == 'true';
}

export function logIn() {
    localStorage.setItem("isLoggedIn", true);
}
export function loginAdmin() {
    localStorage.setItem("isAdmin", true);
}
export function isloginAdmin() {
    return localStorage.getItem("isAdmin") == 'true';
}

export function logOut() {
    localStorage.setItem("isLoggedIn", false);
    localStorage.removeItem("current_user");
}
export function logOutAdmin() {
    localStorage.setItem("isAdmin", false);
    localStorage.setItem("isLoggedIn", false);
    localStorage.removeItem("admin_user");
}
export function userRole() {
    if (localStorage.getItem("current_user")) {
        return JSON.parse(localStorage.getItem("current_user")).user.role;
    } else {
        return null;
    }
}
export function getClientsubscriptionType() {
    if (localStorage.getItem("current_user") && JSON.parse(localStorage.getItem("current_user")).client) {
        return JSON.parse(localStorage.getItem("current_user")).client.subscription_type;
    } else {
        return null;
    }
}