import {createRouter, createWebHashHistory} from 'vue-router'
import Dashboard from '../components/Dashboard.vue'
import GetHelp from '../components/GetHelp.vue'
import Report from '../components/Report.vue'
import News from '../components/News.vue'
import Leads from '../components/Leads.vue'
import Forms from '../components/Form.vue'

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
        path : '/news',
        component : News
    },
    {
        path : '/leads',
        component : Leads
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