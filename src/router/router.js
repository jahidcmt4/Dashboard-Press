import {createRouter, createWebHashHistory} from 'vue-router'
import Dashboard from '../components/Dashboard.vue'
import GetHelp from '../components/GetHelp.vue'
import Report from '../components/Report.vue'
import Forms from '../components/Forms.vue'

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
    },
    {
        path : '/forms',
        component : Forms
    }
]

const route = createRouter({
    history: createWebHashHistory(),
    routes
});

export default route;