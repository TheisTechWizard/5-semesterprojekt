import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import basicSsl from "@vitejs/plugin-basic-ssl";

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ["resources/scss/app.scss", "resources/js/app.js"],
//             refresh: true,
//         }),
//         // vue({
//         //     template: {
//         //         transformAssetUrls: {
//         //             base: null,
//         //             includeAbsolute: false,
//         //         },
//         //     },
//         // }),
//         vue(),
//         server({
//             https: true,
//             host: "localhost",
//         }),
//     ],
// });

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/scss/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
