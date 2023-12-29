<script setup>
import { ref,onBeforeMount } from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'

const leads = ref('')

// Retrive Leads
async function fetchNews() {
  try {
    const response = await axios.get(dashboardpressExtra.admin_url+'/wp-json/dashboardpress/v1/leads', {
        headers: {
          'X-WP-Nonce': dashboardpressExtra.wp_rest_nonce,
            'credentials': 'include',
        },
    });
    // return response.data;

    // leads.value = response.data.news;
    console.log(response.data);
  } catch (error) {
    console.error(error);
  }
}

onBeforeMount(() => {
  fetchNews();
});

</script>

<template>
<h1>Hi</h1>
</template>

<style scoped>

</style>