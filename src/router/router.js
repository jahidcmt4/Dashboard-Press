import {createRouter, createWebHashHistory} from 'vue-router'
import Dashboard from '../components/Dashboard.vue'
import GetHelp from '../components/GetHelp.vue'
import Report from '../components/Report.vue'

const routes = [
    {
        path : '/',
        component : Dashboard
    },
    {
        path : '/help',
        component : GetHelp
    },
    {
        path : '/report',
        component : Report
    }
]

const route = createRouter({
    history: createWebHashHistory(),
    routes
});

export default route;