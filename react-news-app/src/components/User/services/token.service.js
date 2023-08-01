const getLocalRefreshToken = () => {
    return localStorage.getItem("refresh_token");
};

const getLocalAccessToken = () => {
    return localStorage.getItem("access_token");
};

const updateLocalAccessToken = (access_token,refresh_token) => {
    localStorage.setItem("access_token", access_token);
    localStorage.setItem("refresh_token", refresh_token);
};

const getUser = () => {
    return JSON.parse(localStorage.getItem("user_entity"));
};

const setUser = (user,access_token,refresh_token) => {
    localStorage.setItem("user_entity", JSON.stringify(user));
    localStorage.setItem("access_token", access_token);
    localStorage.setItem("refresh_token", refresh_token);


};

const removeUser = () => {
    localStorage.removeItem("user_entity");
};

const TokenService = {
    getLocalRefreshToken,
    getLocalAccessToken,
    updateLocalAccessToken,
    getUser,
    setUser,
    removeUser,
};

export default TokenService;
