import axios from "axios";
import TokenService from "./token.service";

const instance = axios.create({
    baseURL: "http://88.198.55.85:8094/api",
    headers: {
        "Content-Type": "application/json",
    },
});

instance.interceptors.request.use(
    (config) => {
        const token = TokenService.getLocalAccessToken();
        if (token) {
            config.headers["Authorization"] = 'Bearer ' + token;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

instance.interceptors.response.use(
    (res) => {
        return res;
    },
    async (err) => {
        const originalConfig = err.config;

        if (originalConfig.url !== "/token" && err.response) {
            // Access Token was expired
            if (err.response.status === 401 && !originalConfig._retry) {
                originalConfig._retry = true;

                try {
                    const rs = await instance.post("/token", {
                        "refresh_token": TokenService.getLocalRefreshToken(),
                        "grant_type": "refresh_token",
                        "client_id": "OSXRGq3U0yNNyL7omz9b",
                        "client_secret": "ylszidb2yQ9TiDDTuLld"
                    });

                    const { access_token,refresh_token } = rs.data;
                    TokenService.updateLocalAccessToken(access_token,refresh_token);
                    return instance(originalConfig);
                } catch (_error) {
                    return Promise.reject(_error);
                }
            }
        }

        return Promise.reject(err);
    }
);

export default instance;
