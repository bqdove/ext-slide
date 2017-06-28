<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('setting');
            });
        },
        data() {
            return {
                self: this,
                slideColumns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'categoryName',
                        title: '分类名称',
                        width: 240,
                    },
                    {
                        key: 'categoryId',
                        title: '分类ID',
                    },
                    {
                        align: 'center',
                        key: 'action',
                        render(row, column, index) {
                            return `<dropdown>
                                    <i-button type="ghost">设置<icon type="arrow-down-b"></icon></i-button>
                                    <dropdown-menu slot="list">
                                    <dropdown-item>编辑分类信息</dropdown-item>
                                    <dropdown-item name="goodSku">查看组图</dropdown-item>
                                    </dropdown-menu></dropdown>
                                    <i-button @click.native="remove(${index})" class="delete-ad"
                                     type="ghost">删除</i-button>`;
                        },
                        title: '操作',
                        width: 180,
                    },
                ],
                slideData: [
                    {
                        categoryId: '3464',
                        categoryName: '首页轮播图-家用电器',
                    },
                    {
                        categoryId: '4643',
                        categoryName: '首页轮播图-家用电器',
                    },
                    {
                        categoryId: '4676',
                        categoryName: '首页轮播图-家用电器',
                    },
                    {
                        categoryId: '1234',
                        categoryName: '首页轮播图-家用电器',
                    },
                ],
            };
        },
        methods: {
            remove(index) {
                this.slideData.splice(index, 1);
            },
        },
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
                        <div class="slide-list">
                            <i-button type="ghost">+新增分类</i-button>
                            <i-button type="text" icon="android-sync" class="refresh">刷新</i-button>
                            <i-table class="slide-table"
                                     :columns="slideColumns"
                                     :context="self"
                                     :data="slideData"
                                     ref="slideList"
                                     highlight-row>
                            </i-table>
                        </div>
                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>