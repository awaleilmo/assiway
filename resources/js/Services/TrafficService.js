import axios from 'axios';

const API_URL = '/traffic';
class Traffic {
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

    trafficBook(book) {
        return this.service('get', API_URL+'/book/' + book);
    }
    statistics() {
        return this.service('get', API_URL+'/statistics');
    }
}

export default new Traffic();
