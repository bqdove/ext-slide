import Slide from '../pages/Slide.vue';
import SlideGroup from '../pages/SlideGroup.vue';

export default function (injection) {
    injection.useExtensionRoute([
        {
            beforeEnter: injection.middleware.requireAuth,
            component: Slide,
            path: 'slide',
        },
        {
            beforeEnter: injection.middleware.requireAuth,
            component: SlideGroup,
            path: 'slide/group',
        },
    ]);
}