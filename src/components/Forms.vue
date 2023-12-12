<script setup>
    import { ref } from 'vue';
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    
    const title = ref('');
    const content = ref('');
    
    function formSubmit() {
        createPost();
    }
    
    async function createPost() {
        const response = await axios.post(dashboardpressExtra.admin_url+'/wp-json/dashboardpress/v1/news', {
            'title' : title.value,
            'content': content.value
        }, {
            headers: {
                'X-WP-Nonce': dashboardpressExtra.wp_rest_nonce,
                'credentials': 'include',
            },
        });
        console.log(response.data);
    }

    </script>
    
    <template>
        <div>
            <input type="text" v-model="title" placeholder="Title"> <br>
            <textarea v-model="content" placeholder="Content"></textarea><br>
            <button class="btn-primary" @click="formSubmit()">Submit</button>
        </div>
    </template>
    
    <style>
    /* Your CSS styles here */
    </style>
    