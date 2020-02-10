import VueRouter from 'vue-router';

import Admin from './views/Admin.vue'
import Login from './views/Auth/Login'
import User from './views/Auth/User.vue'
import Role from './views/Auth/Role.vue'
import Permission from './views/Auth/Permission.vue'
import Court from './views/CourtBooking/Court.vue'
import Settings from './views/CourtBooking/Settings.vue'
import Profile from './views/Setting/Profile.vue'
import Subscription from './views/Setting/Subscription.vue'
import Order from './views/Setting/Order.vue'
import Invoice from './views/Setting/Invoice.vue'
import Facility from './views/Facility.vue'
import Booking from './views/Facility/Booking.vue'
import Resource from './views/Facility/Resource.vue'
import CourtBooking from './views/Facility/CourtBooking.vue'

// let basePath = document.querySelector('#app').getAttribute('base-path').trim().trimRight('/')
// let prefix = document.querySelector('#app').getAttribute('prefix').trim().trimRight('/')

// if(basePath.charAt(0) != '/') {
//     basePath = '/' + basePath;
// }

// if(prefix.charAt(0) != '/') {
//     prefix = '/' + prefix;
// }

// localStorage.setItem('playercoach.basePath', basePath)
// localStorage.setItem('playercoach.prefix', prefix)
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
            path: prefix+'/facility',
            name: 'facility',
            component: Facility,
            meta: {
                authorize: true,
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'facility',
                        display: 'Faciliity'
                    }
                ]
            }
        },
        {
            path: prefix+'/facility/bookings',
            name: 'booking',
            component: Booking,
            meta: {
                authorize: true,
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'facility',
                        display: 'Faciliity'
                    },
                    {
                        name: 'booking',
                        display: 'Bookings'
                    }
                ]
            }
        },
        {
            path: prefix+'/facility/resources',
            name: 'resource',
            component: Resource,
            meta: {
                authorize: true,
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'facility',
                        display: 'Faciliity'
                    },
                    {
                        name: 'resource',
                        display: 'Resources'
                    }
                ]
            }
        },
        {
            path: prefix+'/facility/courts',
            name: 'court',
            component: CourtBooking,
            meta: {
                authorize: true,
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'court',
                        display: 'Faciliity'
                    },
                    {
                        name: 'resource',
                        display: 'Courts'
                    }
                ]
            }
        },
        {
            path: prefix+'/users',
            name: 'user',
            component: User,
            meta: {
                authorize: true,
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
                authorize: true,
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
                authorize: true,
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
        // {
        //     path: '/courtbooking/courts',
        //     name: 'court',
        //     component: Court,
        //     meta: {
        //         authorize: true,
        //         breadcrumbs: [
        //             {
        //                 name: 'admin',
        //                 display: 'Admin'
        //             },
        //             {
        //                 name: 'court',
        //                 display: 'Courts'
        //             }
        //         ]
        //     }
        // },
        {
            path: '/courtbooking/settings',
            name: 'settings',
            component: Settings,
            meta: {
                authorize: true,
                breadcrumbs: [
                    {
                        name: 'admin',
                        display: 'Admin'
                    },
                    {
                        name: 'settings',
                        display: 'Settings'
                    }
                ]
            }
        },
        {
            path: '/settings/profile',
            name: 'profile',
            component: Profile,
            meta: {
                authorize: true,
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
                authorize: true,
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
                authorize: true,
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
                authorize: true,
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

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.authorize)) {
        if (localStorage.getItem('playercoach.authToken') == null) {
            router.push({
                name: "login", 
                params: {nextUrl: to.fullPath}
            })
        }else if(new Date().getTime() > localStorage.getItem('playercoach.authTokenExpiry')){
            localStorage.removeItem('playercoach.user')
            localStorage.removeItem('playercoach.authToken')
            localStorage.removeItem('playercoach.authTokenExpiry')
            router.push({
                name: "login", 
                params: {nextUrl: to.fullPath}
            })
        } else {
            next() 
        }
    } else {
        next()
    }
})

 export default router;