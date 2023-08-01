<template>
            <div class="row justify-content-center" style="height:350px; background-color:#FFF5EE">
                    <infinite-slide-bar duration="40s" style="width:950px">
                        <div class="items">
                            <div v-for="item in announce" :key="item.key">
                            <div>
                                <div class="f-w-bold" style="display: flex; justify-content:space-evenly; font-weight:bold;
                                font-size:25px; padding-top:120px">
                                {{ item.title }}
                                </div><br>
                                <div style="display: flex; justify-content:space-evenly; padding-left:100px; padding:'5px 0'">
                                {{ item.content }}
                                </div>
                            </div>
                            </div>
                        </div>
                    </infinite-slide-bar>
            </div>
</template>

<script>
    import carousel from "vue-owl-carousel";
    import axios from 'axios';
    import Vue from 'vue';
    import InfiniteSlideBar from 'vue-infinite-slide-bar';

    Vue.component('InfiniteSlideBar', InfiniteSlideBar)
    export default {
    props: {
        msg: String
    },
    data: function() {
        return {
            announce: [],
            response: [],
        }   
    },
    mounted() {
        axios
            .get('/api/view-announcement')
            .then(response => {
                this.announce = response.data;
            });
        },
    };
</script>
<style> 
    .items { 
        display: flex; 
        justify-content: space-evenly;
    } 
</style>

