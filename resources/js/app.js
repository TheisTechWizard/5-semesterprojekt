import { createApp } from "vue";
import axios from "axios";
import router from "./router";
import App from "./views/App.vue";

///////////////////////////////////////////////////////////////////////

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "/api";

axios.get("/sanctum/csrf-cookie").then(() => {
    const app = createApp(App);
    app.use(router);
    app.mount("#app");
});
