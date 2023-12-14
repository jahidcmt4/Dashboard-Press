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
        });
        console.log(response.data);
    }
    const isOpen = ref(false)

    </script>
    
    <template>
        <div class="dashboardpress-table rounded-xl bg-white p-5">
            <div class="dashboardpress-breadcrumb">
                <ul class="flex gap-1 items-center">
                    <li><a href="#" class="text-sm text-slate-500 font-semibold">Home</a></li>
                    <li class="text-sm text-slate-500 font-semibold">></li>
                    <li>From</li>
                </ul>
            </div>
            <div class="table-header">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl text-slate-500 font-bold">News</h2>
                    <button class="text-base font-semibold py-1.5 px-5 bg-blue-950 text-white rounded-md" @click="isOpen = true">Add News</button>
                </div>
            </div>
            <div class="relative rounded-xl overflow-auto">
                <div class="shadow-sm overflow-hidden my-8">
                <table class="border-collapse table-auto w-full text-sm">
                  <thead>
                    <tr>
                      <th class="border dark:border-slate-600 font-medium p-4 pl-8 pt-3 pb-3 text-slate-400 dark:text-slate-200 text-left">Song</th>
                      <th class="border dark:border-slate-600 font-medium p-4 pt-3 pb-3 text-slate-400 dark:text-slate-200 text-left">Artist</th>
                      <th class="border dark:border-slate-600 font-medium p-4 pr-8 pt-3 pb-3 text-slate-400 dark:text-slate-200 text-left">Year</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white dark:bg-slate-800">
                    <tr>
                      <td class="border border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                      <td class="border border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">Malcolm Lockyer</td>
                      <td class="border border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">1961</td>
                    </tr>
                    <tr>
                      <td class="border border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">Witchy Woman</td>
                      <td class="border border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">The Eagles</td>
                      <td class="border border-slate-100 dark:border-slate-700 p-4 pr-8 text-slate-500 dark:text-slate-400">1972</td>
                    </tr>
                    <tr>
                      <td class="border border-slate-200 dark:border-slate-600 p-4 pl-8 text-slate-500 dark:text-slate-400">Shining Star</td>
                      <td class="border border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">Earth, Wind, and Fire</td>
                      <td class="border border-slate-200 dark:border-slate-600 p-4 pr-8 text-slate-500 dark:text-slate-400">1975</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <div>
            <input type="text" v-model="title" placeholder="Title"> <br>
            <textarea v-model="content" placeholder="Content"></textarea><br>
            <button class="btn-primary" @click="formSubmit()">Submit</button>
        </div>

        <div
        v-show="isOpen"
        class="
          fixed
          inset-0
          flex
          items-center
          justify-center
          bg-gray-700 bg-opacity-50
        " :style="{zIndex: 999999}">
        <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
          <div class="flex items-center justify-between">
            <h3 class="text-2xl">Model Title</h3>
            <svg
              @click="isOpen = false"
              xmlns="http://www.w3.org/2000/svg"
              class="w-8 h-8 text-red-900 cursor-pointer"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
          <div class="mt-4">
            <p class="mb-4 text-sm">
              Lorem ipsum dolor sit, amet consectetur adipisicing elit.
              Voluptatibus qui nihil laborum quaerat blanditiis nemo explicabo
              voluptatum ea architecto corporis quo vitae, velit temporibus
              eaque quisquam in quis provident necessitatibus.
            </p>
            <button
              @click="isOpen = false"
              class="px-6 py-2 text-blue-800 border border-blue-600 rounded"
            >
              Cancel
            </button>
            <button class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded">
              Save
            </button>
          </div>
        </div>
      </div>

    </template>
    
    <style>
    /* Your CSS styles here */
    </style>
    