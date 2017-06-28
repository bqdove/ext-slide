<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('setting');
            });
        },
        data() {
            return {};
        },
        methods: {},
    };
</script>
<template>
    <div class="setting-wrap">
        <div class="slide-wrap">
            <tabs value="name1">
                <tab-pane label="轮播图插件" name="name1">
                    <card :bordered="false">
                        <div class="prompt-box">
                            <p>关于</p>
                            <p>删除分类前，请先删除分类下的所有组图</p>
                        </div>
                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>