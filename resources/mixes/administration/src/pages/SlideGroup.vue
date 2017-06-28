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
                        render() {
                            return `<dropdown>
                                    <i-button type="ghost">设置<icon type="arrow-down-b"></icon></i-button>
                                    <dropdown-menu slot="list">
                                    <dropdown-item @click.native="editCategory">编辑分类信息</dropdown-item>
                                    <dropdown-item name="goodSku" @click.native="lookGroup">查看组图</dropdown-item>
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
                </tab-pane>
            </tabs>
        </div>
    </div>
</template>