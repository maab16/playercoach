import VueRouter from 'vue-router';

// import App from './views/App'
import Login from './views/Login'
import Admin from './views/Admin.vue'
import User from './views/User.vue'
import Role from './views/Role.vue'
import Permission from './views/Permission.vue'

// let basePath = document.querySelector('#app').getAttribute('base-path').trim().trimRight('/')
// let prefix = document.querySelector('#app').getAttribute('prefix').trim().trimRight('/')

// if(basePath.charAt(0) != '/') {
//     basePath = '/' + basePath;
// }

// if(prefix.charAt(0) != '/') {
//     prefix = '/' + prefix;
// }

// localStorage.setItem('dbm.basePath', basePath)
// localStorage.setItem('dbm.prefix', prefix)
let prefix = '/admin';
// Set Routes

const router = new VueRouter({
     mode: 'history',
     linkActiveClass: "active",
     routes: [
        {
            path: prefix,
            name: 'admin',
            component: Admin,
            meta: {
                authorize: true,
            }
        },
        {
            path: prefix+'/users',
            name: 'user',
            component: User,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'user',
                        display: 'Users'
                    }
                ]
            }
        },
        {
            path: prefix+'/roles',
            name: 'role',
            component: Role,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'role',
                        display: 'Roles'
                    }
                ]
            }
        },
        {
            path: prefix+'/permissions',
            name: 'permission',
            component: Permission,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'permission',
                        display: 'Permissions'
                    }
                ]
            }
        },
        {
            path: prefix+'/login',
            name: 'login',
            component: Login,
            meta: {
                breadcrumbs: [
                    {
                        name: 'database',
                        display: 'Database'
                    },
                    {
                        name: 'login',
                        display: 'Login'
                    }
                ]
            }
        }
     ],
 });

// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.authorize)) {
//         if (localStorage.getItem('dbm.authToken') == null) {
//             router.push({
//                 name: "login", 
//                 params: {nextUrl: to.fullPath}
//             })
//         }else if(new Date().getTime() > localStorage.getItem('dbm.authTokenExpiry')){
//             localStorage.removeItem('dbm.user')
//             localStorage.removeItem('dbm.authToken')
//             localStorage.removeItem('dbm.authTokenExpiry')
//             router.push({
//                 name: "login", 
//                 params: {nextUrl: to.fullPath}
//             })
//         } else {
//             next() 
//         }
//     } else {
//         next()
//     }
// })

 export default router;