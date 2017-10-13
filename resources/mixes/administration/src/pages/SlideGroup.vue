<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/slide/group/list`, {
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
                    vm.parent.id = to.query.id;
                    vm.parent.name = to.query.name;
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
                categoryDeleteId: '',
                columns: [
                    {
                        key: 'name',
                        title: '组图名称',
                        width: 260,
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
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.$router.push({
                                                path: '/slide/group/edit',
                                                query: {
                                                    id: data.row.alias,
                                                    name: data.row.name,
                                                },
                                            });
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                }, '设置'),
                                h('i-button', {
                                    on: {
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
                                    props: {
                                        size: 'small',
                                        type: 'ghost',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, '编辑'),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.deleteGroupModal = true;
                                            self.categoryDeleteId = data.row.alias;
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
                        width: 300,
                    },
                ],
                deleteGroupModal: false,
                deleteRules: {
                    group_id: [
                        {
                            message: '组图ID不能为空',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                },
                groupAdd: {
                    group_id: '',
                    group_name: '',
                    group_show: '是',
                },
                groupDelete: {
                    group_id: '',
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
                    per_page: 0,
                    total: 0,
                },
                parent: {
                    id: '',
                    name: '',
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
            changePage(page) {
                const self = this;
                self.$loading.start();
                self.$notice.open({
                    title: '正在搜索数据...',
                });
                self.$http.post(`${window.api}/slide/group/list?page=${page}`, {
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
                    injection.loading.finish();
                    self.$notice.open({
                        title: '搜索数据完成！',
                    });
                });
            },
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            refreshData() {
                const self = this;
                self.$loading.start();
                self.$notice.open({
                    title: '正在刷新数据...',
                });
                self.$http.post(`${window.api}/slide/group/list`, {
                    category_id: self.parent.id,
                }).then(response => {
                    const dataList = response.data.data;
                    self.list = dataList.data.map(item => {
                        item.loading = false;
                        return item;
                    });
                    self.page.total = dataList.total;
                    self.page.current_page = dataList.current_page;
                    self.page.per_page = dataList.per_page;
                    self.$loading.finish();
                    self.$notice.open({
                        title: '刷新数据完成！',
                    });
                });
            },
            submitAddGroup() {
                const self = this;
                let status = self.groupAdd.group_show;
                let count = 0;
                const reg = /^\d*$/;
                const value = self.groupAdd.group_id;
                if (self.groupAdd.group_show === '是') {
                    status = 1;
                } else {
                    status = 0;
                }
                if (!reg.test(value) && value !== '') {
                    count = -1;
                }
                if (count === -1) {
                    self.$notice.error({
                        title: '分类id请填写数字！',
                    });
                } else {
                    const params = {
                        category_id: self.parent.id,
                        group_id: self.groupAdd.group_id,
                        group_name: self.groupAdd.group_name,
                        group_show: status,
                    };
                    self.loading = true;
                    injection.loading.start();
                    self.$refs.groupAdd.validate(valid => {
                        if (valid) {
                            self.$http.post(`${window.api}/slide/group/set`, params).then(response => {
                                if (response.data.code === 200) {
                                    self.$notice.open({
                                        title: '新增组图信息成功！',
                                    });
                                    self.addGroupModal = false;
                                    self.groupAdd.group_name = '';
                                    self.groupAdd.group_id = '';
                                    self.groupAdd.group_show = '是';
                                    self.refreshData();
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
                }
            },
            submitDeleteGroup() {
                const self = this;
                self.loading = true;
                injection.loading.start();
                self.$refs.groupDelete.validate(valid => {
                    console.log(valid);
                    if (valid && self.categoryDeleteId === self.groupDelete.group_id) {
                        self.$http.post(`${window.api}/slide/group/delete`, self.groupDelete).then(response => {
                            if (response.data.code === 200) {
                                self.$notice.open({
                                    title: '删除组图信息成功！',
                                });
                                self.deleteGroupModal = false;
                                self.groupDelete.group_id = '';
                                self.refreshData();
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
            submitSetGroup() {
                const self = this;
                let status = self.groupSet.group_show;
                self.loading = true;
                injection.loading.start();
                if (self.groupSet.group_show === '是') {
                    status = 1;
                } else {
                    status = 0;
                }
                const params = {
                    id: self.groupSetId,
                    group_id: self.groupSet.id,
                    group_name: self.groupSet.group_name,
                    group_show: status,
                };
                self.$refs.groupSet.validate(valid => {
                    if (valid) {
                        self.$http.post(`${window.api}/slide/group/update`, params).then(response => {
                            if (response.data.code === 200) {
                                self.$notice.open({
                                    title: '组图设置信息成功！',
                                });
                                self.slideGroupModal = false;
                                self.refreshData();
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
                <span>查看 "{{ parent.name }}" 组图</span>
            </div>
            <card :bordered="false">
                <div class="slide-list">
                    <i-button type="ghost" @click.native="addGroup">+新增组图</i-button>
                    <i-button type="text" icon="android-sync" class="refresh"
                              @click.native="refreshData">刷新</i-button>
                    <i-table class="slide-table"
                             :columns="columns"
                             :data="list"
                             ref="slideList"
                             highlight-row>
                    </i-table>
                    <div class="page">
                        <page :current="page.current_page"
                              @on-change="changePage"
                              :page-size="page.per_page"
                              :total="page.total"
                              v-if="page.total > page.per_page"
                              show-elevator></page>
                    </div>
                </div>
                <modal
                        v-model="slideGroupModal"
                        title="编辑组图" class="upload-picture-modal">
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
                        <i-form ref="groupDelete" :model="groupDelete" :rules="deleteRules">
                            <row>
                                <i-col>
                                    <p>删除后不可恢复，请输入组图ID：{{ categoryDeleteId }} 以确认删除</p>
                                    <form-item prop="group_id">
                                        <i-input v-model="groupDelete.group_id" style="width: 124px"></i-input>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col>
                                    <i-button :loading="loading" type="primary"
                                              @click.native="submitDeleteGroup">
                                        <span v-if="!loading">删除</span>
                                        <span v-else>正在删除…</span>
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