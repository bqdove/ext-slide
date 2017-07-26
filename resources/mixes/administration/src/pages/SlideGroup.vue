<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.slideApi}/slide/group/list`, {
                category_id: to.query.id,
            }).then(response => {
                const data = response.data.data;
                next(vm => {
                    if (data.data !== undefined) {
                        vm.list = data.data.map(item => {
                            item.loading = false;
                            return item;
                        });
                    }
                    vm.page.total = data.total;
                    vm.page.current_page = data.current_page;
                    vm.page.per_page = data.per_page;
                    vm.page.last_page = data.last_page;
                    vm.page.to = data.to;
                    vm.parent.id = to.query.id;
                    injection.loading.finish();
                    injection.sidebar.active('setting');
                });
            });
        },
        data() {
//            const self = this;
            return {
                addGroupModal: false,
                addRules: {
                    group_name: [
                        {
                            message: '组图名称不能为空 ',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                },
                columns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'group_name',
                        title: '组图名称',
                        width: 220,
                    },
                    {
                        align: 'center',
                        key: 'group_id',
                        title: '组图ID',
                        width: 200,
                    },
                    {
                        key: 'enabled',
                        render() {
                            return `<i-switch size="large" v-model="row.status">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                    </i-switch>`;
                        },
                        title: '显示',
                    },
                    {
                        align: 'center',
                        key: 'action',
                        render() {
                            return `<dropdown>
                                    <i-button type="ghost">设置<icon type="arrow-down-b"></icon></i-button>
                                    <dropdown-menu slot="list">
                                    <dropdown-item @click.native="groupSetting">组图基础设置</dropdown-item>
                                    <dropdown-item name="goodSku" @click.native="editPicture">编辑图片内容</dropdown-item>
                                    </dropdown-menu></dropdown>
                                    <i-button @click.native="remove" class="delete-ad"
                                     type="ghost">删除</i-button>`;
                        },
                        title: '操作',
                        width: 180,
                    },
                ],
                deleteGroupModal: false,
                groupAdd: {
                    enabled: '',
                    group_id: '',
                    group_name: '',
                },
                groupDelete: {
                    id: '',
                },
                groupSet: {
                    enabled: '',
                    id: '',
                    name: '',
                },
                list: [],
                loading: false,
                page: {
                    current_page: 1,
                    from: 1,
                    last_page: 0,
                    per_page: 0,
                    to: 0,
                    total: 0,
                },
                parent: {
                    id: '',
                },
                self: this,
                slideGroupModal: false,
            };
        },
        methods: {
            addGroup() {
                this.addGroupModal = true;
            },
            editPicture() {
                const self = this;
                self.$router.push({
                    path: 'group/edit',
                });
            },
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            groupSetting() {
                this.slideGroupModal = true;
            },
            remove() {
                this.deleteGroupModal = true;
            },
            submitAddGroup() {
                const self = this;
                self.loading = true;
                injection.loading.start();
                const params = {
                    category_id: self.parent.id,
                    group_id: self.groupAdd.group_id,
                    group_name: self.groupAdd.group_name,
                };
                self.$refs.groupAdd.validate(valid => {
                    if (valid) {
                        self.$http.post(`${window.slideApi}/slide/group/set`, params).then(response => {
                            if (response.data.code === 200) {
                                self.$notice.open({
                                    title: '新增组图信息成功！',
                                });
                                this.addGroupModal = false;
                                self.$http.post(`${window.slideApi}/slide/group/list`, {
                                    category_id: self.parent.id,
                                }).then(res => {
                                    const data = res.data.data;
                                    self.list = data.data.map(item => {
                                        item.loading = false;
                                        return item;
                                    });
                                    self.page.total = data.total;
                                    self.page.current_page = data.current_page;
                                    self.page.per_page = data.per_page;
                                    self.page.last_page = data.last_page;
                                    self.page.to = data.to;
                                    injection.loading.finish();
                                    injection.sidebar.active('setting');
                                });
                            }
                        }).catch(() => {}).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
            submitDeleteGroup() {
                const self = this;
                self.loading = true;
                self.$refs.groupDelete.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
            submitSetGroup() {
                const self = this;
                self.loading = true;
                self.$refs.groupSet.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="setting-wrap">
        <div class="slide-group">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>轮播图插件-查看组图</span>
            </div>
            <card :bordered="false">
                <div class="slide-list">
                    <i-button type="ghost" @click.native="addGroup">+新增组图</i-button>
                    <i-button type="text" icon="android-sync" class="refresh">刷新</i-button>
                    <i-table class="slide-table"
                             :columns="columns"
                             :data="list"
                             ref="slideList"
                             highlight-row>
                    </i-table>
                </div>
                <modal
                        v-model="slideGroupModal"
                        title="组图基础设置" class="upload-picture-modal">
                    <div>
                        <i-form ref="groupSet" :model="groupSet" :rules="ruleValidate" :label-width="100">
                            <row>
                                <i-col span="14">
                                    <form-item label="组图名称">
                                        <i-input v-model="groupSet.name"></i-input>
                                        <p class="tip">商城前台不显示，名称仅用于后台标记分类</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="组图ID">
                                        <i-input v-model="groupSet.id"></i-input>
                                        <p class="tip">可留空，系统会自动分配一个ID</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="是否显示">
                                        <radio-group v-model="groupSet.enabled">
                                            <radio label="是"></radio>
                                            <radio label="否"></radio>
                                        </radio-group>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item>
                                        <i-button :loading="loading" type="primary"
                                                  @click.native="submitSetGroup">
                                            <span v-if="!loading">确认提交</span>
                                            <span v-else>正在提交…</span>
                                        </i-button>
                                    </form-item>
                                </i-col>
                            </row>
                        </i-form>
                    </div>
                </modal>
                <modal
                        v-model="addGroupModal"
                        title="新增组图" class="upload-picture-modal">
                    <div>
                        <i-form ref="groupAdd" :model="groupAdd" :rules="addRules" :label-width="100">
                            <row>
                                <i-col span="14">
                                    <form-item label="组图名称" prop="group_name">
                                        <i-input v-model="groupAdd.group_name"></i-input>
                                        <p class="tip">商城前台不显示，名称仅用于后台标记分类</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="组图ID">
                                        <i-input v-model="groupAdd.group_id"></i-input>
                                        <p class="tip">可留空，系统会自动分配一个ID</p>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item label="是否显示">
                                        <radio-group v-model="groupAdd.enabled">
                                            <radio label="是"></radio>
                                            <radio label="否"></radio>
                                        </radio-group>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="14">
                                    <form-item>
                                        <i-button :loading="loading" type="primary"
                                                  @click.native="submitAddGroup">
                                            <span v-if="!loading">确认提交</span>
                                            <span v-else>正在提交…</span>
                                        </i-button>
                                    </form-item>
                                </i-col>
                            </row>
                        </i-form>
                    </div>
                </modal>
                <modal
                        v-model="deleteGroupModal"
                        title="删除" class="upload-picture-modal">
                    <div class="slide-category-delete-modal">
                        <i-form ref="groupDelete" :model="groupDelete" :rules="ruleValidate">
                            <row>
                                <i-col>
                                    <p>删除后不可恢复，请输入组图ID：{{ groupDelete.id }} 以确认删除</p>
                                    <i-input v-model="groupDelete.id" style="width: 124px"></i-input>
                                </i-col>
                            </row>
                            <row>
                                <i-col>
                                    <i-button :loading="loading" type="primary"
                                              @click.native="submitDeleteGroup">
                                        <span v-if="!loading">确认提交</span>
                                        <span v-else>正在提交…</span>
                                    </i-button>
                                </i-col>
                            </row>
                        </i-form>
                    </div>
                </modal>
            </card>
        </div>
    </div>
</template>