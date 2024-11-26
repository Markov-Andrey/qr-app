import { api, request } from '../api/api.js';

class ApiService {
    constructor() {
        this.withToken = true;
    }

    // async organization(id) {
    //     return request(() => api(this.withToken).get(`/api/organization/${id}`));
    // }

    async login(data) {
        return request(() => api().post(`/login`, data));
    }
    async menuItems() {
        return request(() => api().get(`api/menu-items`));
    }
}
export const apiService = new ApiService();
