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
                addCategoryModal: false,
                categoryAdd: {
                    id: '',
                    name: '',
                },
                categoryDelete: {
                    id: '5346',
                },
                categoryEdit: {
                    id: '',
                    name: '',
                },
                deleteCategoryModal: false,
                editCategoryModal: false,
                loading: false,
                self: this,
                slideColumns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'categoryName',
                        title: '组图名称',
                        width: 220,
                    },
                    {
                        align: 'center',
                        key: 'categoryId',
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
                                    <dropdown-item @click.native="editCategory">组图基础设置</dropdown-item>
                                    <dropdown-item name="goodSku" @click.native="lookGroup">编辑图片内容</dropdown-item>
                                    </dropdown-menu></dropdown>
                                    <i-button @click.native="remove" class="delete-ad"
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
                        status: true,
                    },
                    {
                        categoryId: '4643',
                        categoryName: '首页轮播图-家用电器',
                        status: true,
                    },
                    {
                        categoryId: '4676',
                        categoryName: '首页轮播图-家用电器',
                        status: true,
                    },
                    {
                        categoryId: '1234',
                        categoryName: '首页轮播图-家用电器',
                        status: true,
                    },
                ],
            };
        },
        methods: {
            addCategory() {
                this.addCategoryModal = true;
            },
            editCategory() {
                this.editCategoryModal = true;
            },
            goBack() {
                const self = this;
                self.$router.go(-1);
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
                self.$refs.categoryAdd.validate(valid => {
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
        <div class="slide-group">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>轮播图插件-查看组图</span>
            </div>
            <card :bordered="false">
                <div class="slide-list">
                    <i-button type="ghost" @click.native="addCategory">+新增组图</i-button>
                    <i-button type="text" icon="android-sync" class="refresh">刷新</i-button>
                    <i-table class="slide-table"
                             :columns="slideColumns"
                             :context="self"
                             :data="slideData"
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
                                <i-col span="16">
                                    <form-item label="分类名称">
                                        <i-input v-model="categoryEdit.name"></i-input>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="16">
                                    <form-item label="分类ID">
                                        <i-input v-model="categoryEdit.id"></i-input>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="16">
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
                        <i-form ref="categoryAdd" :model="categoryAdd" :rules="ruleValidate" :label-width="100">
                            <row>
                                <i-col span="16">
                                    <form-item label="分类名称">
                                        <i-input v-model="categoryAdd.name"></i-input>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="16">
                                    <form-item label="分类ID">
                                        <i-input v-model="categoryAdd.id"></i-input>
                                    </form-item>
                                </i-col>
                            </row>
                            <row>
                                <i-col span="16">
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
        </div>
    </div>
</template>