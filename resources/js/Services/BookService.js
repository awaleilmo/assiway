import axios from 'axios';

const API_URL = '/admin/book';

class Book {
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

    updateDisplay(data) {
        return this.service('post', API_URL+'/display', data);
    }
    updateStatus(data) {
        return this.service('post', API_URL+'/status', data);
    }
}

export default new Book();
