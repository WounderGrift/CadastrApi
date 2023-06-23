'use strict';

const app = new Vue({
    el: '#app',
    data: {
        cnModel: '',
        cnInfo: '',
    },
    methods: {
        async getTableCN(ev) {
            if (this.cnModel) {
                this.cnInfo = await $.ajax({
                    url: 'rest/get-data',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        cns: this.cnModel
                    },
                });
            }
        },
        clearTableCN() {
            this.cnModel = '';
            this.cnInfo = '';
        }

    }
});
