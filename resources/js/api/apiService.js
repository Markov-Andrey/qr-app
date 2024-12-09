import { api, request } from '../api/api.js';

class ApiService {
    constructor() {
        this.withToken = true;
    }
    async login(data) {
        return request(() => api().post(`api/login`, data));
    }
    async register(data) {
        return request(() => api().post('api/signup/', data));
    }
    async history() {
        return request(() => api(this.withToken).get('api/history/'));
    }
    async uploadFile(data) {
        const params = { codes: data.codes };
        return request(() => api(this.withToken).get('api/upload/', { params }));
    }

    async resetPassword(data) {
        return request(() => api().post('api/reset-password/', data));
    }
    async updatePassword(data) {
        return request(() => api().post('api/update-password/', data));
    }
}
export const apiService = new ApiService();
