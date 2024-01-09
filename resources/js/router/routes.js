import App from "../views/App.vue";
import Login from "../views/Login.vue";
import MyCourses from "../views/MyCourses.vue";
import AdminPeople from "../views/AdminPeople.vue";
import AdminCourses from "../views/AdminCourses.vue";

const routes = [
    {
        path: "/login",
        component: Login,
        name: "login",
    },
    {
        path: "/my-courses",
        component: MyCourses,
        name: "my-courses",
    },
    {
        path: "/admin",
        component: AdminPeople,
        name: "admin",
    },
    {
        path: "/admin-courses",
        component: AdminCourses,
        name: "admin-courses",
    },
    // {
    //     path: '/dashboard',
    //     component: App,
    //     name: 'app',
    // }
];

export default routes;
