import Slide from '../pages/Slide.vue';

export default function (injection) {
    injection.useExtensionRoute([
        {
            beforeEnter: injection.middleware.requireAuth,
            component: Slide,
            path: 'slide',
        },
    ]);
}