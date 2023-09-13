import axios from 'axios';

const API_URL_ADMIN = '/admin/book';
const API_URL = '/book';
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
        return this.service('post', API_URL_ADMIN+'/display', data);
    }
    updateStatus(data) {
        return this.service('post', API_URL_ADMIN+'/status', data);
    }

    checkIsMyBook(data) {
        return this.service('post', API_URL+'/checkIsMyBook', data);
    }
}

export default new Book();
