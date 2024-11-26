import axios from 'axios';

const API_BASE_URL = 'http://127.0.0.1:8000';

const request = async (requestFn) => {
    try {
        return await requestFn();
    } catch (error) {
        console.error(error.response?.data?.message || error.message);
        throw error;
    }
};

const api = (useToken = false) => {
    const instance = axios.create({
        baseURL: API_BASE_URL,
        headers: {
            'Content-Type': 'application/json',
        },
    });

    instance.interceptors.request.use(
        (request) => {
            if (useToken) {
                const authToken = localStorage.getItem('auth_token');
                request.headers.Authorization = `Bearer ${authToken}`;
            }
            return request;
        },
        (error) => Promise.reject(error)
    );

    instance.interceptors.response.use(
        (response) => response,
        (error) => {
            console.error(error.response?.data?.message || error.message);
            return Promise.reject(error);
        }
    );

    return instance;
};

export { api, request };
