export default function (injection) {
    window.console.log('Before:', injection);
    injection.useSidebarExtension({
        path: '/slide',
        title: '幻灯片',
    });
    window.console.log('After:', injection);
}