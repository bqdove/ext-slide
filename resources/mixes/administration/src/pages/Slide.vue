<script>
    import injection from '../helpers/injection';

    window.slideApi = 'https://allen.ibenchu.pw/api';
    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.slideApi}/slide/category/list`).then(response => {
                const data = response.data.data;
                next(vm => {
                    vm.list = data.data.map(item => {
                        item.loading = false;
                        return item;
                    });
                    vm.page.total = data.total;
                    vm.page.current_page = data.current_page;
                    vm.page.per_page = data.per_page;
                    vm.page.last_page = data.last_page;
                    vm.page.to = data.to;
                    vm.parent = to.query.parent;
                    injection.loading.finish();
                    injection.sidebar.active('setting');
                });
            });
        },
        data() {
            const self = this;
            return {
                addCategoryModal: false,
                addRules: {
                    category_id: [
                        {
                            message: '分类ID不能为空',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                    category_name: [
                        {
                            message: '分类名称不能为空',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                },
                categoryAdd: {
                    category_id: '',
                    category_name: '',
                },
                categoryDelete: {
                    id: '5346',
                },
                categoryEdit: {
                    id: '',
                    name: '',
                },
                columns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'category_name',
                        title: '分类名称',
                        width: 240,
                    },
                    {
                        key: 'category_id',
                        title: '分类ID',
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
                                                    on: {
                                                        click() {
                                                            self.editCategory();
                                                        },
                                                    },
                                                }, '编辑分类信息'),
                                                h('dropdown-item', {
                                                    on: {
                                                        click() {
                                                            self.lookGroup();
                                                        },
                                                    },
                                                    props: {
                                                        name: 'goodSku',
                                                    },
                                                }, '查看组图'),
                                                h('dropdown-item', '加入商品库'),
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
                                            self.remove(data.index);
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
                deleteCategoryModal: false,
                editCategoryModal: false,
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
                self: this,
            };
        },
        methods: {
            addCategory() {
                this.addCategoryModal = true;
            },
            editCategory() {
                this.editCategoryModal = true;
            },
            lookGroup() {
                const self = this;
                self.$router.push({
                    path: 'slide/group',
                });
            },
            remove() {
                this.deleteCategoryModal = true;
            },
            submitAddCategory() {
                const self = this;
                self.loading = true;
                injection.loading.start();
                self.$refs.categoryAdd.validate(valid => {
                    if (valid) {
                        self.$http.post(`${window.slideApi}/slide/category/set`, self.categoryAdd).then(response => {
                            if (response.data.data) {
                                self.$notice.open({
                                    title: '新增分类信息成功！',
                                });
                                this.addCategoryModal = false;
                                self.$http.post(`${window.slideApi}/slide/category/list`).then(res => {
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
            submitDeleteCategory() {
                const self = this;
                self.loading = true;
                self.$refs.categoryDelete.validate(valid => {
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
            submitEditCategory() {
                const self = this;
                self.loading = true;
                self.$refs.categoryEdit.validate(valid => {
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
        <div class="slide-wrap">
            <tabs value="name1">
                <tab-pane label="轮播图插件" name="name1">
                    <card :bordered="false">
                        <div class="prompt-box">
                            <p>关于</p>
                            <p>删除分类前，请先删除分类下的所有组图</p>
                        </div>
                        <div class="slide-list">
                            <i-button type="ghost" @click.native="addCategory">+新增分类</i-button>
                            <i-button type="text" icon="android-sync" class="refresh">刷新</i-button>
                            <i-table class="slide-table"
                                     :columns="columns"
                                     :data="list"
                                     ref="slideList"
                                     highlight-row>
                            </i-table>
                        </div>
                        <modal
                                v-model="editCategoryModal"
                                title="编辑分类信息" class="upload-picture-modal">
                            <div class="slide-category-modal">
                                <i-form ref="categoryEdit" :model="categoryEdit" :rules="ruleValidate" :label-width="100">
                                    <row>
                                        <i-col span="14">
                                            <form-item label="分类名称">
                                                <i-input v-model="categoryEdit.name"></i-input>
                                            </form-item>
                                        </i-col>
                                    </row>
                                    <row>
                                        <i-col span="14">
                                            <form-item label="分类ID">
                                                <i-input v-model="categoryEdit.id"></i-input>
                                            </form-item>
                                        </i-col>
                                    </row>
                                    <row>
                                        <i-col span="14">
                                            <form-item>
                                                <i-button :loading="loading" type="primary"
                                                          @click.native="submitEditCategory">
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
                                v-model="addCategoryModal"
                                title="新增分类" class="upload-picture-modal">
                            <div class="slide-category-modal">
                                <i-form ref="categoryAdd" :model="categoryAdd" :rules="addRules" :label-width="100">
                                    <row>
                                        <i-col span="14">
                                            <form-item label="分类名称" prop="category_name">
                                                <i-input v-model="categoryAdd.category_name"></i-input>
                                            </form-item>
                                        </i-col>
                                    </row>
                                    <row>
                                        <i-col span="14">
                                            <form-item label="分类ID" prop="category_id">
                                                <i-input v-model="categoryAdd.category_id"></i-input>
                                            </form-item>
                                        </i-col>
                                    </row>
                                    <row>
                                        <i-col span="14">
                                            <form-item>
                                                <i-button :loading="loading" type="primary"
                                                          @click.native="submitAddCategory">
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
                                v-model="deleteCategoryModal"
                                title="删除" class="upload-picture-modal">
                            <div class="slide-category-delete-modal">
                                <i-form ref="categoryDelete" :model="categoryDelete" :rules="ruleValidate">
                                    <row>
                                        <i-col>
                                            <p>删除后不可恢复，请输入分类ID：{{ categoryDelete.id }} 以确认删除</p>
                                            <i-input v-model="categoryDelete.id" style="width: 124px"></i-input>
                                        </i-col>
                                    </row>
                                    <row>
                                        <i-col>
                                            <i-button :loading="loading" type="primary"
                                                      @click.native="submitDeleteCategory">
                                                <span v-if="!loading">确认提交</span>
                                                <span v-else>正在提交…</span>
                                            </i-button>
                                        </i-col>
                                    </row>
                                </i-form>
                            </div>
                        </modal>
                    </card>
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>