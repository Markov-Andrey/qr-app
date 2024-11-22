// @ts-ignore
import { api, request } from '~/services/api';

class ApiService {
    private withToken: boolean = true;

    // async organization(id: string) {
    //     return request(() => api(this.withToken).get(`/api/organization/${id}`));
    // }
    async login(data: Record<string, any>) {
        return request(() => api().post(`/login`, data));
    }
    async menuItems() {
        return request(() => api().get(`/menu-items`));
    }
}

export const apiService = new ApiService();
