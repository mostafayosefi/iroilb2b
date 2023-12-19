<template>
    <router-view :site="site" :user="user" @getUser="getUser()" :key="$route.path"></router-view>
</template>

<script>
import axios from "axios";

export default {
    emits: ['getUser'],
    data() {
        return {
            lang: 'fa',
            site: {
                logoDark: '',
                logoLight: '',
                title: '',
                header: [],
            },
            user: {
                name: '',
                step: ''
            }
        }
    },
    methods: {
        getUser() {
            if (this.$cookies.isKey('user')) {
                axios.get('/user', {
                    params: {
                        'api_token': this.$cookies.get('user').token,
                        'id': this.$cookies.get('user').id
                    }
                }).then(response => {
                    this.user.name = response.data.name
                    this.user.step = response.data.step
                })
            }
        }
    },
    beforeCreate() {
        if (this.$cookies.isKey('user')) {
            axios.get('/user', {
                params: {
                    'api_token': this.$cookies.get('user').token,
                    'id': this.$cookies.get('user').id
                }
            }).then(response => {
                this.user.name = response.data.name
                this.user.step = response.data.step
            })
        }
        axios.get('/meno').then(response => {
            if (response.data != 'null') {
                for (const responseElement of response.data.meno) {
                    this.site.header.push({
                        text: {
                            fa: responseElement.text.fa,
                            en: responseElement.text.en
                        },
                        link: responseElement.link,
                        id: responseElement.id
                    },);
                }
            }
        });
        axios.get('/sitesetting').then(response => {
            if (response.data.status == 204) {
            } else {
                this.site.logoDark = this.$sitename + 'upload/site/' + response.data.data.logoDark;
                this.site.logoLight = this.$sitename + 'upload/site/' + response.data.data.logoLight;
                this.site.menu = response.data.data.menu
                if (this.$route.params.lang == 'fa') {
                    this.site.title = response.data.data.titleFa;
                } else {
                    this.site.title = response.data.data.titleEn;
                }
            }
        })
    },
}
</script>
