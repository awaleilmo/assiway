import axios from "axios";


const API_URL = '/admin/invoice';

class Invoice {
    service(method, url, data) {
        return axios({
            url: url,
            method: method,
            data: data
        })
            .then(response => {
                return { success: true, data: response.data };
            })
            .catch(error => {
                return { success: false, data: error.response.data.message };
            });
    }
    updateStatus(data) {
        return this.service('post', API_URL+'/status', data);
    }
}

export default new Invoice();
