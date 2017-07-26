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
            const self = this;
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
                        key: 'name',
                        title: '组图名称',
                        width: 220,
                    },
                    {
                        align: 'center',
                        key: 'alias',
                        title: '组图ID',
                        width: 200,
                    },
                    {
                        key: 'show',
                        render(h, data) {
                            return h('i-switch', {
                                props: {
                                    size: 'large',
                                    value: data.row.show,
                                },
                                scopedSlots: {
                                    close() {
                                        return h('span', '关闭');
                                    },
                                    open() {
                                        return h('span', '开启');
                                    },
                                },
                            });
                        },
                        title: '显示',
                    },
                    {
                        align: 'center',
                        key: 'action',
                        render(h, data) {
                            return h('div', [
                                h('dropdown', {
                                    scopedSlots: {
                                        list() {
                                            return h('dropdown-menu', [
                                                h('dropdown-item', {
                                                    nativeOn: {
                                                        click() {
                                                            self.groupSet.id
                                                                    = data.row.alias;
                                                            self.groupSetId
                                                                    = data.row.alias;
                                                            self.groupSet.group_name
                                                                    = data.row.name;
                                                            self.groupSet.group_show
                                                                    = data.row.show;
                                                            if (data.row.show === 1) {
                                                                self.groupSet.group_show = '是';
                                                            } else {
                                                                self.groupSet.group_show = '否';
                                                            }
                                                            self.slideGroupModal = true;
                                                        },
                                                    },
                                                }, '组图基础设置'),
                                                h('dropdown-item', {
                                                    nativeOn: {
                                                        click() {
                                                            self.editPicture();
                                                        },
                                                    },
                                                    props: {
                                                        name: 'goodSku',
                                                    },
                                                }, '编辑图片内容'),
                                            ]);
                                        },
                                    },
                                }, [
                                    h('i-button', {
                                        props: {
                                            size: 'small',
                                            type: 'ghost',
                                        },
                                    }, [
                                        '设置',
                                        h('icon', {
                                            props: {
                                                type: 'arrow-down-b',
                                            },
                                        }),
                                    ]),
                                ]),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.deleteGroupModal = true;
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, '删除'),
                            ]);
                        },
                        title: '操作',
                        width: 200,
                    },
                ],
                deleteGroupModal: false,
                groupAdd: {
                    group_id: '',
                    group_name: '',
                    group_show: '是',
                },
                groupDelete: {
                    id: '',
                },
                groupSet: {
                    id: '',
                    group_name: '',
                    group_show: '',
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
                groupSetId: '',
                setRules: {
                    group_name: [
                        {
                            message: '组图名称不能为空 ',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                },
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
                if (self.groupAdd.group_show === '是') {
                    self.groupAdd.group_show = 1;
                } else {
                    self.groupAdd.group_show = 0;
                }
                const params = {
                    category_id: self.parent.id,
                    group_id: self.groupAdd.group_id,
                    group_name: self.groupAdd.group_name,
                    group_show: self.groupAdd.group_show,
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
                injection.loading.start();
                if (self.groupSet.group_show === '是') {
                    self.groupSet.group_show = 1;
                } else {
                    self.groupSet.group_show = 0;
                }
                const params = {
                    id: self.groupSetId,
                    group_id: self.groupSet.id,
                    group_name: self.groupSet.group_name,
                    group_show: self.groupSet.group_show,
                };
                self.$refs.groupSet.validate(valid => {
                    if (valid) {
                        self.$http.post(`${window.slideApi}/slide/group/update`, params).then(response => {
                            if (response.data.code === 200) {
                                self.$notice.open({
                                    title: '组图设置信息成功！',
                                });
                                this.slideGroupModal = false;
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
                        <i-form ref="groupSet" :model="groupSet" :rules="setRules" :label-width="100">
                            <row>
                                <i-col span="14">
                                    <form-item label="组图名称" prop="group_name">
                                        <i-input v-model="groupSet.group_name"></i-input>
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
                                        <radio-group v-model="groupSet.group_show">
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
                                        <radio-group v-model="groupAdd.group_show">
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