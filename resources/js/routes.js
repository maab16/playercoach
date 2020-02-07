import VueRouter from 'vue-router';

import Admin from './views/Admin.vue'
import Login from './views/Auth/Login'
import User from './views/Auth/User.vue'
import Role from './views/Auth/Role.vue'
import Permission from './views/Auth/Permission.vue'
import Court from './views/CourtBooking/Court.vue'
import Resource from './views/CourtBooking/Resource.vue'
import Profile from './views/Setting/Profile.vue'
import Subscription from './views/Setting/Subscription.vue'
import Order from './views/Setting/Order.vue'
import Invoice from './views/Setting/Invoice.vue'

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
            path: '/courtbooking/courts',
            name: 'court',
            component: Court,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'court',
                        display: 'Courts'
                    }
                ]
            }
        },
        {
            path: '/courtbooking/resources',
            name: 'resource',
            component: Resource,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'resource',
                        display: 'Resources'
                    }
                ]
            }
        },
        {
            path: '/settings/profile',
            name: 'profile',
            component: Profile,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'profile',
                        display: 'Profile'
                    }
                ]
            }
        },
        {
            path: '/settings/subscriptions',
            name: 'subscription',
            component: Subscription,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'subscription',
                        display: 'Subscriptions'
                    }
                ]
            }
        },
        {
            path: '/settings/orders',
            name: 'order',
            component: Order,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'order',
                        display: 'Orders'
                    }
                ]
            }
        },
        {
            path: '/settings/invoices',
            name: 'invoice',
            component: Invoice,
            meta: {
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'invoice',
                        display: 'Invoices'
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