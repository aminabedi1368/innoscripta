import axios from "axios";
import api from "./Api";
import TokenService from "./token.service";

const API_URL = "http://88.198.55.85:8094/api";

const register = (first_name, last_name, email, password) => {
    return axios.post(API_URL + "/users", {
        first_name,
        last_name,
        usernames: {
            email
        },
        password,
    });
};

const loginWithInterceptors = (username, password) => {
    return api
        .post("/token", {
            username,
            password,
            "grant_type": "password",
            "client_id": "OSXRGq3U0yNNyL7omz9b",
            "client_secret": "ylszidb2yQ9TiDDTuLld"
        })
        .then((response) => {
            if (response.data.user_entity) {
                TokenService.setUser(response.data.user_entity, response.data.access_token, response.data.refresh_token);
            }

            return response.data;
        });
};

const login = (username, password) => {
    return axios
        .post(API_URL + "/token", {
            username,
            password,
            "grant_type": "password",
            "client_id": "OSXRGq3U0yNNyL7omz9b",
            "client_secret": "ylszidb2yQ9TiDDTuLld"
        })
        .then((response) => {
            if (response.data.user_entity) {
                TokenService.setUser(response.data.user_entity);
                localStorage.setItem("access_token", response.data.access_token);
                localStorage.setItem("refresh_token", response.data.refresh_token);

            }

            return response.data;
        });
};
const getProfile = () => {
    const token = localStorage.getItem("access_token"); // Replace this with your actual bearer token
    return axios
        .get(API_URL + "/token/token_info/" + token)
        .then((response) => {
            if (response.data.user_entity) {
                localStorage.setItem("user_entity", JSON.stringify(response.data.user_entity));

            }
            return response.data.user_entity;
        });
};
const getHistoryWithInterceptors = (categoryFilter = 'general',
                                    timeFilter ,
                                    pageSize = 10,
                                    page = 1
) => {
    const params = {
        categoryFilter: categoryFilter,
        pageSize: pageSize,
        page: page,
    };
    if (timeFilter) {
        params.timeFilter = timeFilter;
    }
    return api
        .get("/users/history-search/", {
            params: params,
        })
        .then((response) => {
            return response.data;
        });
};
const AdvancedSearchWithInterceptors = ( source , category , pageSize = 100) => {
    const params = {
        source:source,
        category: category,
        pageSize: pageSize,
    };
    return api
        .get("/users/fetch-news/", {
            params: params,
        })
        .then((response) => {
            return response.data;
        });
};

const logout = () => {
    const token = localStorage.getItem("access_token"); // Replace this with your actual bearer token
    const config = {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    };
    return axios.delete(API_URL + "/token/revoke_token", config).then((response) => {
        TokenService.removeUser();
        localStorage.removeItem("access_token");
        localStorage.removeItem("refresh_token");
        return response.data;
    });
};
const verify = (type, value, code) => {
    console.log("type,value,code", type, value, code);

    return axios.post(API_URL + "/user_identifiers/verify", {
        type,
        value,
        code
    }).then((response) => {
        console.log("response", response.data);

        return response.data;
    });
};
const updatePass = (old_password, new_password) => {
    const token = localStorage.getItem("access_token"); // Replace this with your actual bearer token
    const config = {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    };
    return axios.put(API_URL + "/users/change-password", {
        old_password,
        new_password,
    }, config).then((response) => {
        console.log("response", response.data);
        return response.data;
    });
};
const updatePassWithInterceptors = (old_password, new_password) => {
    return api.put("/users/change-password", {
        old_password,
        new_password,
    }).then((response) => {
        console.log("response", response.data);
        return response.data;
    });
};
const UploadAvatar = (selectedImage) => {
    const token = localStorage.getItem("access_token"); // Replace this with your actual bearer token
    const config = {
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "multipart/form-data",
        },
    };
    const data = new FormData();
    data.append("avatar", selectedImage);
    return axios
        .post(API_URL + "/users/avatar", data, config)
        .then((response) => {
            return response.data;
        })
};

const getCurrentUser = () => {
    return JSON.parse(localStorage.getItem("user_entity"));
};

const logined = () => {
    if (localStorage.getItem("user_entity")) {
        return true;
    } else {
        return false;
    }
};

const AuthService = {
    register,
    login,
    logout,
    getCurrentUser,
    verify,
    logined,
    updatePass,
    getProfile,
    UploadAvatar,
    loginWithInterceptors,
    updatePassWithInterceptors,
    getHistoryWithInterceptors,
    AdvancedSearchWithInterceptors
}
export default AuthService;
