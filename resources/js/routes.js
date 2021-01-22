import Home from './components/Home';
import DashBoard from './components/DashBoard';
import About from './components/About';
import NotFound from './components/NotFound';
import Register from './components/auth/Register';
import Login from './components/auth/Login';
import Chat from './components/Chat';
import axios from 'axios';
import store from './store';

export default{
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '*',
            component: NotFound,
            name: 'notfound'
        },
        {
            path: '/',
            component: Home,
            name: 'home'
        },
        {
            path: '/about',
            component: About
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/login',
            component: Login,
            name: 'login'
        },
        {
            path: '/dashboard',
            component: DashBoard,
            name: 'dashboard',
            beforeEnter: (to, from , next) => {
                if(store.getters.user == null){
                    axios.get('/api/authenticated').then(() => {
                        store.dispatch('fetchUser')
                        next()
                    }).catch(() => {
                        return next({name: "login"})
                    })
                }else{
                    next()
                }
            }
        },
        {
            path: '/chat/:id',
            component: Chat,
            beforeEnter: (to, from , next) => {
                if(store.getters.user == null){
                    axios.get('/api/authenticated').then(() => {
                        store.dispatch('fetchUser')
                        next()
                    }).catch(() => {
                        return next({name: "login"})
                    })
                }else{
                    next()
                }
            }
        }
    ]
}
