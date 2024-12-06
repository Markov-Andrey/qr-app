import { api, request } from '../api/api.js';

class ApiService {
    constructor() {
        this.withToken = true;
    }
    async login(data) {
        return request(() => api().post(`api/login`, data));
    }
    async uploadFile(data) {
        const params = { codes: data.codes };
        return request(() => api(this.withToken).get('api/upload/', { params }));
    }
    async register(data) {
        return request(() => api().post('api/signup/', data));
    }
}
export const apiService = new ApiService();
