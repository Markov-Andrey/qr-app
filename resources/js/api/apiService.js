import { api, request } from '../api/api.js';

class ApiService {
    constructor() {
        this.withToken = true;
    }
    async login(data) {
        return request(() => api().post(`/login`, data));
    }
    async uploadFile(data) {
        return request(() => api().post(`api/upload/`, data));
    }
}
export const apiService = new ApiService();
